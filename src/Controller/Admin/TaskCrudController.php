<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use App\Enum\TaskStatus;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Security\Core\Security;

class TaskCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Task::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Tarefa')
            ->setEntityLabelInPlural('Tarefas');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Título'),
            TextField::new('description', 'Descrição'),
            ChoiceField::new('status', 'Status')->setChoices([
                'Inativo' => TaskStatus::INACTIVE,
                'Ativo' => TaskStatus::ACTIVE,
                'Em Progresso' => TaskStatus::IN_PROGRESS,
                'Concluído' => TaskStatus::COMPLETED,
            ])
                ->formatValue(function ($value, $entity) {
                    return match ($value) {
                        TaskStatus::INACTIVE => 'Inativo',
                        TaskStatus::ACTIVE => 'Ativo',
                        TaskStatus::IN_PROGRESS => 'Em Progresso',
                        TaskStatus::COMPLETED => 'Concluído',
                        default => 'Desconhecido',
                    };
                }),
            DateTimeField::new('createdAt', 'Criado em')->hideOnForm(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Task) return;

        $user = $this->security->getUser();
        $entityInstance->setUser($user);

        parent::persistEntity($entityManager, $entityInstance);
    }
}
