<?php 

namespace App\form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType {

      /**
     * Permet d'avoir la ocnfiguration de base d'un champ 
     *
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */


    protected function getConfiguration($label,$placeholder,$options=[]){
        return array_merge( [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]

            ] , $options);
    }
    
}