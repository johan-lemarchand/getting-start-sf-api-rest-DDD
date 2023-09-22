<?php

namespace App\AppUser\Application\Command\UserCreate;


use App\AppUser\Domain\User\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Uid\Uuid;

class UserCreateCommandHandler
{
    /**
     * @var UserRepository 
     */
    private UserRepository $_userRepository;

    /**
     * @var UserPasswordHasher 
     */
    private UserPasswordHasher $_passwordHasher;

    /**
     * @var string 
     */
    private string $_uuid;
    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasher $passwordHasher
    ) {
        $this->_userRepository = $userRepository;
        $this->_passwordHasher = $passwordHasher;
    }
    public function dispatch(UserCreateCommand $userCreateCommand): bool
    {
        $user = User::create(
            0,
            $userCreateCommand->getEmail(),
            array('ROLE_USER'),
            $userCreateCommand->getPassword(),
            Uuid::v4(),
            $userCreateCommand->getLang()
        );

        $hashedPassword = $this->_passwordHasher->hashPassword(
            $user,
            $userCreateCommand->getPassword()
        );
        $user->setPassword($hashedPassword);

        $this->_userRepository->save($user);
        $this->_uuid = $user->getUuid();
        return true;
    }

    public function getUuid(): string
    {
        return $this->_uuid;
    }

}