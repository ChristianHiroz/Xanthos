<?php
namespace CoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ColorAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', 'text', array('label' => 'Nom'));
        $formMapper->add('price', 'number', array('label' => 'Prix'));
        $formMapper->add('promotion', 'sonata_type_model', array('label' => 'Promotion', 'by_reference' => false, 'required' => false));

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, array('label' => 'Nom'));
        $datagridMapper->add('price', null, array('label' => 'Prix'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', null, array('label' => 'Nom'));
        $listMapper->addIdentifier('price', null, array('label' => 'Prix'));
    }
}
