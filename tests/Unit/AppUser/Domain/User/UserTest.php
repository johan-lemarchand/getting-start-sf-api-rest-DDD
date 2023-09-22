<?php

namespace App\Tests\Unit\AppUser\Domain\User;

use App\Tests\Factory\User\UserFactory;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreateUser()
    {
        $dataObjectUser = UserFactory::getFake();

        $this->assertSame($dataObjectUser->id, $dataObjectUser->user->getId());
        $this->assertSame($dataObjectUser->email, $dataObjectUser->user->getEmail());
        $this->assertSame($dataObjectUser->roles, $dataObjectUser->user->getRoles());
        $this->assertSame($dataObjectUser->password, $dataObjectUser->user->getPassword());
        $this->assertSame($dataObjectUser->uuid, $dataObjectUser->user->getUuid());
        $this->assertSame($dataObjectUser->lang, $dataObjectUser->user->getLang());
    }
}