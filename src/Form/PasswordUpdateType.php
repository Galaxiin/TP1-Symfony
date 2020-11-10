<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('OldPass', PasswordType::class, $this->getConfig("Votre ancien mot de passe :","old password"))
            ->add('NewPass', PasswordType::class, $this->getConfig("Votre nouveau mot de passe :","new password"))
            ->add('ConfirmPass', PasswordType::class, $this->getConfig("Confirmation","new password"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
