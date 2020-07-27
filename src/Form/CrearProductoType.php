<?php

namespace App\Form;

use App\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;

class CrearProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'El nombre del producto no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Nombre'
            ))
            ->add('descripcion', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La descripcion del producto no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Descripcion'
            ))
            ->add('precio', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'El precio no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Precio'
            ))
            ->add('stock', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'El stock del producto no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Stock'
            ))
            ->add('categoria', EntityType::class, array(
                'class' => 'App\Entity\Categoria',
                'choice_label' => 'nombre'
            ))
            ->add('imagen', FileType::class, [
                'label' => 'Imagen del producto',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '8192k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/bmp',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image file',
                    ])
                ],
            ])
            ->add('submitCrearProducto', SubmitType::class, array(
                'label' => 'Crear'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}