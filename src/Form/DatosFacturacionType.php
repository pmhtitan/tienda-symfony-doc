<?php

namespace App\Form;

use App\Entity\DatosFacturacion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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

class DatosFacturacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'El nombre no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Nombre'
            ))
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'El email no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Email'
            ))
            ->add('telefono', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'El telefono no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Telefono'
            ))
            ->add('provincia', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La provincia no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Provincia'
            ))
            ->add('localidad', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La localidad no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Localidad'
            ))
            ->add('direccion', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La dirección no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Dirección'
            ))
            ->add('codigo_postal', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'El código postal no puede estar en blanco',
                    ]),
                ],
            ], array(
                'label' => 'Código Postal'
            ))
            ->add('submitGuardarDatosFacturacion', SubmitType::class, array(
                'label' => 'Guardar'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DatosFacturacion::class,
        ]);
    }
}