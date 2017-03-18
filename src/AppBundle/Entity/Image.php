<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="img")
 */
class Image
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $name;

    public $picture;



    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

}
