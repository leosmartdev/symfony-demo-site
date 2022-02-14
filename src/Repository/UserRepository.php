<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * This custom Doctrine repository is empty because so far we don't need any custom
 * method to query for application user information. But it's always a good practice
 * to define a custom repository that will be used when the application grows.
 *
 * See https://symfony.com/doc/current/doctrine.html#querying-for-objects-the-repository
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getAllUsers($filter = array()) {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->select('u.id, u.nombre_usu, u.apellidos_usu, u.tipo_usu, u.email_usu, u.activo_usu, u.fechaC_usu, u.usuC_usu, u.fechaM_usu, u.usuM_usu, u.borrado_usu, u.fechaUltAcceso_usu, u.roles, u.pais_usu');
        $queryBuilder->addSelect('uc.nombre_usu AS c_nombre_usu');
        $queryBuilder->addSelect('um.nombre_usu AS m_nombre_usu');
        if (array_key_exists("country", $filter)) {
            $queryBuilder->andWhere('u.pais_usu = :val')->setParameter('val', $filter['country']);
        }
        $queryBuilder->leftJoin(User::class, 'uc', 'with', "u.usuC_usu = uc.id");
        $queryBuilder->leftJoin(User::class, 'um', 'with', "u.usuM_usu = um.id");
        return $queryBuilder->getQuery()->getResult();
    }
}
