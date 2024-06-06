<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PictureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('filename'),
            TextEditorField::new('description')
                ->setFormType("TextType"),
            ImageField::new('filename', 'description')
                ->hideOnForm(),
            AssociationField::new('user'),
            DateField::new('createdAt')
                ->setLabel("Created at"),
            DateField::new('Updated at')
                ->setLabel("Updated at"),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Pictures')
            ->setEntityLabelInSingular('Picture')
            ->setSearchFields(['user', 'filename'])
            ->setDefaultSort(['user' => 'ASC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('filename');
    }
}
