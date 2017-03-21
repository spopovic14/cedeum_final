<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 * @ORM\Table(name="project")
 */
class Project
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $longDescription;

    /**
     * @ORM\Column(type="string")
     */
    private $nameEn;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionEn;

    /**
     * @ORM\Column(type="text")
     */
    private $longDescriptionEn;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;



    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getNameEn()
    {
        return $this->nameEn;
    }

    public function setNameEn($name)
    {
        $this->nameEn = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($name)
    {
        $this->description = $name;
    }

    public function getLongDescription()
    {
        return $this->longDescription;
    }

    public function setLongDescription($name)
    {
        $this->longDescription = $name;
    }

    public function getDescriptionEn()
    {
        return $this->descriptionEn;
    }

    public function setDescriptionEn($name)
    {
        $this->descriptionEn = $name;
    }

    public function getLongDescriptionEn()
    {
        return $this->longDescriptionEn;
    }

    public function setLongDescriptionEn($name)
    {
        $this->longDescriptionEn = $name;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function __toString()
    {
        return $this->name;
    }

}
