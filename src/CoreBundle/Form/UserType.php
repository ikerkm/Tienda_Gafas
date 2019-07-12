<?php

namespace CoreBundle\Form;

use CoreBundle\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{





    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email', EmailType::class, ['label' => 'Email', 'attr' => array('class' => 'form-control')])
            ->add('name', TextType::class, ['label' => 'Name', 'attr' => array('class' => 'form-control')])
            ->add('surname', TextType::class, ['label' => 'Last name', 'attr' => array('class' => 'form-control')])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Password', 'attr' => array('class' => 'form-control')],
                'second_options' => ['label' => 'Repeat Password', 'attr' => array('class' => 'form-control')],
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
