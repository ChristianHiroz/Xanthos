<?php

namespace CoreBundle\Controller;

use ECommerceBundle\Entity\Category;
use ECommerceBundle\Entity\Product;
use ECommerceBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        /** @var ProductRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->getLastProducts();

        /** @var User $user */
        $user = $this->getUser();
        if($user){
            $amount = 0;
            $productCount = 0;

            if($user->getCart()){
                $cart = $user->getCart();
                foreach ($cart->getProducts() as $product){
                    $amount += $product->getPrice();
                    $productCount++;
                }
            }
        }else {
            return array('products' => $products, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)));

        }
        return array('amount' => $amount, 'productCount' => $productCount, 'products' => $products, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)));
    }
}
