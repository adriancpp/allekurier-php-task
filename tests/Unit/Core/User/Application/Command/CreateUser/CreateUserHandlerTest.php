<?php

namespace App\Tests\Unit\Core\User\Application\Command\CreateUser;

use App\Core\User\Application\Command\CreateUser\CreateUserCommand;
use App\Core\User\Application\Command\CreateUser\CreateUserHandler;
use App\Core\User\Domain\User;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Common\Mailer\MailerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateUserHandlerTest extends TestCase
{
    private UserRepositoryInterface|MockObject $userRepository;
    private MailerInterface|MockObject $mailer;
    private CreateUserHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateUserHandler(
            $this->userRepository = $this->createMock(
                UserRepositoryInterface::class
            ),
            $this->mailer = $this->createMock(
                MailerInterface::class
            )
        );
    }

    public function test_handle_creates_user_and_sends_mail(): void
    {
        $email = 'test@example.com';

        $this->userRepository->expects(self::once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->userRepository->expects(self::once())
            ->method('flush');

        $this->mailer->expects(self::once())
            ->method('send')
            ->with(
                $email,
                'Rejestracja konta w systemie',
                'Zarejestrowano konto w systemie. Aktywacja konta trwa do 24h'
            );

        $this->handler->__invoke(new CreateUserCommand($email));
    }
}
