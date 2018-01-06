<?php


namespace Pierre\BonsPlansBundle\Controller;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class BonsPlanController extends Controller
{
    public function indexAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $maxBonsPlan = $this->container->getParameter('pierre_bonsplans.bonsplans.max_article');

        $countBonsPlans = $this->getDoctrine()
            ->getRepository('PierreBonsPlansBundle:BonsPlan')
            ->getCountBonsPlans();

        $pagination = array(
            'page' => $page,
            'route' => 'PierreBonsPlansBundle_homepage',
            'pages_count' => max(1, ceil($countBonsPlans / $maxBonsPlan)),
            'route_params' => array()
        );

        $form = $this->createFormBuilder()
            ->add('city', EntityType::class, array(
                'label' => 'Sélectionnez votre ville',
                'placeholder' => 'Choisir une ville',
                'class' => 'PierreConnaitresesaidesBundle:City',
                'choices' => $this->getDoctrine()
                    ->getRepository('PierreConnaitresesaidesBundle:City')->findAllCityOrdered(),
                'choice_label' => 'name',
                'choice_value' => 'name',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Rechercher',
            ))
            ->getForm();


        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            $data = array('city' => $form->get('city')->getData()->getName(), 'page' => 1);

            return $this->redirectToRoute('PierreBonsPlansBundle_bonsplans_city', $data);

        } else {

            $bonsplans = $em->getRepository('PierreBonsPlansBundle:BonsPlan')
                ->getLatestUpdatedBonsPlans($page, $maxBonsPlan);

            //var_dump($bonsplans);
            return $this->render('PierreBonsPlansBundle:BonsPlan:index.html.twig', array(
                'bonsplans' => $bonsplans,
                'pagination' => $pagination,
                'form' => $form->createView()
            ));
        }
    }


    public function cityshowAction(Request $request, $city, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $maxBonsPlan = $this->container->getParameter('pierre_bonsplans.bonsplans.max_article');

        $countBonsPlans = $this->getDoctrine()
            ->getRepository('PierreBonsPlansBundle:BonsPlan')
            ->getCountBonsPlansCity($city);

        $pagination = array(
            'page' => $page,
            'route' => 'PierreBonsPlansBundle_bonsplans_city',
            'pages_count' => max(1, ceil($countBonsPlans / $maxBonsPlan)),
            'route_params' => array('city' => $city)
        );

        $form = $this->createFormBuilder()
            ->add('city', EntityType::class, array(
                'label' => 'Sélectionnez votre ville',
                'placeholder' => 'Choisir une ville',
                'class' => 'PierreConnaitresesaidesBundle:City',
                'choices' => $this->getDoctrine()
                    ->getRepository('PierreConnaitresesaidesBundle:City')->findAllCityOrdered(),
//                'data' => $city,
                'choice_label' => 'name',
                'choice_value' => 'name',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Rechercher',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid() && $form->isSubmitted()) {

                $data = array('city' => $form->get('city')->getData()->getName(), 'page' => 1);

                return $this->redirectToRoute('PierreBonsPlansBundle_bonsplans_city', $data);
            }
        }

        $bonsplans = $em->getRepository('PierreBonsPlansBundle:BonsPlan')
            ->getLatestUpdatedBonsPlansCity($page, $maxBonsPlan, $city);

        return $this->render('PierreBonsPlansBundle:BonsPlan:cityshow.html.twig', array(
            'city' => $city,
            'page' => $page,
            'bonsplans' => $bonsplans,
            'pagination' => $pagination,
            'form' => $form->createView(),
            'countbonsplans' => $countBonsPlans,
        ));


    }

    public function showAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $bonsplan = $em->getRepository('PierreBonsPlansBundle:BonsPlan')->getBonPlanBySlug($slug);

        $bonsplanAd = $em->getRepository('PierreBonsPlansBundle:BonsPlan')->getRandomBonPlanSameCategory($bonsplan['id'], $bonsplan['category']);

        $bonsplancomments = $em->getRepository('PierreBonsPlansBundle:BonsPlanComment')
            ->getCommentsForBonsPlan($bonsplan['id']);

        return $this->render('PierreBonsPlansBundle:BonsPlan:show.html.twig', array(
            'bonsplan' => $bonsplan,
            'bonsplanAd' => $bonsplanAd,
            'comments' => $bonsplancomments,
            'request' => $request
        ));
    }

    public function sidebarAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $commentLimit = $this->container
            ->getParameter('pierre_bonsplans.comments.latest_comment_limit');
        $latestComments = $em->getRepository('PierreBonsPlansBundle:BonsPlanComment')
            ->getLatestComments($commentLimit);

        $form = $this->createFormBuilder()
            ->add('user', TextType::class, array(
                'label' => 'Nom *',
                'attr' => array(
                    'placeholder' => 'Prénom',
                    'class' => 'form-control'
                )
            ))
            ->add('mail', EmailType::class, array(
                'label' => 'Mail * ',
                'attr' => array(
                    'placeholder' => 'Mail',
                    'class' => 'form-control'
                )
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Je veux des news :)',
            ))
            ->getForm();

        return $this->render('PierreBonsPlansBundle:BonsPlan:sidebar.html.twig', array(
            'latestComments' => $latestComments,
            'form' => $form->createView()
        ));
    }
}
