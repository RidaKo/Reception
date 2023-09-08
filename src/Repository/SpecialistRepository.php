<?php

namespace App\Repository;

use App\Entity\Specialist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Specialist>
* @implements PasswordUpgraderInterface<Specialist>
 *
 * @method Specialist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Specialist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Specialist[]    findAll()
 * @method Specialist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialistRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specialist::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Specialist) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findIfSpecialistIsAuthorized($key):bool
    {
        $query = $this->createQueryBuilder('s')
            ->andWhere('s.secretKey = :key')
            ->andWhere('s.password IS NOT NULL')
            ->andWhere('s.email IS NOT NULL')
            ->setParameter('key', $key)
            ->orderBy('s.id', 'ASC')
            ->getQuery();

            try {
                $specialist = $query->getSingleResult(); // Returns a single Product object
                return true;
            } catch (\Doctrine\ORM\NoResultException $e) {
                return false;
            } catch (\Doctrine\ORM\NonUniqueResultException $e) {
                return false;
            }
        
        

    }

//    /**
//     * @return Specialist[] Returns an array of Specialist objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Specialist
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
