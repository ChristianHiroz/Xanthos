<?php
namespace CoreBundle\Admin;

use ECommerceBundle\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var Product $subject */
        $subject = $this->getSubject();

        $formMapper->add('name', 'text', array('label' => 'Nom'));
        $formMapper->add('description', 'text', array('label' => 'Description'));
        $formMapper->add('externalCode', 'text', array('label' => 'Code fournisseur'));
        $formMapper->add('price', 'number', array('label' => 'Prix'));
        $formMapper->add('category', 'sonata_type_model', array('label' => 'Catégorie'));


        if (!$subject->getId()) {
            // The field will only be added when the edited item is created
            $formMapper->add('file', 'file', array('label' => 'Image', 'data_class' => NULL));
        }else {
            $subject->setFile($subject->getFile());
        }

        $formMapper->add('sizes', 'sonata_type_collection',
            array(
                'label' => 'Tailles',
                'by_reference' => false
            ),
            array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position')
        );

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, array('label' => 'Nom'));
        $datagridMapper->add('description', null, array('label' => 'Description'));
        $datagridMapper->add('category', null, array('label' => 'Catégorie'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', null, array('label' => 'Nom')); //TODO ajouter photo
        $listMapper->addIdentifier('description', null, array('label' => 'Description'));
        $listMapper->addIdentifier('category', null, array('label' => 'Catégorie'));
    }
}
