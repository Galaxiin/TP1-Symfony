<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, $this->getConfig("Prenom","Ton prénom"))
            ->add('nom', TextType::class, $this->getConfig("Nom","Ton nom"))
            ->add('avatar', UrlType::class, $this->getConfig("Image d'avatar","Affiche toi belle gosse"))
            ->add('hash', PasswordType::class, $this->getConfig("Mot de passe","Choisis le bien !"))
            ->add('passwordConfirm', PasswordType::class, $this->getConfig("Confirmation de mot de passe","Confirmez votre mot de passe"))
            ->add('introduction', TextType::class, $this->getConfig("Introduction","Partage un peu ta vie"))
            ->add('adresseMail', EmailType::class, $this->getConfig("Adresse Mail","On se contacte?"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}