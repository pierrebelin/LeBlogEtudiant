<?php

namespace Pierre\ConnaitresesaidesBundle\Controller;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ConnaitresesaidesController extends Controller
{

    public function indexAction()
    {
        return $this->render('PierreConnaitresesaidesBundle:Connaitresesaides:index.html.twig');
    }


    public function aidesetudiantsAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('statut', EntityType::class, array(
                'label' => 'Statut *',
                'placeholder' => 'Choisir un statut',
                'class' => 'PierreConnaitresesaidesBundle:Statut',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'choice_value' => 'name',
                'mapped' => false
            ))
            ->add('city', EntityType::class, array(
                'label' => 'Lieu des études *',
                'placeholder' => 'Choisir une ville',
                'class' => 'PierreConnaitresesaidesBundle:City',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'choice_value' => 'name',
            ))
            ->add('age', IntegerType ::class, array(
                'label' => 'Age *',
            ))
            ->add('salary', IntegerType ::class, array(
                'label' => 'Salaire mensuel *',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Rechercher',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid() && $form->isSubmitted()) {

                $data = array('statut' => $form->get('statut')->getData()->getName(),
                    'city' => $form->get('city')->getData()->getName(),
                    'age' => $form->get('age')->getData(),
                    'salary' => $form->get('salary')->getData());

                return $this->redirectToRoute('PierreConnaitresesaidesBundle_aidesetudiants_resultats', $data);
            }
        } else {
            return $this->render('PierreConnaitresesaidesBundle:Connaitresesaides:aidesetudiants.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    public function aidesetudiantsresultatsAction(Request $request)
    {
        /* Pour savoir si la page a été récupérée via GET (clic sur un lien - query) ou via POST (envoi d'un formulaire - request), il existe la méthode$request->isMethod() : */
        $statut = $request->query->get('statut');
        $city = $request->query->get('city');
        $age = $request->query->get('age');
        $salary = $request->query->get('salary');

        $em = $this->getDoctrine()->getManager();

        // Récupération de toutes les aides
        $aidCountries = $em->getRepository('PierreConnaitresesaidesBundle:Aid')->findPossibleAidCountries($statut, $city, $age, $salary);
        $aidRegions = $em->getRepository('PierreConnaitresesaidesBundle:Aid')->findPossibleAidRegions($statut, $city, $age, $salary);
        $aidDepartments = $em->getRepository('PierreConnaitresesaidesBundle:Aid')->findPossibleAidDepartments($statut, $city, $age, $salary);
        $aidCities = $em->getRepository('PierreConnaitresesaidesBundle:Aid')->findPossibleAidCities($statut, $city, $age, $salary);

        $aidAll = array();
        // Ajout au tableau contenant toutes les aides
        if (count($aidCountries) > 0) {
            $aidAll = array_merge($aidAll, $aidCountries);
        }
        if (count($aidRegions) > 0) {
            $aidAll = array_merge($aidAll, $aidRegions);
        }
        if (count($aidDepartments) > 0) {
            $aidAll = array_merge($aidAll, $aidDepartments);
        }
        if (count($aidCities) > 0) {
            $aidAll = array_merge($aidAll, $aidCities);
        }
        sort($aidAll);

        // Récupération de tous les avantages
        $advantageCountries = $em->getRepository('PierreConnaitresesaidesBundle:Advantage')->findPossibleAdvantageCountries($statut, $city, $age, $salary);
        $advantageRegions = $em->getRepository('PierreConnaitresesaidesBundle:Advantage')->findPossibleAdvantageRegions($statut, $city, $age, $salary);
        $advantageDepartments = $em->getRepository('PierreConnaitresesaidesBundle:Advantage')->findPossibleAdvantageDepartments($statut, $city, $age, $salary);
        $advantageCities = $em->getRepository('PierreConnaitresesaidesBundle:Advantage')->findPossibleAdvantageCities($statut, $city, $age, $salary);

        $advantageAll = array();
        // Ajout au tableau contenant toutes les avantages
        if (count($advantageCountries) > 0) {
            $advantageAll = array_merge($advantageAll, $advantageCountries);
        }
        if (count($advantageRegions) > 0) {
            $advantageAll = array_merge($advantageAll, $advantageRegions);
        }
        if (count($advantageDepartments) > 0) {
            $advantageAll = array_merge($advantageAll, $advantageDepartments);
        }
        if (count($advantageCities) > 0) {
            $advantageAll = array_merge($advantageAll, $advantageCities);
        }
        sort($advantageAll);


//        $offerAll = array();


        $form = $this->createFormBuilder()
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom *',
                'attr' => array(
                    'placeholder' => 'Prénom',
                    'class' => 'form-control'
                )
            ))
            ->add('mailaddress', EmailType::class, array(
                'label' => 'Mail *',
                'attr' => array(
                    'placeholder' => 'Mail',
                    'class' => 'form-control'
                )
            ))
            ->add('issendvalidated', CheckboxType::class, array(
                'label' => 'Je souhaite être tenu au courant des bons plans',
                'required' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Recevoir mes résultats',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {


            return $this->render('PierreConnaitresesaidesBundle:Connaitresesaides:index.html.twig');
        } else {
            return $this->render('PierreConnaitresesaidesBundle:Connaitresesaides:aidesetudiantsresultats.html.twig', array(
                'statut' => $statut,
                'city' => $city,
                'age' => $age,
                'salary' => $salary,
                'aidAll' => $aidAll,
                'advantageAll' => $advantageAll,
                'offerAll' => $offerAll,
                'form' => $form->createView()
            ));
        }
    }

    public function sendresultsmailAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $sendinblue = $this->get('sendinblue_api');

            $mailer = $this->container->get('sendinblue');

            header('Content-Type: application/json');

            $response_array['status'] = $mailer->sendResultsMail($sendinblue, $request->get('mail'), $request->get('user'), $request->get('results'), $request->get('subscribe'));
            echo $response_array['status'];

            return new Response();
        } else {
            return $this->resultatsAction();
        }
    }
}
