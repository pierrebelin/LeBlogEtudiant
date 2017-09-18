<?php


namespace Pierre\BonsPlansBundle\Controller;

use Pierre\SiteBundle\Controller\SiteController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Pierre\BonsPlansBundle\Entity\BonsPlanComment;
use Pierre\BonsPlansBundle\Form\BonsPlanCommentType;

class BonsPlanController extends Controller
{
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $maxBonsPlan = $this->container->getParameter('pierre_bonsplans.bonsplans.max_article');
        $countBonsPlans = $this->getDoctrine()
            ->getRepository('PierreBonsPlansBundle:BonsPlan')
            ->getCountBonsPlans();

        $pagination = array(
            'page' => $page,
            'route' => 'PierreBonsPlansBundle_homepage',
            'pages_count' => ceil($countBonsPlans / $maxBonsPlan),
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

            if ($form->isValid() && $form->isSubmitted()) {

                $city = $form->get('city')->getData()->getName();

                $data = array('city' => $city);
                //return $this->redirectToRoute('PierreBonsPlansBundle_homepage', $data);

                //$bonsplans = $em->getRepository('PierreBonsPlansBundle:BonsPlan')
                 //   ->getLatestUpdatedBonsPlansCity($page, $maxBonsPlan, $city);

                $bonsplans = null;

                return $this->render('PierreBonsPlansBundle:BonsPlan:index.html.twig', array(
                    'city' => $city,
                    'bonsplans' => $bonsplans,
                    'pagination' => $pagination,
                    'form' => $form->createView()
                ));
            }
        } else {
            $bonsplans = $em->getRepository('PierreBonsPlansBundle:BonsPlan')
                ->getLatestUpdatedBonsPlans($page, $maxBonsPlan);

            return $this->render('PierreBonsPlansBundle:BonsPlan:index.html.twig', array(
                'bonsplans' => $bonsplans,
                'pagination' => $pagination,
                'form' => $form->createView()
            ));
        }
    }

    public function showAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $bonsplan = $em->getRepository('PierreBonsPlansBundle:BonsPlan')->findOneBy(array('slug' => $slug));

        if (!$bonsplan) {
            throw $this->createNotFoundException('Unable to find BonsPlan post.');
        }

        $bonsplancomments = $em->getRepository('PierreBonsPlansBundle:BonsPlanComment')
            ->getCommentsForBonsPlan($bonsplan->getId());

        return $this->render('PierreBonsPlansBundle:BonsPlan:show.html.twig', array(
            'bonsplan' => $bonsplan,
            'comments' => $bonsplancomments,
            'request' => $request
        ));
    }

    public function sidebarAction(Request $request)
    {
        $em = $this->getDoctrine()
            ->getManager();

        $localisation = $em->getRepository('PierreBonsPlansBundle:BonsPlan')
            ->getLocalisation();

        $tagWeights = $em->getRepository('PierreBonsPlansBundle:BonsPlan')
            ->getTagWeights($localisation);

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
                'label' => 'S\'abonner',
            ))
            ->getForm();

        return $this->render('PierreBonsPlansBundle:BonsPlan:sidebar.html.twig', array(
            'latestComments' => $latestComments,
            'form' => $form->createView(),
            'tags' => $tagWeights
        ));
    }

}
