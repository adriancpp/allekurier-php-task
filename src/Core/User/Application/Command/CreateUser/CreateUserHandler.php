<?php

namespace App\Core\User\Application\Command\CreateUser;

use App\Core\User\Domain\User;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User($command->email);
        $user->setActive(false);

        $this->userRepository->save($user);
        $this->userRepository->flush();
    }
}
