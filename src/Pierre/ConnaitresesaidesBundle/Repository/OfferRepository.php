<?php

namespace Pierre\ConnaitresesaidesBundle\Repository;

/**
 * OfferRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OfferRepository extends \Doctrine\ORM\EntityRepository
{
        public function findPossibleOfferCities($statut, $city, $age, $salary) {
        
        $parameters = array(
            'statut' => $statut,
            'city' => $city,
            'age' => $age,
            'salarymin' => $salary,
            'salarymax' => $salary
        );
        


        $qb = $this->createQueryBuilder('offer')
                ->select('offer.name, offer.organism, offer.amount, offer.description, city.name AS location, offer.link')
                // Search for statut in entity Statut
                ->innerJoin('PierreConnaitresesaidesBundle:OfferStatut', 'astatut', 'WITH', 'astatut.offerId = offer.id')
                ->innerJoin('PierreConnaitresesaidesBundle:Statut', 'statut', 'WITH', 'astatut.statutId = statut.id')
                ->where('statut.name = :statut')

                // Search for city in entity City
                ->innerJoin('PierreConnaitresesaidesBundle:OfferCity', 'acity', 'WITH', 'acity.offerId = offer.id')
                ->innerJoin('PierreConnaitresesaidesBundle:City', 'city', 'WITH', 'city.id = acity.cityId')
                ->andWhere('city.name = :city')
                
                
                ->setParameters($parameters)

                //Search corresponding offer in entity Offer
                ->andWhere('offer.agemax >= :age')
                ->setParameter('age', $age)
                ->andWhere('offer.salaryminpermonth <= :salarymin')
                ->setParameter('salarymin', $salary)
                ->andWhere('offer.salarymaxpermonth >= :salarymax')
                ->setParameter('salarymax', $salary)
                ->orderBy('offer.name', 'ASC');

        return $qb->getQuery()
                        ->getResult();
    }

    public function findPossibleOfferCountries($statut, $city, $age, $salary) {
        
        $parameters = array(
            'statut' => $statut,
            'city' => $city,
            'age' => $age,
            'salarymin' => $salary,
            'salarymax' => $salary
        );
        


        $qb = $this->createQueryBuilder('offer')
                ->select('offer.name, offer.organism, offer.amount, offer.description, country.name AS location, offer.link')
                // Search for statut in entity Statut
                ->leftJoin('PierreConnaitresesaidesBundle:OfferStatut', 'astatut', 'WITH', 'astatut.offerId = offer.id')
                ->innerJoin('PierreConnaitresesaidesBundle:Statut', 'statut', 'WITH', 'astatut.statutId = statut.id')
                ->where('statut.name = :statut')

                // Search for city in entity City            
                ->innerJoin('PierreConnaitresesaidesBundle:OfferCountry', 'acountry', 'WITH', 'acountry.offerId = offer.id')
                ->innerJoin('PierreConnaitresesaidesBundle:Region', 'region', 'WITH', 'region.countryId = acountry.countryId')
                ->innerJoin('PierreConnaitresesaidesBundle:Department', 'dep', 'WITH', 'dep.regionId = region.id')
                ->innerJoin('PierreConnaitresesaidesBundle:City', 'city', 'WITH', 'city.departmentId = dep.id')
                ->andWhere('city.name = :city')
                 
                ->innerJoin('PierreConnaitresesaidesBundle:Country', 'country', 'WITH', 'acountry.countryId = country.id')
                ->setParameters($parameters)

                //Search corresponding offer in entity Offer
                ->andWhere('offer.agemax >= :age')
                ->setParameter('age', $age)
                ->andWhere('offer.salaryminpermonth <= :salarymin')
                ->setParameter('salarymin', $salary)
                ->andWhere('offer.salarymaxpermonth >= :salarymax')
                ->setParameter('salarymax', $salary)
                ->orderBy('offer.name', 'ASC');

        return $qb->getQuery()
                        ->getResult();
    }
    
    public function findPossibleOfferRegions($statut, $city, $age, $salary) {
        
        $parameters = array(
            'statut' => $statut,
            'city' => $city,
            'age' => $age,
            'salarymin' => $salary,
            'salarymax' => $salary
        );
        


        $qb = $this->createQueryBuilder('offer')
                ->select('offer.name, offer.organism, offer.amount, offer.description, region.name AS location, offer.link')
                // Search for statut in entity Statut
                ->leftJoin('PierreConnaitresesaidesBundle:OfferStatut', 'astatut', 'WITH', 'astatut.offerId = offer.id')
                ->innerJoin('PierreConnaitresesaidesBundle:Statut', 'statut', 'WITH', 'astatut.statutId = statut.id')
                ->where('statut.name = :statut')

                // Search for city in entity City            
                ->innerJoin('PierreConnaitresesaidesBundle:OfferRegion', 'aregion', 'WITH', 'aregion.offerId = offer.id')
                ->innerJoin('PierreConnaitresesaidesBundle:Department', 'dep', 'WITH', 'dep.regionId = aregion.regionId')
                ->innerJoin('PierreConnaitresesaidesBundle:City', 'city', 'WITH', 'city.departmentId = dep.id')
                ->andWhere('city.name = :city')
                 
                ->innerJoin('PierreConnaitresesaidesBundle:Region', 'region', 'WITH', 'region.id = aregion.regionId')
                ->setParameters($parameters)

                //Search corresponding offer in entity Offer
                ->andWhere('offer.agemax >= :age')
                ->setParameter('age', $age)
                ->andWhere('offer.salaryminpermonth <= :salarymin')
                ->setParameter('salarymin', $salary)
                ->andWhere('offer.salarymaxpermonth >= :salarymax')
                ->setParameter('salarymax', $salary)
                ->orderBy('offer.name', 'ASC');

        return $qb->getQuery()
                        ->getResult();
    }
    
    public function findPossibleOfferDepartments($statut, $city, $age, $salary) {
        
        $parameters = array(
            'statut' => $statut,
            'city' => $city,
            'age' => $age,
            'salarymin' => $salary,
            'salarymax' => $salary
        );


        $qb = $this->createQueryBuilder('offer')
                ->select('offer.name, offer.organism, offer.amount, offer.description, dep.name AS location, offer.link')
                // Search for statut in entity Statut
                ->leftJoin('PierreConnaitresesaidesBundle:OfferStatut', 'astatut', 'WITH', 'astatut.offerId = offer.id')
                ->innerJoin('PierreConnaitresesaidesBundle:Statut', 'statut', 'WITH', 'astatut.statutId = statut.id')
                ->where('statut.name = :statut')

                // Search for city in entity City            
                ->innerJoin('PierreConnaitresesaidesBundle:OfferDepartment', 'adep', 'WITH', 'adep.offerId = offer.id')
                ->innerJoin('PierreConnaitresesaidesBundle:City', 'city', 'WITH', 'city.departmentId = adep.departmentId')
                ->andWhere('city.name = :city')
                 
                ->innerJoin('PierreConnaitresesaidesBundle:Department', 'dep', 'WITH', 'dep.id = adep.departmentId')
                ->setParameters($parameters)

                //Search corresponding offer in entity Offer
                ->andWhere('offer.agemax >= :age')
                ->setParameter('age', $age)
                ->andWhere('offer.salaryminpermonth <= :salarymin')
                ->setParameter('salarymin', $salary)
                ->andWhere('offer.salarymaxpermonth >= :salarymax')
                ->setParameter('salarymax', $salary)
                ->orderBy('offer.name', 'ASC');

        return $qb->getQuery()
                        ->getResult();
    }
}
