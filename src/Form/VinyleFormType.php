<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Vinyle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VinyleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du vinyle',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'Stock',
            ])
            ->add('precommande', CheckboxType::class, [
                'label' => 'Précommande',
                'mapped' => false,
                'required' => false,
            ])
            ->add('author', AuthorAutocompleteField::class, [
                'required' => false
            ])
            ->add('newAuthor', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Nouvel auteur'
            ])
            ->add('newAuthorName', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Nom du nouvel auteur'
            ])
            ->add('genres', GenreAutocompleteField::class)
            ->add('image', FileType::class, [
                'label' => 'Image (JPG, PNG file)',
                'mapped' => false,
                'required' => false,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vinyle::class,
        ]);
    }
}
