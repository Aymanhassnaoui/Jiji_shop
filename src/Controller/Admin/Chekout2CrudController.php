<?php

namespace App\Controller\Admin;

use App\Entity\Chekout;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class Chekout2CrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chekout::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
