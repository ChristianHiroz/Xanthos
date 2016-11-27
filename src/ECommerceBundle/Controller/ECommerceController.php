<?php

namespace ECommerceBundle\Controller;

use ECommerceBundle\Entity\Category;
use ECommerceBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ECommerceController extends Controller
{
    /**
     * @Route("/category/{id}", name="show_category")
     * @Template()
     */
    public function showCategoryAction($id)
    {
        $category = $this->getDoctrine()->getManager()->getRepository(Category::class)->find($id);
        return array('category' => $category, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)));
    }

    /**
     * @Route("/product/{id}", name="show_product")
     * @Template()
     */
    public function showProductAction($id)
    {
        $product = $this->getDoctrine()->getManager()->getRepository(Product::class)->find($id);
        return array('product' => $product, 'categorys' => $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy(array('mainCategory' => true)));
    }
}
