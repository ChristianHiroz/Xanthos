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

        $formMapper->add('masterCategory', 'sonata_type_model', array('label' => 'Catégorie parent', 'required' => false));

        $formMapper->add('secondaryCategory', 'choice', array('label' => 'Catégorie secondaire', 'choices' => array('Oui' => 1, 'Non' => 0)));


        $formMapper->add('picture', 'file', array('label' => 'Image', 'data_class' => NULL));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, array('label' => 'Nom'));
        $datagridMapper->add('mainCategory', null, array('label' => 'Catégorie principale', 'choices' => array(1 => 'Oui', 0 => 'Non')));
        $datagridMapper->add('secondaryCategory', null, array('label' => 'Catégorie secondaire', 'choices' => array(1 => 'Oui', 0 => 'Non')));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', null, array('label' => 'Nom'));
        $listMapper->add('mainCategory', null, array('label' => 'Catégorie principale', 'choices' => array(1 => 'Oui', 0 => 'Non')));
        $listMapper->add('secondaryCategory', null, array('label' => 'Catégorie secondaire', 'choices' => array(1 => 'Oui', 0 => 'Non')));
    }
}
