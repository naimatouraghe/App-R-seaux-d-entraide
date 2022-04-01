<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('content'),
            DateTimeField::new('created_at')->hideOnForm(),
        ];
    }

    public function persistEntity(EntityManagerInterface $en, $entityInstance):void
{
    if(!$entityInstance instanceof Comment) return;

    $entityInstance->setCreatedAt(new \DateTimeImmutable);
    
    parent::persistEntity($en, $entityInstance);
}    
}
