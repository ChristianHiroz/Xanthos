<?php
namespace CoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', 'text', array('label' => 'Nom'));
        $formMapper->add('description', 'text', array('label' => 'Description'));
        $formMapper->add('price', 'integer', array('label' => 'Prix'));
        $formMapper->add('category', 'sonata_type_model', array('label' => 'Catégorie'));
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
