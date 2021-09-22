<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //ajout des champs formulaire
        $builder
            ->add('title', null, [
                'label' => 'Titre du jeu'
            ])
            ->add('content', null, [
                'label' => 'Description du jeu',
                'attr' => [
                    'rows' => 5
                ]
            ])
            ->add('enabled', ChoiceType::class, [
                'label' => 'Publié',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true
            ])
            ->add('publishedAt', null, [
                'label' => 'Date de publication',
                'date_widget' => 'single_text'
            ])
        ;
    }

    //indique que le formulaire est conçu pour entity Game, peut bug avec des formulaires imbriqués.
    public function configureOptions(OptionsResolver $resolver)
    {
        //indique que ce formulaire est lié à l'entité Game
        $resolver->setDefaults([
            'data_class' => Game ::class //retourne une chaine avec l'espace de nom de cette classe
        ]);
    }
}