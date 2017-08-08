<?php


namespace Pierre\BonsPlansBundle\Controller;

use Pierre\SiteBundle\Controller\SiteController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Pierre\BonsPlansBundle\Entity\BonsPlanComment;
use Pierre\BonsPlansBundle\Form\BonsPlanCommentType;

class BonsPlanController extends Controller
{
    public function indexAction($page)
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
//            'pages_count' => 8,
            'route_params' => array()
        );

        $bonsplans = $em->getRepository('PierreBonsPlansBundle:BonsPlan')
            ->getLatestUpdatedBonsPlans($page, $maxBonsPlan);

        return $this->render('PierreBonsPlansBundle:BonsPlan:index.html.twig', array(
            'bonsplans' => $bonsplans,
            'pagination' => $pagination
        ));
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
