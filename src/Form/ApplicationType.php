<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType{
    /**
     * Configuration d'un champ
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    protected function getConfig($label, $placeholder){
        return[
            'label' => $label,
        'attr' => ['placeholder' => $placeholder, 'class' => 'form-control']
        ];
    }
}