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
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProductType extends AbstractType
{





    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //  $category_selector = $this->getDoctrine()->getRepository(Category::class);

        $category = $options['category'];
        dump($category);
        // dump($category['data']['category'][0]->id);
        $array = array();
        /*
        for ($i = 0; $i < sizeof($category['data']['category']); $i++) {
            $tiny_array = array($category['data']['category'][$i]->categoryName => $category['data']['category'][$i]->id,);
            $array = array_merge($array, $tiny_array);
        };*/

        for ($i = 0; $i < sizeof($category); $i++) {
            $tiny_array = array($category[$i]->categoryName => $category[$i]->id,);
            $array = array_merge($array, $tiny_array);
        }
        dump($array);

        $builder
            ->add('productName', TextType::class)
            ->add('price', NumberType::class)
            ->add('category', ChoiceType::class, [
                'choices'  =>

                $array,
            ])
            ->add('sex', ChoiceType::class, [
                'choices'  => [

                    'Male' => '0',
                    'Female' => '1',
                    'Both' => '2',
                ],
            ])

            ->add('imgRoute', FileType::class, [
                'label' => 'Glasses image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // everytime you edit the Product details
                'required' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
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
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)


    {

        $resolver->setDefaults([
            'data_class' => Glasses::class,
            'category' => null,
        ]);
    }
}
