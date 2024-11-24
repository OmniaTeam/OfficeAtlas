<?php

namespace App\Repository;

use App\Entity\Employee;
use App\Entity\Request;
use App\Entity\Workspace;
use App\Enum\EmployeeFilterFieldsEnum;
use App\Enum\PaginationFieldsEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function findEmployeeByFilter(array $filter): array
    {
        $qb = $this->createQueryBuilder('e');
        foreach ($filter as $field => $value) {
            switch ($field) {
                case EmployeeFilterFieldsEnum::FIO->param():
                    $qb->andWhere($qb->expr()->like('e.'.$field, ':'.$field));
                    break;
                case PaginationFieldsEnum::CURRENT_PAGE->param():
                    $qb->setFirstResult(
                        ((int)$filter[PaginationFieldsEnum::CURRENT_PAGE->param()]-1)
                            * (int)$filter[PaginationFieldsEnum::PER_PAGE->param()]
                    );
                    break;
                case PaginationFieldsEnum::PER_PAGE->param():
                    $qb->setMaxResults((int)$filter[PaginationFieldsEnum::PER_PAGE->param()]);
                    break;
                default:
                    $qb->andWhere('e.'.$field.' = :'.$field);
                    break;
            }
        }
        unset($filter[PaginationFieldsEnum::CURRENT_PAGE->param()]);
        unset($filter[PaginationFieldsEnum::PER_PAGE->param()]);
        foreach ($filter as $field => $value) {
            if ($field === EmployeeFilterFieldsEnum::FIO->param()) {
                $qb->setParameter($field, '%'.$value.'%');
            } else {
                $qb->setParameter($field, $value);
            }
        }
        return $qb->getQuery()->getResult();
    }

    public function findFreeEmployees(int $officeId): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.workspaces', 'w')
            ->where('w.id IS NULL')
            ->where('e.office = :officeId')
            ->setParameter('officeId', $officeId)
            ->getQuery()->getResult();
    }

    //    /**
    //     * @return Employee[] Returns an array of Employee objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Employee
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
