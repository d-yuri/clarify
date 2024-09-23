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

    public function getPriceByCarrierNameAndWeight(Carrier $carrier, int $weight): ?CarrierPriceRule
    {
        $qb = $this->createQueryBuilder('cp');
        $flatSearch = $qb->expr()->orX(
            $qb->expr()->isNull('cp.weightLimit'),
            $qb->expr()->gte('cp.weightLimit', ':weight')
        );
        $perKgSearch = $qb->expr()->isNotNull('cp.pricePerKg');

        $qb->where($qb->expr()->orX($flatSearch, $perKgSearch))
            ->join('cp.carrier', 'c')
            ->andWhere($qb->expr()->eq('c', ':carrier'));

        $qb->setParameter('weight', $weight)
            ->setParameter('carrier', $carrier);
        $qb->setMaxResults(1);
        $qb->addOrderBy('cp.weightLimit');

        return $qb->getQuery()->getOneOrNullResult();
    }
}
