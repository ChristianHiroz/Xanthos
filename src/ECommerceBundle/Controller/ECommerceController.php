<?php

namespace ECommerceBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use ECommerceBundle\Entity\Cart;
use ECommerceBundle\Entity\Category;
use ECommerceBundle\Entity\Order;
use ECommerceBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use UserBundle\Entity\User;

class ECommerceController extends Controller
{
    /**
     * @Route("/category/{id}", name="show_category")
     * @Template()
     */
    public function showCategoryAction($id)
    {
        /** @var User $user */
        $user = $this->getUser();
        $category = $this->getDoctrine()->getManager()->getRepository(Category::class)->find($id);
        $amount = 0;
        $productCount = 0;

        if($user){
            if($user->getCart()){
                $cart = $user->getCart();
                foreach ($cart->getProducts() as $product){
                    $amount += $product->getPrice();
                    $productCount++;
                }
            }
        }

        return array('category' => $category, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)), 'amount' => $amount, 'productCount' => $productCount);
    }

    /**
     * @Route("/product/{id}", name="show_product")
     * @Template()
     */
    public function showProductAction($id)
    {
        /** @var User $user */
        $user = $this->getUser();
        $product = $this->getDoctrine()->getManager()->getRepository(Product::class)->find($id);

        $amount = 0;
        $productCount = 0;

        if($user){
            if($user->getCart()){
                $cart = $user->getCart();
                foreach ($cart->getProducts() as $product){
                    $amount += $product->getPrice();
                    $productCount++;
                }
            }
        }
        return array('product' => $product, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)), 'amount' => $amount, 'productCount' => $productCount);
    }

    /**
     * @Route("/addToCart/{productId}", name="add_to_cart")
     */
    public function addToCartAction($productId){
        /** @var User $user */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if(!$user->getCart()){
            $cart = new Cart();
            $user->setCart($cart);
            $em->persist($cart);
            $em->persist($user);
            $em->flush();
        }else{
            $cart = $user->getCart();
        }

        /** @var Product $product */
        $product = $this->getDoctrine()->getRepository(Product::class)->findOneBy(array('id' => $productId));

        $cart->addProduct($product);
        $em->persist($cart);
        $em->flush();

        return $this->redirect($this->generateUrl('show_cart'));

    }

    /**
     * @Route("/removeFromCart/{productId}", name="remove_from_cart")
     */
    public function removeFromCartAction($productId){
        /** @var User $user */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if(!$user->getCart()){
            $cart = new Cart();
            $user->setCart($cart);
            $em->persist($cart);
            $em->persist($user);
            $em->flush();
        }else{
            $cart = $user->getCart();
        }

        /** @var Product $product */
        $product = $this->getDoctrine()->getRepository(Product::class)->findOneBy(array('id' => $productId));

        $cart->removeProduct($product);
        $em->persist($cart);
        $em->flush();

        return $this->redirect($this->generateUrl('show_cart'));

    }

    /**
     * @Route("/cart", name="show_cart")
     * @Template()
     */
    public function showCartAction(){
        /** @var User $user */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if(!$user->getCart()){
            $cart = new Cart();
            $user->setCart($cart);
            $em->persist($cart);
            $em->persist($user);
        }else{
            $cart = $user->getCart();
        }

        $amount = 0;
        $productCount = 0;
        /** @var Product $product */
        foreach ($cart->getProducts() as $product){
            $amount += $product->getPrice();
            $productCount++;
        }

        return array('user' => $user, 'cart' => $cart, 'amount' => $amount, 'productCount' => $productCount, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)));

    }

    /**
     * @Route("/orders", name="show_orders")
     * @Template()
     */
    public function showOrdersAction(){
        /** @var User $user */
        $user = $this->getUser();
        $amount = 0;
        $productCount = 0;

        if($user->getCart()){
            $cart = $user->getCart();
            foreach ($cart->getProducts() as $product){
                $amount += $product->getPrice();
                $productCount++;
            }
        }

        $orders = $user->getOrders();

        return array('orders' => $orders, 'user' => $user, 'amount' => $amount, 'productCount' => $productCount, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)));
    }


    /**
     * @Route("/orders/{id}", name="show_order")
     * @Template()
     */
    public function showOrderAction($id){
        /** @var User $user */
        $user = $this->getUser();
        $amount = 0;
        $productCount = 0;

        if($user->getCart()){
            $cart = $user->getCart();
            foreach ($cart->getProducts() as $product){
                $amount += $product->getPrice();
                $productCount++;
            }
        }

        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        return array('order' => $order, 'user' => $user, 'amount' => $amount, 'productCount' => $productCount, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)));
    }


    /**
     * @Route("/payOrder/{id}", name="pay_order")
     * @Template()
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function payOrderAction($id)
    {
        /** @var Order $order */
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);

        if(!$order || $order->isStatus()){
            return $this->redirect($this->generateUrl('index'));
        }else {
            /** @var User $user */
            $user = $this->getUser();
            $amount = 0;
            $productCount = 0;

            if($user->getCart()){
                $cart = $user->getCart();
                foreach ($cart->getProducts() as $product){
                    $amount += $product->getPrice();
                    $productCount++;
                }
            }

            return array('order' => $order, 'user' => $user, 'amount' => $amount, 'productCount' => $productCount, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)));
        }


    }

    /**
     * @Route("/payment/{id}", name="payment")
     * @Template()
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paymentAction($id,Request $request)
    {
        /** @var Order $order */
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);

        $paybox = $this->get('lexik_paybox.request_handler');
        $paybox->setParameters(array(
            'PBX_CMD'          => 'CMD'.time(),
            'PBX_DEVISE'       => '978',
            'PBX_PORTEUR'      => $request->get('card_number'),
            'PBX_RETOUR'       => 'Mt:M;Ref:R;Auto:A;Erreur:E',
            'PBX_TOTAL'        => $order->getPrice(),
            'PBX_TYPEPAIEMENT' => 'CARTE',
            'PBX_TYPECARTE'    => $request->get('card_type'),
//            'PBX_EFFECTUE'     => $this->generateUrl('lexik_paybox_sample_return', array('status' => 'success'), true),
//            'PBX_REFUSE'       => $this->generateUrl('lexik_paybox_sample_return', array('status' => 'denied'), true),
//            'PBX_ANNULE'       => $this->generateUrl('lexik_paybox_sample_return', array('status' => 'canceled'), true),
            'PBX_RUF1'         => 'POST',
            'PBX_REPONDRE_A'   => $this->generateUrl('lexik_paybox_ipn', array('time' => time()), UrlGeneratorInterface::ABSOLUTE_URL),
        ));
        return $this->render(
            'LexikPayboxBundle:Sample:index.html.twig',
            array(
                'url'  => $paybox->getUrl(),
                'form' => $paybox->getForm()->createView(),
            )
        );
    }

