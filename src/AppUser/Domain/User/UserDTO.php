<?php

namespace App\AppUser\Domain\User;


use Symfony\Component\Uid\Uuid;

class UserDTO
{
    public static function fill(array $res): User
    {
        if (\count($res) === 0) {
            throw new UserNotFoundException();
        }

        foreach ($res as $row) {
            return User::create(
                (int)$row['id'],
                (string)$row['email'],
                (array)json_decode($row['roles'], true),
                (string)$row['password'],
                (string)$row['uuid'],
                (string)$row['lang']
            );
        }
    }

    public static function fillRow(array $row): User
    {
        if (\count($row) === 0) {
            throw new UserNotfoundException();
        }

        return User::create(
            (int)$row['id'],
            (string)$row['email'],
            (array)json_decode($row['roles'], true),
            (string)$row['password'],
            (string)$row['uuid'],
            (string)$row['lang']
        );
    }
} // UserDTO