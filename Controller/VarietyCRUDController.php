<?php

namespace Librinfo\VarietiesBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Librinfo\CoreBundle\Controller\CRUDController;

class VarietyCRUDController extends CRUDController
{
    /**
     * Creates a strain from a variety and passes it to create action
     * 
     * @return Response
     */
    public function strainAction()
    {
        $id = $this->getRequest()->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);
        $strain = clone $this->admin->getObject($id);
        
        $strain->setIsStrain(true);
        $strain->setParent($object);
        
        $fieldSets = ['Professional', 'Amateur', 'Production', 'Commercial', 'Plant', 'Culture', 'Inner'];
        
        foreach($fieldSets as $label)
        {
            $getter = 'get' . $label . 'Descriptions';
            $adder = 'add' . $label . 'Description';
            $collection = $object->$getter();
            $collection->initialize();
            
            foreach($collection as $desc)
            {
                $new = clone $desc;
                $strain->$adder($new);
            }
        }
        
        foreach($object->getPlantCategories() as $cat)
            $strain->addPlantCategory($cat);
        
        return $this->createAction($strain);
    }
    
    /**
     * Get field widget for filter form
     *
     * @param String $fieldName the name of the field to get the form widget for
     * @return JsonResponse
     */
    public function getFilterWidgetAction(Request $request)
    {
        $translator = $this->get('translator');
        $fieldSet = $request->get('fieldset');
        $field = $request->get('field');

        $config = $this->admin->getConfigurationPool()->getContainer()->getParameter('librinfo_varieties');
        $fieldConfig = $config['variety_descriptions'][$fieldSet][$field];
        $choiceType = 'librinfo_customchoice';
        $options = $fieldConfig['options'];
        $type = $fieldConfig['type'] != 'textarea' ? $fieldConfig['type'] : 'text';

        if ( $type == 'librinfo_customcheckbox' )
        {
            $type = 'choice';
            $options = array_merge($options, array(
                'choices' => array('1' => $translator->trans('yes'), '0' => $translator->trans('no'))
            ));
        }

        if ( $type == $choiceType )
        {
            $options['is_filter'] = true;

            if ( isset($options['expanded']) )
                unset($options['expanded']);

            if ( isset($options['multiple']) )
                unset($options['multiple']);
        }

        if ( $type == 'librinfo_tinymce' )
            $type = 'text';

        if ( isset($options['choices']) && empty($options['choices']) )
            unset($options['choices']);

        if ( isset($options['choices_class']) && $type != $choiceType )
            unset($options['choices_class']);

        if ( isset($options['librinfo_choices']) && $type != $choiceType )
            unset($options['librinfo_choices']);

        if ( isset($options['help']) )
            unset($options['help']);

        $view = $this->createFormBuilder()
                ->add('value', $type, $options)
                ->getForm()
                ->createView()
        ;

        return $this->render('LibrinfoVarietiesBundle:Form:filter_widget.html.twig', array(
                    'form' => $view
                        ), null);
    }

}