//
//    /**
//     * Exemple d'action de la page de confirmation vers laquelle
//     * est redirigé l'utilisateur après un paiement.
//     * Cette action ne doit contenir que de la logique de présentation.
//     */
//    public function returnAction($status)
//    {
//        return $this->render(
//            'LexikPayboxBundle:Sample:return.html.twig',
//            array(
//                'status' => $status,
//                'parameters' => $this->getRequest()->query,
//            )
//        );
//    }



        /**
     * @Route("/validateCart}", name="validate_cart")
     */
    public function validateCartAction(){
        /** @var User $user */
        $user = $this->getUser();
        if($user->getCart()){
            $cart = $user->getCart();
        }else{
            return $this->redirect($this->generateUrl('index'));
        }

        $amount = 0;
        foreach ($cart->getProducts() as $product){
            $amount += $product->getPrice();
        }

        if($amount == 0){
            return $this->redirect($this->generateUrl('index'));
        }

        $order = new Order();
        $order->setProducts($cart->getProducts());
        $order->setPrice($amount);
        $order->setUser($user);
        $user->addOrder($order);

        $cart->setProducts(new ArrayCollection());

        $this->getDoctrine()->getManager()->persist($order);
        $this->getDoctrine()->getManager()->persist($cart);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();


        return $this->redirect($this->generateUrl('show_orders'));
    }
}
