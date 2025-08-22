<?php

namespace App\Core\User\Application\Query\GetInactiveUserEmails;

use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetInactiveUserEmailsHandler
{
    public function __construct(private readonly UserRepositoryInterface $userRepository) {}

    public function __invoke(GetInactiveUserEmailsQuery $query): array
    {
        return $this->userRepository->findInactiveEmails();
    }
}
