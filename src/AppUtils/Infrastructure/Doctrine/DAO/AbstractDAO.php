<?php

namespace App\AppUtils\Infrastructure\Doctrine\DAO;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Statement;

abstract class AbstractDAO
{
    public Connection $_connection;


    public function __construct(Connection $connection)
    {
        $this->_connection = $connection;
    }
    public function getConditions(array $criterias): string
    {
        $conditions = [];
        foreach ($criterias as $key => $value) {
            if (is_string($value)) {
                $conditions[] = $key .' like :'.$key;
            } else {
                $conditions[] = $key .' = :'.$key;
            }
        }
        return implode(' AND ', $conditions);
    }

    public function getOrder(?array $order): string
    {
        $orderStr = '';
        if (($order) && (is_iterable($order) > 0)) {
            $orders = [];
            foreach ($order as $key => $value) {
                $orders[] = $key. ' '.$value;
            }

            if (\count($orders) > 0) {
                $orderStr = ' ORDER BY '.implode(' , ', $orders);
            }
        }

        return $orderStr;
    }

    /**
     * @throws Exception
     */
    public function getStmtFindOneBy(Statement $stmt, array $criteria): Mixed
    {
        foreach ($criteria as $key => $value) {
            if (is_string($value)) {
                $stmt->bindValue(':'.$key, '%'.$value.'%');
            } else {
                $stmt->bindValue(':'.$key, $value);
            }
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
    public function getStmtFindBy(Statement $stmt, array $criteria): Mixed
    {
        foreach ($criteria as $key => $value) {
            if (is_string($value)) {
                $stmt->bindValue(':'.$key, '%'.$value.'%');
            } else {
                $stmt->bindValue(':'.$key, $value);
            }
        }

        $result = $stmt->executeQuery();

        $res = $result->fetchAllAssociative();

        if (!$res) {
            return array();
        }

        return $res;
    }
}