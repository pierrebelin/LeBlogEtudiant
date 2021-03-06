<?php

namespace Pierre\ConnaitresesaidesBundle\Repository;

/**
 * AidRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AidRepository extends \Doctrine\ORM\EntityRepository
{

    public function findAllAids()
    {
        $qb = $this->createQueryBuilder('aid')
            ->select('org.name AS organism, aid.name, aid.amount, aid.description, aid.link, org.logo')
            ->innerJoin('PierreConnaitresesaidesBundle:Organism', 'org', 'WITH', 'org.id = aid.organismID')
            ->orderBy('org.name', 'ASC');

        return $qb->getQuery()
            ->getResult();
    }



    public function findPossibleAidCities($statut, $city, $age, $salary)
    {
        $parameters = array(
            'statut' => $statut,
            'city' => $city,
            'age' => $age,
            'salarymin' => $salary,
            'salarymax' => $city
        );

        $qb = $this->createQueryBuilder('aid')
            ->select('org.name AS organism, aid.name, aid.amount, aid.description, city.name AS location, aid.link, org.logo')
            ->innerJoin('PierreConnaitresesaidesBundle:Organism', 'org', 'WITH', 'org.id = aid.organismID')            // Search for statut in entity Statut
            ->innerJoin('PierreConnaitresesaidesBundle:AidStatut', 'astatut', 'WITH', 'astatut.aidId = aid.id')
            ->innerJoin('PierreConnaitresesaidesBundle:Statut', 'statut', 'WITH', 'astatut.statutId = statut.id')
            ->where('statut.name = :statut')
            // Search for city in entity City
            ->innerJoin('PierreConnaitresesaidesBundle:AidCity', 'acity', 'WITH', 'acity.aidId = aid.id')
            ->innerJoin('PierreConnaitresesaidesBundle:City', 'city', 'WITH', 'city.id = acity.cityId')
            ->andWhere('city.name = :city')
            ->setParameters($parameters)
            //Search corresponding aid in entity Aid
            ->andWhere('aid.agemax >= :age')
            ->setParameter('age', $age)
            ->andWhere('aid.agemin <= :age')
            ->setParameter('age', $age)
            ->andWhere('aid.salaryminpermonth <= :salarymin')
            ->setParameter('salarymin', $salary)
            ->andWhere('aid.salarymaxpermonth >= :salarymax')
            ->setParameter('salarymax', $salary)
            ->orderBy('aid.name', 'ASC');

        return $qb->getQuery()
            ->getResult();
    }

    public function findPossibleAidCountries($statut, $city, $age, $salary)
    {

        $parameters = array(
            'statut' => $statut,
            'city' => $city,
            'age' => $age,
            'salarymin' => $salary,
            'salarymax' => $salary
        );


        $qb = $this->createQueryBuilder('aid')
            ->select('org.name AS organism, aid.name, aid.amount, aid.description, city.name AS location, aid.link, org.logo')
            ->innerJoin('PierreConnaitresesaidesBundle:Organism', 'org', 'WITH', 'org.id = aid.organismID')            // Search for statut in entity Statut
            ->leftJoin('PierreConnaitresesaidesBundle:AidStatut', 'astatut', 'WITH', 'astatut.aidId = aid.id')
            ->innerJoin('PierreConnaitresesaidesBundle:Statut', 'statut', 'WITH', 'astatut.statutId = statut.id')
            ->where('statut.name = :statut')
            // Search for city in entity City
            ->innerJoin('PierreConnaitresesaidesBundle:AidCountry', 'acountry', 'WITH', 'acountry.aidId = aid.id')
            ->innerJoin('PierreConnaitresesaidesBundle:Region', 'region', 'WITH', 'region.countryId = acountry.countryId')
            ->innerJoin('PierreConnaitresesaidesBundle:Department', 'dep', 'WITH', 'dep.regionId = region.id')
            ->innerJoin('PierreConnaitresesaidesBundle:City', 'city', 'WITH', 'city.departmentId = dep.id')
            ->andWhere('city.name = :city')
            ->innerJoin('PierreConnaitresesaidesBundle:Country', 'country', 'WITH', 'acountry.countryId = country.id')
            ->setParameters($parameters)
            //Search corresponding aid in entity Aid
            ->andWhere('aid.agemax >= :age')
            ->setParameter('age', $age)
            ->andWhere('aid.agemin <= :age')
            ->setParameter('age', $age)
            ->andWhere('aid.salaryminpermonth <= :salarymin')
            ->setParameter('salarymin', $salary)
            ->andWhere('aid.salarymaxpermonth >= :salarymax')
            ->setParameter('salarymax', $salary)
            ->orderBy('aid.name', 'ASC');

        return $qb->getQuery()
            ->getResult();
    }

    public function findPossibleAidRegions($statut, $city, $age, $salary)
    {

        $parameters = array(
            'statut' => $statut,
            'city' => $city,
            'age' => $age,
            'salarymin' => $salary,
            'salarymax' => $salary
        );


        $qb = $this->createQueryBuilder('aid')
            ->select('org.name AS organism, aid.name, aid.amount, aid.description, city.name AS location, aid.link, org.logo')
            ->innerJoin('PierreConnaitresesaidesBundle:Organism', 'org', 'WITH', 'org.id = aid.organismID')            // Search for statut in entity Statut
            ->leftJoin('PierreConnaitresesaidesBundle:AidStatut', 'astatut', 'WITH', 'astatut.aidId = aid.id')
            ->innerJoin('PierreConnaitresesaidesBundle:Statut', 'statut', 'WITH', 'astatut.statutId = statut.id')
            ->where('statut.name = :statut')
            // Search for city in entity City
            ->innerJoin('PierreConnaitresesaidesBundle:AidRegion', 'aregion', 'WITH', 'aregion.aidId = aid.id')
            ->innerJoin('PierreConnaitresesaidesBundle:Department', 'dep', 'WITH', 'dep.regionId = aregion.regionId')
            ->innerJoin('PierreConnaitresesaidesBundle:City', 'city', 'WITH', 'city.departmentId = dep.id')
            ->andWhere('city.name = :city')
            ->innerJoin('PierreConnaitresesaidesBundle:Region', 'region', 'WITH', 'region.id = aregion.regionId')
            ->setParameters($parameters)
            //Search corresponding aid in entity Aid
            ->andWhere('aid.agemax >= :age')
            ->setParameter('age', $age)
            ->andWhere('aid.agemin <= :age')
            ->setParameter('age', $age)
            ->andWhere('aid.salaryminpermonth <= :salarymin')
            ->setParameter('salarymin', $salary)
            ->andWhere('aid.salarymaxpermonth >= :salarymax')
            ->setParameter('salarymax', $salary)
            ->orderBy('aid.name', 'ASC');

        return $qb->getQuery()
            ->getResult();
    }

    public function findPossibleAidDepartments($statut, $city, $age, $salary)
    {

        $parameters = array(
            'statut' => $statut,
            'city' => $city,
            'age' => $age,
            'salarymin' => $salary,
            'salarymax' => $salary
        );


        $qb = $this->createQueryBuilder('aid')
            ->select('org.name AS organism, aid.name, aid.amount, aid.description, city.name AS location, aid.link, org.logo')
            ->innerJoin('PierreConnaitresesaidesBundle:Organism', 'org', 'WITH', 'org.id = aid.organismID')            // Search for statut in entity Statut
            ->leftJoin('PierreConnaitresesaidesBundle:AidStatut', 'astatut', 'WITH', 'astatut.aidId = aid.id')
            ->innerJoin('PierreConnaitresesaidesBundle:Statut', 'statut', 'WITH', 'astatut.statutId = statut.id')
            ->where('statut.name = :statut')
            // Search for city in entity City
            ->innerJoin('PierreConnaitresesaidesBundle:AidDepartment', 'adep', 'WITH', 'adep.aidId = aid.id')
            ->innerJoin('PierreConnaitresesaidesBundle:City', 'city', 'WITH', 'city.departmentId = adep.departmentId')
            ->andWhere('city.name = :city')
            ->innerJoin('PierreConnaitresesaidesBundle:Department', 'dep', 'WITH', 'dep.id = adep.departmentId')
            ->setParameters($parameters)
            //Search corresponding aid in entity Aid
            ->andWhere('aid.agemax >= :age')
            ->setParameter('age', $age)
            ->andWhere('aid.agemin <= :age')
            ->setParameter('age', $age)
            ->andWhere('aid.salaryminpermonth <= :salarymin')
            ->setParameter('salarymin', $salary)
            ->andWhere('aid.salarymaxpermonth >= :salarymax')
            ->setParameter('salarymax', $salary)
            ->orderBy('aid.name', 'ASC');

        return $qb->getQuery()
            ->getResult();
    }
}
