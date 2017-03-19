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

}
