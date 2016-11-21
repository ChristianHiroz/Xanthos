<?php
namespace CoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', 'text', array('label' => 'Nom'));
        $formMapper->add('mainCategory', 'choice', array('label' => 'Catégorie principale', 'choices' => array('Oui' => 1, 'Non' => 0)));
        $formMapper->add('subCategorys', 'sonata_type_model', array('label' => 'Sous catégories', 'multiple' => true, 'by_reference' => false, 'required' => false));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, array('label' => 'Nom'));
        $datagridMapper->add('mainCategory', null, array('label' => 'Catégorie principale', 'choices' => array(1 => 'Oui', 0 => 'Non')));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', null, array('label' => 'Nom'));
        $listMapper->add('mainCategory', null, array('label' => 'Catégorie principale', 'choices' => array(1 => 'Oui', 0 => 'Non')));
    }
}
