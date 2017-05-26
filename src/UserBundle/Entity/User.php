<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use ECommerceBundle\Entity\Cart;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var Cart
     *
     * @ORM\OneToOne(targetEntity="\ECommerceBundle\Entity\Cart", cascade={"persist"})
     */
    private $cart;


    /**
     * @var Cart
     *
     * @ORM\OneToMany(targetEntity="\ECommerceBundle\Entity\Order", cascade={"persist"}, mappedBy="user")
     */
    private $orders;


    public function __construct()
    {
        parent::__construct();
        $this->orders = new ArrayCollection();
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return Cart
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param Cart $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @param $order
     */
    public function addOrder($order){
        $this->orders[] = $order;
    }

    public function __toString()
    {
        return $this->getUsername();
    }
}

