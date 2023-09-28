<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 *
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }
    public function findCustomerWithLatestAppointmentTime(): Customer
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.appointment_time', 'DESC')
            ->where('c.state = :state')
            ->setParameter('state', 'reserved')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()[0];
    }
    // public function findAllOrderedByReservationCodeDesc()
    // {
    //     return $this->createQueryBuilder('c')
    //         ->orderBy('c.reservation_code', 'DESC')
    //         ->getQuery()
    //         ->getResult();
    // }

    public function getLatestReservationNrPlusOne():int
    {
        $query_rez = $this->findOneBy([], ['reservation_code' => 'DESC']);
        if($query_rez==null)return 0;
        return intval($query_rez->getReservationCode())+1;
    }
    

//    /**
//     * @return Customer[] Returns an array of Customer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Customer
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
