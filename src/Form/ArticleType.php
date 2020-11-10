<?php

namespace App\Form;

use App\Entity\Article;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticleType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, $this->getConfig("Libelle de l'article","Mettre le libelle de l'article"))
            ->add('description', TextareaType::class, $this->getConfig("Description de l'article","Mettre la description de l'article"))
            ->add('prix', MoneyType::class, $this->getConfig("Prix de l'article","Mettre le prix de l'article"))
            ->add('image', TextType::class, $this->getConfig("Image de l'article","Mettre l'image de l'article"))
            ->add('images', CollectionType::class, ['entry_type' => ImageType::class, 'allow_add' => true, 'allow_delete' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
