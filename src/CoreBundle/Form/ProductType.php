<?php

namespace CoreBundle\Form;

use CoreBundle\Entity\Glasses;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProductType extends AbstractType
{





    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $category = $options;
        dump($category);
        $builder
            ->add('ProductName', TextType::class)
            ->add('Category', TextType::class)
            ->add('Sex', TextType::class)
            ->add('Route', FileType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
