<?php

namespace ECommerceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="ECommerceBundle\Repository\CartRepository")
 */
class Cart
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
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="deliveryFee", type="float")
     */
    private $deliveryFee;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float")
     */
    private $weight;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="\ECommerceBundle\Entity\Product")
     */
    private $products;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="\ECommerceBundle\Entity\Color")
     */
    private $colors;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->colors = new ArrayCollection();
        $this->weight = 0;
        $this->price = 0;
        $this->deliveryFee = 0;
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
     * Set products
     *
     * @param ArrayCollection $products
     *
     * @return Cart
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product){
        $this->products[] = $product;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product){
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return ArrayCollection
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * @param ArrayCollection $colors
     */
    public function setColors($colors)
    {
        $this->colors = $colors;
    }

    /**
     * @param Color $color
     * @return $this
     */
    public function addColor(Color $color)
    {
        $this->colors[] = $color;

        return $this;
    }

    /**
     * @param Color $color
     * @return $this
     */
    public function removeColor(Color $color)
    {
        $this->colors->removeElement($color);

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

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getDeliveryFee()
    {
        return $this->deliveryFee;
    }

    /**
     * @param float $deliveryFee
     * @return Cart
     */
    public function setDeliveryFee($deliveryFee)
    {
        $this->deliveryFee = $deliveryFee;

        return $this;
    }
}

