<?php

namespace ForumBundle\Repository;

use ForumBundle\Entity\reponse;

/**
 * reponseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class reponseRepository extends \Doctrine\ORM\EntityRepository
{
    public function findbyidq()
    {
        $qb=$this->createQueryBuilder(reponse::class)->select($this->findbyid_q());
    }
}
