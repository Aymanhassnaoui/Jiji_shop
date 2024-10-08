<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Produits;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;


use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class ProduitsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produits::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           
           
         
            ImageField::new('photo')->setUploadDir('public'),
            TextField::new ('titre'),
            MoneyField::new('prix')->setCurrency('EUR'),
            NumberField::new('discount')
    ->setLabel('Discount (%)')
    ->setFormTypeOption('attr', ['max' => 100, 'min' => 0, 'step' => '0.01']) 
    ->setFormTypeOption('html5', true), 
            ChoiceField::new('genre')
            ->setChoices([
                'Femme' => 'femme',
                'Homme' => 'homme',
            ]),
            TextField::new ('titre_description'),
            TextField::new ('description'),
            AssociationField::new('category'),

            
           
        ];
    }



    
    
}
