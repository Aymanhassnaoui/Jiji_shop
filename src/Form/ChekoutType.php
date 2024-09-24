<?php

namespace App\Form;

use App\Entity\Chekout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;




class ChekoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [ // Assurez-vous que le nom de champ est correct
            'label' => 'Nom',
        ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                
            ])

            ->add('adresse', TextType::class, [
               
            ])

            ->add('numero_telephone', TelType::class,[
                'label' => 'Numéro téléphone',
                'attr' => [
                   
                    'placeholder' => 'Entrez votre numéro de téléphone'
                ]
            ])

            ->add('desAdresse', TextType::class, [
                'label' => false,
                'attr' => [

                    'placeholder' => 'Appartment, suite, unit etc: (optional)'
                ]
            ])


            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [

                    'placeholder' => 'Entrez votre Email adresse'
                ]
            ])
            
            ->add('passer', SubmitType::class, [
                'label' => 'Passer au paiement',
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chekout::class,
        ]);
    }
}
