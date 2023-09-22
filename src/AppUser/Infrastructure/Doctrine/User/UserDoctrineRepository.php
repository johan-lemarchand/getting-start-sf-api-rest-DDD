<?php

namespace App\AppUser\Infrastructure\Doctrine\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use App\AppUser\Domain\User\User;
use App\AppUser\Domain\User\UserDTO;
use App\AppUser\Domain\User\UserRepository;
use App\AppUser\Infrastructure\Doctrine\User\DAO\UserDAO;
use App\AppUser\Infrastructure\Doctrine\User\DAO\UserWriteDAO;


class UserDoctrineRepository extends ServiceEntityRepository implements UserRepository
{
    private UserDAO $_userDAO;

    private UserWriteDAO $_userWriteDAO;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $em = $this->getEntityManager();
        $this->_userDAO = new UserDAO($em->getConnection());
        $this->_userWriteDAO = new UserWriteDAO($em->getConnection());
    }

    public function findBy(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null
    ): array {
        return array();
    }

    /**
     * @throws Exception
     */
    public function findOneBy(array $criteria, array $orderBy = null): User
    {
        $res = $this->_userDAO->queryFindOneBy($criteria, $orderBy);
        return UserDTO::fillRow($res);
    }

    public function update(User $entity): void
    {

    }

    /**
     * @throws Exception
     */
    public function save(User $entity): void
    {
        $this->_userWriteDAO->querySave($entity);
    }

    /**
     * @throws Exception
     */
    public function remove(User $entity): void
    {
        $this->_userWriteDAO->queryRemove($entity);
    }
}
