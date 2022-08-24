<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options["data"];   // l'indice "data" permet de récupérer l'entité utilisée
        $builder                    // pour générer le formulaire
            ->add('pseudo')
            ->add('roles', ChoiceType::class, [
                "choices" => [
                    "Administrateur" => "ROLE_ADMIN",
                    "Contributeur"   => "ROLE_CONTRIBUTEUR",
                    "Modérateur"     => "ROLE_MODERATEUR",
                ],
                "multiple"  => true,
                "expanded"  => true,
                "label"     => "Autorisation"

            ])
            ->add('password', TextType::class, [
                "label"     => "Mot de passe",
                "mapped"    => false,
                "required"  => !$user->getId() ? true : false

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
