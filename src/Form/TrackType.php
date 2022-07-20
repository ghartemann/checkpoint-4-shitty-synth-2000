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

class TrackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title*',
                'required' => true,
                'attr' => [
                    'class' => 'form-control saveFormControlInput1',
                    'placeholder' => 'A title for your track',
                ],
            ])
            ->add('artist', TextType::class, [
                'label' => 'Artist',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Artist name',
                ],
            ])
            ->add('picture', UrlType::class, [
                'label' => 'Picture*',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'URL',
                ],
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Notes*',
                'required' => true,
                'attr' => [
                    'class' => 'form-control saveFormControlTextarea1',
                    'placeholder' => 'Autofilled when playing',
                ],
            ])
            ->add('letters', TextareaType::class, [
                'label' => 'Keys*',
                'required' => true,
                'attr' => [
                    'class' => 'form-control saveFormControlTextarea2',
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
            ])
            ->add('creator', null, [
                'label' => 'Creator',
                'choice_label' => function ($creator) {
                    return $creator->getEmail();
                },
                'attr' => [
                    'class' => 'form-control',
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
