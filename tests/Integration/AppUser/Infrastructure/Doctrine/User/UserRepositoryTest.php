<?php

namespace App\Tests\Integration\AppUser\Infrastructure\Doctrine\User;

use App\AppUser\Domain\User\User;
use App\AppUser\Infrastructure\Doctrine\User\UserDoctrineRepository;
use App\Tests\Factory\User\UserFactory;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;


class UserRepositoryTest extends KernelTestCase
{
    private UserDoctrineRepository  $_repository;
    private UserPasswordHasher $_userPasswordHasher;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $kernel = self::bootKernel();
        $connection = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();
        $this->_repository = $connection->getRepository(User::class);
        $this->_userPasswordHasher = $kernel->getContainer()->get(UserPasswordHasher::class);
    }

    /**
     * @throws Exception
     */
    public function testSave()
    {
        $dataObjectUser = UserFactory::getFake($this->_userPasswordHasher);
        $user = $dataObjectUser->user;

        $this->_repository->save($user);

        $user = $this->_repository->findOneBy(array('uuid' =>$dataObjectUser->uuid));
        $this->assertSame($user->getEmail(), $dataObjectUser->email);
        $this->_repository->findOneBy(array('uuid' => $dataObjectUser->uuid));
        $user = $this->_repository->findOneBy(array('uuid' => $dataObjectUser->uuid), array('email' => "DESC"));
        $this->assertSame($user->getEmail(), $dataObjectUser->email);
        $this->_repository->remove($user);
    }
}