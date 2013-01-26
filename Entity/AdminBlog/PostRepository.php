<?php

namespace Mv\BlogBundle\Entity\AdminBlog;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    /**
     * 
     * @return Criteria
     */
    static function getOrderedCriteria(){
        return  $criteria = Criteria::create()->orderBy(array('publied' => Criteria::DESC));
    }

    /**
     * 
     * @return Criteria
     */
    static function getPubliedOrderedCriteria(){
        return self::getOrderedCriteria()->andWhere(Criteria::expr()->lte('publied', new \DateTime('now')));
    }
    
    /**
     * 
     * @return array
     */
    public function findAllOrdered(){
        $entities = new ArrayCollection($this->findAll());
        
        return $entities->matching(self::getOrderedCriteria())->toArray();
    }

    /**
     * 
     * @return array
     */
    public function findAllPubliedOrdered(){
        $entities = new ArrayCollection($this->findAll());
        
        return $entities->matching(self::getPubliedOrderedCriteria())->toArray();
    }
    
    public function findByCategoryPubliedOrdered($id){
        $entities = $this->createQueryBuilder('p')
                        ->addSelect('c')
                        ->innerJoin('p.categories', 'c')
                        ->having('c.id = :id')
                        ->setParameter('id', $id)
                        ->getQuery()
                        ->getResult();
        $entities = new ArrayCollection($entities);
        
        return $entities->matching(self::getPubliedOrderedCriteria())->toArray();
    }
}
