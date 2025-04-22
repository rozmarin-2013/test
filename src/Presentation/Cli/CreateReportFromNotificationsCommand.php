<?php

namespace App\Presentation\Cli;

use App\Application\Service\LoadReportInterface;
use App\Application\Service\SaveReport;
use App\Domain\Service\CreateNotificationService;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

#[AsCommand(
    name: 'app:create-report',
    description: 'Creates a new user.',
)]
class CreateReportFromNotificationsCommand extends Command
{
    public function __construct(
        #[AutowireIterator('app.load_report_tag')]
        private iterable           $loader,
        private LoggerInterface $logger,
        private CreateNotificationService $createNotificationService,
        private SaveReport $saveReport,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'Who do you want to greet?');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $input->validate();
        $filePath = $input->getArgument('file');


        if (!file_exists($filePath)) {
            $output->writeln("<error>Plik nie istnieje: $filePath</error>");
            return Command::FAILURE;
        }

        $json = file_get_contents($filePath);

        if (empty($json)) {
            $output->writeln("<error>Plik jest pusty.</error>");
            return Command::FAILURE;
        }

        $notifications = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $output->writeln('<error>Niepoprawny format JSON: ' . json_last_error_msg() . '</error>');
            return Command::FAILURE;
        }

        $notificationsCollections = new ArrayCollection();
        $errorNotificationsCollections = new ArrayCollection();


        foreach ($notifications as $notification) {
            try {
                $notificationsCollections->add($this->createNotificationService->createFromArray($notification));
            } catch (\Exception $e) {
                $errorNotificationsCollections->add($notification);
                $output->writeln('<error>' . $e->getMessage() . '</error>');
                $this->logger->error($e->getMessage());
            }
        }

        $messages = [];
        /** @var LoadReportInterface $loader */
        foreach ($this->loader as $loader) {
            $loader->execute($notificationsCollections);
            $messages[] = $loader->getMessage();
        }

        $this->saveReport->save($errorNotificationsCollections->toArray(), 'report/error.json');

        $output->writeln([
            ...$messages,
            sprintf('Ogólna liczba przetworzonych wiadomości: %d', count($notifications))
        ]);

        return Command::SUCCESS;
    }
}