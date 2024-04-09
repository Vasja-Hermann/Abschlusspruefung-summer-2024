<?php

namespace App\Form\AccessToken;

use App\Entity\AccessToken;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccessTokenType extends AbstractType
{
    public const CREATE = "create";
    public const UPDATE = "update";
    public const SAVE_AND_GENERATE = "Speichern und Generieren";
    public const SAVE = "Speichern";

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $saveLabel = $this::SAVE;
        if ($options['type'] === $this::CREATE) {
            $saveLabel = $this::SAVE_AND_GENERATE;
        }

        $builder->add('name', TextareaType::class, [
            'label' => "Verwendungszweck*",
            'attr' => [
                'placeholder' => "Beschreibung",
                'class' => "height-medium"
            ],
            'required' => true,
            'help' => "* Diese Felder müssen ausgefüllt werden.",
            'help_attr' => [
                'class' => "help-sm"
            ],
        ])
            ->add('submit', SubmitType::class, [
            'label' => $saveLabel,
            'attr' => [
                'class' => 'submitBtn'
            ]
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => AccessToken::class,
            'type' => null
        ]);
    }
}