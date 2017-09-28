<?php

namespace ECommerceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="ECommerceBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="externalCode", type="string", length=50)
     */
    private $externalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float")
     */
    private $weight;


    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="\ECommerceBundle\Entity\Category", inversedBy="products")
     */
    private $category;


    /**
     * @var Size
     *
     * @ORM\OneToMany(targetEntity="\ECommerceBundle\Entity\Size", mappedBy="product", cascade={"persist", "remove"},orphanRemoval=true)
     */
    private $sizes;

    /**
     * @ORM\Column(type="string", name="media")
     */
    private $file;

    public function __construct()
    {
        $this->sizes = new ArrayCollection();
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
     * @return Product
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
     * @return string
     */
    public function getExternalCode()
    {
        return $this->externalCode;
    }

    /**
     * @param string $externalCode
     * @return Product
     */
    public function setExternalCode($externalCode)
    {
        $this->externalCode = $externalCode;
        return $this;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Product
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function __toString(){
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * @param mixed $sizes
     * @return Product
     */
    public function setSizes($sizes)
    {
        $this->sizes = $sizes;

        /** @var Size $size */
        foreach ($sizes as $size) {
            $size->setProduct($this);
        }

        return $this;
    }

    /**
     * @param $size
     * @return $this
     */
    public function addSize(Size $size)
    {
        $this->sizes[] = $size;
        $size->setProduct($this);

        return $this;
    }

    /**
     * @param $size
     * @return $this
     */
    public function removeSize($size)
    {
        $this->sizes->removeElement($size);

        return $this;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }
}

