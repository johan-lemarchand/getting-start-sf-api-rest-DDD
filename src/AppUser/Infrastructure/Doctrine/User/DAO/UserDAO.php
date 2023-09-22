<?php

namespace App\AppUser\Infrastructure\Doctrine\User\DAO;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class UserDAO
{
    private Connection $_connection;

    public function __construct(Connection $connection)
    {
        $this->_connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function queryFind(int $id): array
    {
        $stmt = $this->_connection->prepare(
            "SELECT id, email, roles, password, uuid, lang
                FROM user
                WHERE id = :id"
        );

        $stmt->bindValue(':id', $id);
        $result = $stmt->executeQuery();

        $res = $result->fetchAssociative();

        if (!$res) {
            return array();
        }

        return $res;
    }

    /**
     * @throws Exception
     */
    public function queryFindAll(): array
    {
        $stmt = $this->_connection->prepare(
            "SELECT id, email, roles, password, uuid, lang
                FROM user"
        );

        $result = $stmt->executeQuery();

        $res = $result->fetchAllAssociative();

        if (!$res) {
            return array();
        }

        return $res;
    }

    /**
     * @throws Exception
     */
    public function queryFindOneBy(array $criteria, array $order = null): array
    {
        $conditions = [];
        foreach ($criteria as $key => $value) {
            $conditions[] = $key .' = :'.$key;
        }
        $contidionsStr = implode(' AND ', $conditions);

        $orderStr = '';
        if (($order) && (is_iterable($order) > 0)) {
            $orders = [];
            foreach ($order as $key => $value) {
                $orders[] = $key. ' '.$value;
            }

            if (\count($orders) > 0) {
                $orderStr = 'ORDER BY '.implode(' , ', $orders);
            }
        }

        $stmt = $this->_connection->prepare(
            'SELECT id, email, roles, password, uuid, lang
            FROM user 
            WHERE '.$contidionsStr.' 
            '.$orderStr.'
            '
        );

        foreach ($criteria as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }

        $result = $stmt->executeQuery();
        $res = $result->fetchAssociative();

        if (!$res) {
            return array();
        }

        return $res;
    }

    /**
     * @throws Exception
     */
    public function queryFindByUuid(string $uuid): array
    {
        $stmt = $this->_connection->prepare(
            "SELECT id, email, roles, password, uuid, lang
                FROM user
                WHERE uuid = :uuid"
        );

        $stmt->bindValue(':uuid', $uuid);
        $result = $stmt->executeQuery();

        $res = $result->fetchAssociative();

        if (!$res) {
            return array();
        }

        return $res;
    }
}