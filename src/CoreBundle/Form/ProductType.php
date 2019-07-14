<?php

namespace CoreBundle\Form;

use CoreBundle\Entity\Glasses;
use CoreBundle\Entity\Category;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{





    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $category = $options['category'];
        $array = array();

        for ($i = 0; $i < sizeof($category); $i++) {
            $tiny_array = array($category[$i]->categoryName => $category[$i]->id,);
            $array = array_merge($array, $tiny_array);
        }
        $builder
            ->add('productName', TextType::class, ['label' => 'Product name', 'attr' => array('class' => 'form-control')])
            ->add('category', ChoiceType::class, [
                'choices'  =>

                $array,
                'label' => 'Category', 'attr' => array('class' => 'form-control')
            ])
            ->add('sex', ChoiceType::class, [
                'choices'  => [

                    'Male' => '0',
                    'Female' => '1',

                ],
                'label' => ' Gender', 'attr' => array('class' => 'form-control')
            ])
            ->add('description', TextareaType::class, [

                'label' => ' Description', 'attr' => array('class' => 'form-control')
            ])
            ->add('imgRoute', FileType::class, [
                'label' => 'Glasses image',
                'mapped' => false,
                'label' => 'Upload image', 'attr' => array('class' => 'form-control'),
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/x-png',
                            'image/gif',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid IMAGE archive',
                    ])
                ],
            ])
            ->add('price', IntegerType::class, ['label' => 'Price', 'attr' => array('class' => 'form-control')]);
    }


    public function configureOptions(OptionsResolver $resolver)


    {

        $resolver->setDefaults([
            'data_class' => Glasses::class,
            'category' => null,
        ]);
    }
}
