<?php

namespace CoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('username', 'text', array('label' => 'Nom'));
        $formMapper->add('email', 'number', array('label' => 'Email'));
        $formMapper->add('lastLogin', 'datetime', array('label' => 'Dernière connexion'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('username', null, array('label' => 'Nom'));
        $datagridMapper->add('email', null, array('label' => 'Email'));
        $datagridMapper->add('lastLogin', null, array('label' => 'Dernière connexion'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('username', null, array('label' => 'Nom'));
        $listMapper->addIdentifier('email', null, array('label' => 'Email'));
        $listMapper->addIdentifier('lastLogin', null, array('label' => 'Dernière connexion'));
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        // OR remove all route except named ones
        $collection->clearExcept(array('list', 'show'));
    }
}
