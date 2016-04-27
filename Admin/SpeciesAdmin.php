<?php

namespace Librinfo\VarietiesBundle\Admin;

use Librinfo\CoreBundle\Admin\CoreAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SpeciesAdmin extends CoreAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('latin_name')
            ->add('alias')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('name')
            ->add('id')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('latin_name')
            ->add('alias')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('name')
            ->add('id')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('latin_name')
            ->add('alias')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('name')
            ->add('id')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('latin_name')
            ->add('alias')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('name')
            ->add('id')
        ;
    }
}