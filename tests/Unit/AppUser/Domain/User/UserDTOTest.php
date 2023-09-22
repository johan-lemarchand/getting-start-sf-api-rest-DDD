<?php

namespace App\Tests\Unit\AppUser\Domain\User;


use App\AppUser\Domain\User\UserDTO;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;


class UserDTOTest extends TestCase
{
    public function testFill()
    {
        $faker = Factory::create('fr_FR');
        $user = UserDTO::fill(
            array(
                array(
                    'id' => $id = 0,
                    'email' => $email = $faker->email,
                    'roles' => $roles =  json_encode(array('ROLE_USER')),
                    'password' => $password = $faker->password,
                    'uuid' => $uuid = Uuid::v4()->toRfc4122(),
                    'lang' => $lang = 'fr'
                )
            )
        );

        $this->assertSame($id, $user->getId());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($roles, json_encode($user->getRoles()));
        $this->assertSame($password, $user->getPassword());
        $this->assertSame($uuid, $user->getUuid());
        $this->assertSame($lang, $user->getLang());
    }
    /*public function testWrong()
    {
        $this->expectException(UserNotFoundException::class);
        $user = UserDTO::fill(array());
    }*/
}