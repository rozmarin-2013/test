<?php

namespace App\Domain\Service;

use App\Domain\Entity\Notification;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateNotificationService
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function createFromArray(array $notification)
    {
        try {
            $dueDate = $notification['dueDate'] ? new \DateTime($notification['dueDate']) : null;
        } catch (\Exception $exception) {
            throw new \Exception($this->createErrorMessage(
                field: 'dueDate',
                number: (int)$notification['number'],
                message: $exception->getMessage(),
                value: $notification['dueDate']
            ));
        }

        $newNotification = new Notification(
            (int)$notification['number'],
            $this->sanitizeDescription((string)$notification['description']),
            $dueDate,
            $this->normalizePhone($notification['phone'])
        );

        $errors = $this->validator->validate($newNotification);

        if (count($errors) > 0) {
            $customErrors = [];
            foreach ($errors as $error) {
                /** @var ConstraintViolation $error */
                $field = $error->getPropertyPath();
                $message = $error->getMessage();
                $value = $error->getInvalidValue();
                $customErrors[] = $this->createErrorMessage(
                    $field,
                    $notification['number'],
                    $message,
                    $value
                );
            }
            throw new \Exception(json_encode($customErrors, JSON_UNESCAPED_UNICODE));
        }

        return $newNotification;
    }

    private function sanitizeDescription(string $desc): string
    {
        return htmlspecialchars(trim($desc), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    private function normalizePhone($phone): string
    {
        return preg_replace('/[^\d]/', '', (string)$phone);
    }

    private function createErrorMessage(string $field, int $number, string $message, mixed $value): string
    {
        return sprintf(
            'Błąd w polu "%s" (ID %s):  %s. Nieprawidłowa wartość: "%s"',
            $field,
            $number,
            $message,
            $value
        );
    }
}
