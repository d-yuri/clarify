<?php

namespace App\Repository;

use App\Entity\Carrier;
use App\Entity\CarrierPriceRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarrierPriceRule>
 */
class CarrierPriceRuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarrierPriceRule::class);
    }

    public function getPriceByCarrierNameAndWeight(string $carrierName, int $weight): ?CarrierPriceRule
    {
        $qb = $this->createQueryBuilder('cp');
        $flatSearch = $qb->expr()->orX(
            $qb->expr()->isNull('cp.weightLimit'),
            $qb->expr()->gte('cp.weightLimit', ':weight')
        );
        $perKgSearch = $qb->expr()->isNotNull('cp.pricePerKg');

        $qb->where($qb->expr()->orX($flatSearch, $perKgSearch))
            ->join('cp.carrier', 'c')
            ->andWhere($qb->expr()->eq('c.name', ':carrierName'));

        $qb->setParameter('weight', $weight)
            ->setParameter('carrierName', $carrierName);
        $qb->setMaxResults(1);

       return $qb->getQuery()->getOneOrNullResult();
    }
}
