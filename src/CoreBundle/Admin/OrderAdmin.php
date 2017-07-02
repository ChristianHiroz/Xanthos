<?php
namespace CoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OrderAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('price', 'number', array('label' => 'Prix total'));
        $formMapper->add('status', 'choice' , array('label' => 'Status', 'choices' => array('Traitée' => 1, 'En cours' => 0)));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('price', null, array('label' => 'Prix total'));
        $datagridMapper->add('user', null, array('label' => 'Client'));
        $datagridMapper->add('status', null, array('label' => 'Traiter', 'choices' => array('Traitée' => 1, 'En cours' => 0)));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('price', null, array('label' => 'Prix total'));
        $listMapper->addIdentifier('user', null, array('label' => 'Client'));
        $listMapper->addIdentifier('status', null, array('label' => 'Traiter', 'choices' => array('Traitée' => 1, 'En cours' => 0)));
    }
}
