<?php

namespace Pierre\BonsPlansBundle\Repository;


/**
 * BlogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BonsPlanRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLatestUpdatedBonsPlans($page = 1, $limit = 10)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();

        $rsm->addScalarResult('localisation', 'localisation');
        $rsm->addScalarResult('title', 'title');
        $rsm->addScalarResult('logo', 'logo');
        $rsm->addScalarResult('slug', 'slug');
        $rsm->addScalarResult('updated', 'updated');
        $rsm->addScalarResult('nbcomments', 'nbcomments');


        $sql = "select t.* from (
                    select b.*, c.name as localisation, count(bc.id) as nbcomments
                    from city c, bonsplan_city ac, bonsplan b
                    left join bonsplanscomment bc on bc.bonsplan_id = b.id
                    where c.id = ac.city_id
                    and ac.bonplan_id = b.id
                    group by b.id

                    union

                    select b.*, d.name as localisation, count(bc.id) as nbcomments
                    from department d, bonsplan_department ad, bonsplan b
                    left join bonsplanscomment bc on bc.bonsplan_id = b.id
                    where d.id = ad.department_id
                    and ad.bonplan_id = b.id
                    group by b.id


                    union

                    select b.*, r.name as localisation, count(bc.id) as nbcomments
                    from region r, bonsplan_region ar, bonsplan b
                    left join bonsplanscomment bc on bc.bonsplan_id = b.id
                    where r.id = ar.region_id
                    and ar.bonplan_id = b.id
                    group by b.id

                    union

                    select b.*, cou.name as localisation, count(bc.id) as nbcomments
                    from country cou, bonsplan_country acou, bonsplan b
                    left join bonsplanscomment bc on bc.bonsplan_id = b.id
                    where cou.id = acou.country_id
                    and acou.bonplan_id = b.id
                    group by b.id)t
                order by t.updated DESC
                limit :offset, :limit";

        $em = $this->getEntityManager();
        $results = $em->createNativeQuery($sql, $rsm)
            ->setParameter('limit', $limit)
            ->setParameter('offset', (($page - 1) * $limit))
            ->getResult();

        return $results;
    }

    public function getLatestUpdatedBonsPlansCity($page = 1, $limit = 10, $city)
    {
//        $em = $this->getDoctrine()->getManager();
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();

        $rsm->addScalarResult('localisation', 'localisation');
        $rsm->addScalarResult('title', 'title');
        $rsm->addScalarResult('logo', 'logo');
        $rsm->addScalarResult('slug', 'slug');
        $rsm->addScalarResult('updated', 'updated');
        $rsm->addScalarResult('nbcomments', 'nbcomments');


        $sql = "select t.* from (
                    select b.*, c.name as localisation, count(bc.id) as nbcomments
                    from city c, bonsplan_city ac, bonsplan b
                    left join bonsplanscomment bc on bc.bonsplan_id = b.id
                    where c.id = ac.city_id
                    and ac.bonplan_id = b.id
                    and c.name = :city
                    group by b.id
                    
                    union
                    
                    select b.*, d.name as localisation, count(bc.id) as nbcomments
                    from city c, department d, bonsplan_department ad, bonsplan b
                    left join bonsplanscomment bc on bc.bonsplan_id = b.id
                    where d.id = ad.department_id
                    and c.department_id = d.id
                    and ad.bonplan_id = b.id
                    and c.name = :city
                    group by b.id

                    
                    union
                    
                    select b.*, r.name as localisation, count(bc.id) as nbcomments
                    from city c, department d, region r, bonsplan_region ar, bonsplan b
                    left join bonsplanscomment bc on bc.bonsplan_id = b.id
                    where r.id = ar.region_id
                    and d.region_id = r.id
                    and c.department_id = d.id
                    and ar.bonplan_id = b.id
                    and c.name = :city
                    group by b.id
                    
                    union
                    
                    select b.*, cou.name as localisation, count(bc.id) as nbcomments
                    from city c, department d, region r, country cou, bonsplan_country acou, bonsplan b
                    left join bonsplanscomment bc on bc.bonsplan_id = b.id
                    where cou.id = acou.country_id
                    and r.country_id = cou.id
                    and d.region_id = r.id
                    and c.department_id = d.id
                    and acou.bonplan_id = b.id
                    and c.name = :city
                    group by b.id)t
                order by t.updated DESC
                limit :offset, :limit";

        $em = $this->getEntityManager();
        $results = $em->createNativeQuery($sql, $rsm)
            ->setParameter('city', $city)
            ->setParameter('limit', $limit)
            ->setParameter('offset', (($page - 1) * $limit))
            ->getResult();

        return $results;
    }

    public function getCountBonsPlans()
    {
        return $qb = $this->createQueryBuilder('bonplan')
            ->select('COUNT(bonplan)')
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function getCountBonsPlansCity($city)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();

        $rsm->addScalarResult('count', 'count');

        $sql = "select count(*) as count from (
                    select b.*, c.name as localisation
                    from city c, bonsplan_city ac, bonsplan b
                    where c.id = ac.city_id
                    and ac.bonplan_id = b.id
                    and c.name = :city
                    
                    union
                    
                    select b.*, d.name as localisation
                    from city c, department d, bonsplan_department ad, bonsplan b
                    where d.id = ad.department_id
                    and c.department_id = d.id
                    and ad.bonplan_id = b.id
                    and c.name = :city
                    
                    union
                    
                    select b.*, r.name as localisation
                    from city c, department d, region r, bonsplan_region ar, bonsplan b
                    where r.id = ar.region_id
                    and d.region_id = r.id
                    and c.department_id = d.id
                    and ar.bonplan_id = b.id
                    and c.name = :city
                    
                    union
                    
                    select b.*, cou.name as localisation
                    from city c, department d, region r, country cou, bonsplan_country acou, bonsplan b
                    where cou.id = acou.country_id
                    and r.country_id = cou.id
                    and d.region_id = r.id
                    and c.department_id = d.id
                    and acou.bonplan_id = b.id
                    and c.name = :city)t";

        $em = $this->getEntityManager();
        return $result = $em->createNativeQuery($sql, $rsm)
            ->setParameter('city', $city)
            ->getSingleScalarResult();
    }

    public function getBonPlanBySlug($slug)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();

        $rsm->addScalarResult('localisation', 'localisation');
        $rsm->addScalarResult('title', 'title');
        $rsm->addScalarResult('logo', 'logo');
        $rsm->addScalarResult('slug', 'slug');
        $rsm->addScalarResult('updated', 'updated');
        $rsm->addScalarResult('content', 'content');
        $rsm->addScalarResult('link', 'link');
        $rsm->addScalarResult('metakeywords', 'metakeywords');
        $rsm->addScalarResult('description', 'description');
        $rsm->addScalarResult('facebookimage', 'facebookimage');
        $rsm->addScalarResult('facebooklink', 'facebooklink');
        $rsm->addScalarResult('id', 'id');

        $sql = "select t.* from (
                    select b.*, c.name as localisation
                    from city c, bonsplan_city ac, bonsplan b
                    where c.id = ac.city_id
                    and ac.bonplan_id = b.id
                    and b.slug = :slug
                    
                    union
                    
                    select b.*, d.name as localisation
                    from city c, department d, bonsplan_department ad, bonsplan b
                    where d.id = ad.department_id
                    and c.department_id = d.id
                    and ad.bonplan_id = b.id
                    and b.slug = :slug
                    
                    union
                    
                    select b.*, r.name as localisation
                    from city c, department d, region r, bonsplan_region ar, bonsplan b
                    where r.id = ar.region_id
                    and d.region_id = r.id
                    and c.department_id = d.id
                    and ar.bonplan_id = b.id
                    and b.slug = :slug
                    
                    union
                    
                    select b.*, cou.name as localisation
                    from city c, department d, region r, country cou, bonsplan_country acou, bonsplan b
                    where cou.id = acou.country_id
                    and r.country_id = cou.id
                    and d.region_id = r.id
                    and c.department_id = d.id
                    and acou.bonplan_id = b.id
                    and b.slug = :slug)t";

        $em = $this->getEntityManager();
        $results = $em->createNativeQuery($sql, $rsm)
            ->setParameter('slug', $slug)
            ->getSingleResult();

        return $results;
    }
}
