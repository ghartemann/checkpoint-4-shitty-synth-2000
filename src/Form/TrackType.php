<?php

namespace App\Form;

use App\Entity\Track;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TrackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title*',
                'required' => true,
                'attr' => [
                    'class' => 'form-control saveFormControlInput1 mb-2',
                    'placeholder' => 'A title for your track',
                ],
            ])
            ->add('artist', TextType::class, [
                'label' => 'Artist',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Artist name',
                ],
            ])
            ->add('picture', UrlType::class, [
                'label' => 'Picture*',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'URL',
                ],
            ])
            ->add('youtube', UrlType::class, [
                'label' => 'Youtube video',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Youtube video URL',
                ],
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Notes*',
                'required' => true,
                'attr' => [
                    'class' => 'form-control saveFormControlTextarea1 mb-2',
                    'placeholder' => 'Autofilled when playing',
                ],
            ])
            ->add('letters', TextareaType::class, [
                'label' => 'Keys*',
                'required' => true,
                'attr' => [
                    'class' => 'form-control saveFormControlTextarea2 mb-2',
                    'placeholder' => 'Autofilled when playing',
                ],
            ])
            ->add('difficulty', NumberType::class, [
                'label' => 'Difficulty (1-3)*',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Difficulty level (1-3)',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1]),
                    new Length(['max' => 3]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Track::class,
        ]);
    }
}
