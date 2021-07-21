<?php
/**
 * Created by PhpStorm.
 * User: rafik
 * Date: 20/07/21
 * Time: 19:59
 */

namespace Proximum\Vimeet365\Core\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Proximum\Vimeet365\Core\Domain\Entity\Meeting;
use Proximum\Vimeet365\Core\Domain\Entity\Slot;
use Proximum\Vimeet365\Core\Domain\Repository\MeetingRepositoryInterface ;

/**
 * @template-extends ServiceEntityRepository<Account>
 *
 * @method Meeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meeting[]    findAll()
 * @method Meeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingRepository extends ServiceEntityRepository implements MeetingRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meeting::class);
    }

    public function getSortedByDate(\DateTime $dateDebut, \DateTime $dateFin): ? Meeting
    {

        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder
            ->select('m', 'meeting')
            ->where('rental.beginDate > :endDate')
            ->orWhere('rental.endDate < :beginDate')
            ->orWhere('rental.beginDate IS NULL')
            ->orWhere('rental.endDate IS NULL')
            ->setParameter('beginDate', $dateDebut->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $dateFin->format('Y-m-d H:i:s'))
//            ->setMaxResults($limit);
            ->getQuery()
            ->getOneOrNullResult();

             return $queryBuilder ;

//        return $queryBuilder->getQuery()->getResult();
    }

    public function add(Meeting $meeting): void
    {
        $this->getEntityManager()->persist($meeting);
    }
}
