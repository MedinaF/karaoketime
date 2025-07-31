<?php
// src/Form/SongType.php
namespace App\Form;
use App\Entity\Song;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SongType extends AbstractType
{
    /**
     * Construit le formulaire pour l'entité Song.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ pour le titre de la chanson
            ->add('title', TextType::class, [
                'label' => 'Titre de la chanson',
            ])
            // Champ pour l'artiste
            ->add('artist', TextType::class, [
                'label' => 'Artiste',
            ])
            // Champ pour le lien YouTube (optionnel)
            ->add('youtubeLink', TextType::class, [
                'label' => 'Lien YouTube',
                'required' => false,
            ])
            // Champ pour les paroles (optionnel)
            ->add('lyrics', TextareaType::class, [
                'label' => 'Paroles',
                'required' => false,
            ])
            // Champ pour l'image de couverture (optionnel, non mappé à l'entité)
            ->add('image', FileType::class, [
                'label' => 'Image de couverture (jpg, png)',
                'mapped' => false,    // ne lie pas directement à la propriété image
                'required' => false,
                'attr' => ['accept' => 'image/*'],
            ])
            // Champ pour la catégorie (liste déroulante liée à l'entité Category)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie',
                'placeholder' => 'Choisir une catégorie',
            ])
        ;
    }

    /**
     * Configure les options du formulaire.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Song::class,
        ]);
    }
}