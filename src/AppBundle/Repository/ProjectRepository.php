<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 10:31 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Article;
use AppBundle\Entity\Project;

class ProjectRepository extends EntityRepository
{

    public function findActive()
    {
        return $this->createQueryBuilder('project')
            ->andWhere('project.active = 1')
            ->getQuery()->execute();
    }

    public function findActiveQuery()
    {
        return $this->createQueryBuilder('project')
            ->andWhere('project.active = 1');
    }

    public function getBatch($offset, $size)
    {
        return $this->createQueryBuilder('project')
            ->setFirstResult($offset)
            ->setMaxResults($size)
            ->getQuery()->execute();
    }

    public function getPage($num, $size)
    {
        return $this->getBatch(($num-1) * $size, $size);
    }

    public function getBatchId($offset, $size)
    {
        return $this->createQueryBuilder('project')
            ->select('project.id, project.name, project.nameEn')
            ->setFirstResult($offset)
            ->setMaxResults($size)
            ->getQuery()->execute();
    }

    public function getPageId($num, $size)
    {
        return $this->getBatchId(($num-1) * $size, $size);
    }

}
