<?php

namespace ECommerceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Size
 *
 * @ORM\Table(name="size")
 * @ORM\Entity(repositoryClass="ECommerceBundle\Repository\SizeRepository")
 */
class Size
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="\ECommerceBundle\Entity\Product", inversedBy="sizes")
     */
    private $product;

    /**
     * @var Color
     *
     * @ORM\OneToMany(targetEntity="\ECommerceBundle\Entity\Color", mappedBy="size", cascade={"persist", "remove"},orphanRemoval=true)
     */
    private $colors;

    public function __construct()
    {
        $this->colors = new ArrayCollection();
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
     * @return Size
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
     * Set price
     *
     * @param float $price
     *
     * @return Size
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
     * Set product
     *
     * @param Product $product
     *
     * @return Size
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set colors
     *
     * @param $colors
     *
     * @return Size
     */
    public function setColors($colors)
    {
        $this->colors = $colors;

        /** @var Color $color */
        foreach ($colors as $color) {
            $color->setSize($this);
        }

        return $this;
    }

    /**
     * Get colors
     *
     * @return Color[]|ArrayCollection
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * @param $color
     * @return $this
     */
    public function addColor(Color $color)
    {
        $this->colors[] = $color;

        $color->setSize($this);

        return $this;
    }

    /**
     * @param $color
     * @return $this
     */
    public function removeColor($color)
    {
        $this->colors->removeElement($color);

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}

