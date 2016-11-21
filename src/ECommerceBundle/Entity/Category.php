<?php

namespace ECommerceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ECommerceBundle\ECommerceBundle;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="ECommerceBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="mainCategory", type="boolean")
     */
    private $mainCategory;

    /**
     * @var Category
     *
     * @ORM\OneToMany(targetEntity="\ECommerceBundle\Entity\Category", mappedBy="id")
     */
    private $subCategorys;

    /**
     * @var Category
     *
     * @ORM\OneToMany(targetEntity="\ECommerceBundle\Entity\Product", mappedBy="category")
     */
    private $products;

    public function __construct()
    {
        $this->subCategorys = new ArrayCollection();
        $this->products = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mainCategory
     *
     * @param boolean $mainCategory
     *
     * @return Category
     */
    public function setMainCategory($mainCategory)
    {
        $this->mainCategory = $mainCategory;

        return $this;
    }

    /**
     * Get mainCategory
     *
     * @return bool
     */
    public function isMainCategory()
    {
        return $this->mainCategory;
    }

    /**
     * Set subCategorys
     *
     * @param ArrayCollection $subCategorys
     *
     * @return $this
     *
     */
    public function setSubCategorys($subCategorys)
    {
        $this->subCategorys = $subCategorys;

        return $this;
    }

    /**
     * Get subCategorys
     *
     * @return ArrayCollection
     */
    public function getSubCategorys()
    {
        return $this->subCategorys;
    }


    /**
     * @param Category $category
     *
     * @return $this
     */
    public function addCategory(Category $category){
        $this->subCategorys[] = $category;

        return $this;
    }


    /**
     * @return string
     */
    public function __toString():string{
        return $this->name;
    }
}

