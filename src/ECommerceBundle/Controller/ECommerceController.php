<?php

namespace ECommerceBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use ECommerceBundle\Entity\Cart;
use ECommerceBundle\Entity\Category;
use ECommerceBundle\Entity\Color;
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
                $amount = $cart->getPrice();
                $productCount = $cart->getProducts()->count();
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
                $amount = $cart->getPrice();
                $productCount = $cart->getProducts()->count();
            }
        }
        return array('product' => $product, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)), 'amount' => $amount, 'productCount' => $productCount);
    }

    /**
     * @Route("/addToCart/{productId}", name="add_to_cart")
     */
    public function addToCartAction($productId, Request $request){
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
        /** @var Color $color */
        $color = $this->getDoctrine()->getRepository(Color::class)->findOneBy(array('id' => $request->query->get('picker')));
        $price = $product->getPrice() + $color->getPrice() + $color->getSize()->getPrice();

        $cart->addProduct($product);
        $cart->addColor($color);
        $cart->setPrice($cart->getPrice() + $price);

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
        $id = $cart->getProducts()->indexOf($product);
        $color = $cart->getColors()->get($id);
        $price = $product->getPrice() + $color->getPrice() + $color->getSize()->getPrice();

        $cart->removeProduct($product);
        $cart->getColors()->removeElement($color);
        $cart->setPrice($cart->getPrice() - $price);
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

        /** @var Product $product */
        $amount = $cart->getPrice();
        $productCount = $cart->getProducts()->count();
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
            $amount = $cart->getPrice();
            $productCount = $cart->getProducts()->count();
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
            $amount = $cart->getPrice();
            $productCount = $cart->getProducts()->count();

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
            if(!$user->getRelayId()) {
                return $this->redirect($this->generateUrl('choose_relay'));
            }
            $amount = 0;
            $productCount = 0;

            if($user->getCart()){
                $cart = $user->getCart();
                $amount = $cart->getPrice();
                $productCount = $cart->getProducts()->count();
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
    public function paymentAction($id, Request $request)
    {
        /** @var Order $order */
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        $date = new \DateTime();

        $msg ="VERSION=00104".
            "&TYPE=00003".
            "&SITE=".$this->getParameter('site').
            "&RANG=".$this->getParameter('rank').
            "&NUMQUESTION=".$order->getId().
            "&MONTANT=".$order->getPrice().
            "&DEVISE=978".
            "&REFERENCE=XANTHOS".$order->getId().
            "&PORTEUR=".$request->get('card_number').
            "&HASH=SHA512".
            "&DATEVAL=1017".
            "&CVV=".$request->get('card_cvv').
            "&ACTIVITE=024".
            "&DATEQ="."01092017";
//
//        $myvars =
//            'PBX_SITE=' . $this->getParameter('site') .
//            '&PBX_RANG=' . $this->getParameter('rank') .
//            '&PBX_IDENTIFIANT' . $this->getParameter('login') .
//            'PBX_TOTAL' . $order->getPrice() .
//            'PBX_DEVISE' . '978' .
//            'PBX_CMD' . $order->getId() .
//            'PBX_PORTEUR' . $user->getEmail() .
//            'PBX_RETOUR' . 'Mt:M;Ref:R;Auto:A;Erreur:E' .
//            'PBX_HASH' . 'SHA512' .
//            'PBX_TIME' . $date->format('c');

        $binKey = pack("H*", $this->getParameter('key'));
        $hmac = strtoupper(hash_hmac('sha512', $msg, $binKey));

        /** @var User $user */
        $user = $this->getUser();
        if($user->getCart()) {
            $cart = $user->getCart();
            $amount = $cart->getPrice();
            $productCount = $cart->getProducts()->count();
        }

        return $this->render(
            'ECommerceBundle:ECommerce:validate.html.twig',
            array(
                'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)),
                'numquestion' => $order->getId(),
                'amount' => $amount,
                'order_amount' => $order->getPrice(),
                'reference' => "XANTHOS".$order->getId(),
                'card_number' => $request->get('card_number'),
                'card_cvv' => $request->get('card_cvv'),
                'date' => "01092017",
                'site'  => $this->getParameter('site'),
                'rang'  => $this->getParameter('rank'),
                'hmac' => $hmac,
                'url' => $this->getParameter('url'),
                'productCount' => $productCount
            )
        );
    }

    /**
     * @Route("/paymentReturn/{status}", name="payment_return")
     * @Template()
     * @param $status
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paymentReturnAction($status)
    {
        var_dump($status);exit;
    }



    /**
     * @Route("/validateCart", name="validate_cart")
     */
    public function validateCartAction(){
        /** @var User $user */
        $user = $this->getUser();
        if($user->getCart()){
            $cart = $user->getCart();
        }else{
            return $this->redirect($this->generateUrl('index'));
        }


        if($cart->getPrice() == 0){
            return $this->redirect($this->generateUrl('index'));
        }

        $order = new Order();
        $order->setProducts($cart->getProducts());
        $order->setPrice($cart->getPrice());
        $order->setUser($user);
        $user->addOrder($order);

        $cart->setProducts(new ArrayCollection());
        $cart->setColors(new ArrayCollection());
        $cart->setPrice(0);
        $cart->setWeight(0);

        $this->getDoctrine()->getManager()->persist($order);
        $this->getDoctrine()->getManager()->persist($cart);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();


        return $this->redirect($this->generateUrl('show_orders'));
    }

    /**
     * @Route("/chooseRelay", name="choose_relay")
     * @Template()
     */
    public function chooseRelayAction()
    {
        /** @var User $user */
        $user = $this->getUser();
        $amount = 0;
        $productCount = 0;

        if($user->getCart()){
            $cart = $user->getCart();
            $amount = $cart->getPrice();
            $productCount = $cart->getProducts()->count();
        }

        return array('user' => $user, 'amount' => $amount, 'productCount' => $productCount, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)));
    }

    /**
     * @Route("/validateRelay", name="validate_relay")
     * @Template()
     */
    public function validateRelayAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        if($request->get('relayId')){
            $user->setRelayId($request->get('relayId'));
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush($user);
        }else {
            return $this->redirect($this->generateUrl('choose_relay'));
        }

        return $this->redirect($this->generateUrl('show_orders'));
    }
}
