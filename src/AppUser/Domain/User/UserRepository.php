<?php

namespace App\AppUser\Domain\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;


interface UserRepository
{
    public function findOneBy(array $criteria, array $orderBy = null) :User;
    public function findBy(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null
    ) :array;
    public function save(User $entity) :void;
    public function update(User $entity) :void;
    public function remove(User $entity) :void;
}