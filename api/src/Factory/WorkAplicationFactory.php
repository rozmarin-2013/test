<?php

namespace App\Factory;

use App\Entity\Level;
use App\Entity\Position;
use App\Entity\Status;
use App\Entity\WorkAplication;
use App\Repository\WorkAplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<WorkAplication>
 *
 * @method        WorkAplication|Proxy                     create(array|callable $attributes = [])
 * @method static WorkAplication|Proxy                     createOne(array $attributes = [])
 * @method static WorkAplication|Proxy                     find(object|array|mixed $criteria)
 * @method static WorkAplication|Proxy                     findOrCreate(array $attributes)
 * @method static WorkAplication|Proxy                     first(string $sortedField = 'id')
 * @method static WorkAplication|Proxy                     last(string $sortedField = 'id')
 * @method static WorkAplication|Proxy                     random(array $attributes = [])
 * @method static WorkAplication|Proxy                     randomOrCreate(array $attributes = [])
 * @method static WorkAplicationRepository|RepositoryProxy repository()
 * @method static WorkAplication[]|Proxy[]                 all()
 * @method static WorkAplication[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static WorkAplication[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static WorkAplication[]|Proxy[]                 findBy(array $attributes)
 * @method static WorkAplication[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static WorkAplication[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class WorkAplicationFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $levels = $this->entityManager->getRepository(Level::class)->findAll();
        $positions = $this->entityManager->getRepository(Position::class)->findAll();

        return [
            'email' => self::faker()->email(255),
            'firstname' => self::faker()->firstName(255),
            'lastname' => self::faker()->lastName(255),
            'level' => $levels[self::faker()->numberBetween(0,2)],
            'position' => $positions[self::faker()->numberBetween(0,2)],
            'salary' => self::faker()->randomFloat(2, 1000, 99999),
            'telephone' => self::faker()->randomNumber(9),
            'status' => self::faker()->randomElement(Status::cases())
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(WorkAplication $workAplication): void {})
        ;
    }

    protected static function getClass(): string
    {
        return WorkAplication::class;
    }
}
