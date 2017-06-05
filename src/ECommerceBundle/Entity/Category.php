<?php

namespace ECommerceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ECommerceBundle\ECommerceBundle;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var bool
     *
     * @ORM\Column(name="secondaryCategory", type="boolean")
     */
    private $secondaryCategory;

    /**
     * @var Category
     *
     * @ORM\OneToMany(targetEntity="\ECommerceBundle\Entity\Category", mappedBy="masterCategory")
     */
    private $subCategorys;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="\ECommerceBundle\Entity\Category", inversedBy="subCategorys", cascade={"persist"})
     */
    private $masterCategory;

    /**
     * @var Category
     *
     * @ORM\OneToMany(targetEntity="\ECommerceBundle\Entity\Product", mappedBy="category")
     */
    private $products;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $picture;

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
     * @return bool
     */
    public function isSecondaryCategory()
    {
        return $this->secondaryCategory;
    }

    /**
     * @param bool $secondaryCategory
     */
    public function setSecondaryCategory($secondaryCategory)
    {
        $this->secondaryCategory = $secondaryCategory;
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
     * @return Category
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Category $products
     */
    public function setProducts(Category $products)
    {
        $this->products = $products;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return Category
     */
    public function getMasterCategory()
    {
        return $this->masterCategory;
    }

    /**
     * @param Category $masterCategory
     */
    public function setMasterCategory($masterCategory)
    {
        $this->masterCategory = $masterCategory;
        $masterCategory->addCategory($this);
    }

    /**
     * @return string
     */
    public function __toString(){
        return $this->name;
    }
}

