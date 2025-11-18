<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddAddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('country', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un pays',
                    ])
                ],
            ])
            ->add("city", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez une ville',
                    ])
                ],
            ])
            ->add("street", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez une rue',
                    ])
                ]
            ])
            ->add("postalCode", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un code postal',
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
