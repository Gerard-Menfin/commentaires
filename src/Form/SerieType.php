<?php

namespace App\Form;

use App\Entity\Serie, App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('synopsis')
            ->add('affiche', FileType::class, [
                "mapped"    => false,
                "required"  => false
            ])
            ->add('genres', EntityType::class, [
                "class"         => Genre::class,
                "choice_label"  => "libelle",
                "multiple"      => true,
                "expanded"      => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
