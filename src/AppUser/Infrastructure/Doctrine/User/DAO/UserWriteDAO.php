<?php

namespace App\AppUser\Infrastructure\Doctrine\User\DAO;

use Doctrine\DBAL\Connection;
use App\AppUser\Domain\User\User;
use Doctrine\DBAL\Exception;


final class UserWriteDAO
{
    private Connection $_connection;

    public function __construct(Connection $connection)
    {
        $this->_connection = $connection;
    }

    /**
     * @param User $user entity user
     *
     * @return void
     * @throws Exception
     */
    public function querySave(User $user): void
    {
        $stmt = $this->_connection->prepare(
            'INSERT INTO user 
                (email, roles, password, uuid, lang)
            VALUES 
                (:email, :roles, :password, :uuid, :lang)'
        );

        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':roles', json_encode($user->getRoles()));
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':uuid', $user->getUuid());
        $stmt->bindValue(':lang', $user->getLang());

        $stmt->executeQuery();
    }

    /**
     * @throws Exception
     */
    public function queryRemove(User $user): void
    {
        $stmt = $this->_connection->prepare(
            'DELETE FROM user WHERE id = :id'
        );

        $stmt->bindValue(':id', $user->getId());
        $stmt->executeQuery();
    }
}