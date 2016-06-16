<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Task;

/**
 * TaskRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskRepository extends \Doctrine\ORM\EntityRepository
{
    function save(Task $entity)
    {
        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush();
    }
}
