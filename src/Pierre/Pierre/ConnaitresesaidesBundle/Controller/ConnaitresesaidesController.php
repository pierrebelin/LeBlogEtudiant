<?php

namespace Pierre\ConnaitresesaidesBundle\Controller;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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


    public function connaitresesaidesAction(Request $request)
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

                return $this->redirectToRoute('PierreConnaitresesaidesBundle_connaitresesaides_resultats', $data);
            }
        } else {
            return $this->render('PierreConnaitresesaidesBundle:Connaitresesaides:aidesetudiants.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    public function resultatsAction(Request $request)
    {
        // On a donc accès au conteneur :
        //$mailer = $this->container->get('mailer');
        // On peut envoyer des e-mails, etc.
        // Récupération des paramètres
        /* Pour savoir si la page a été récupérée via GET (clic sur un lien - query) ou via POST (envoi d'un formulaire - request), il existe la méthode$request->isMethod() : */
        $statut = $request->query->get('statut');
        $city = $request->query->get('city');
        $age = $request->query->get('age');
        $salary = $request->query->get('salary');

        $em = $this->getDoctrine()->getManager();

        $aidCountries = $em->getRepository('PierreConnaitresesaidesBundle:Aid')->findPossibleAidCountries($statut, $city, $age, $salary);
        $aidRegions = $em->getRepository('PierreConnaitresesaidesBundle:Aid')->findPossibleAidRegions($statut, $city, $age, $salary);
        $aidDepartments = $em->getRepository('PierreConnaitresesaidesBundle:Aid')->findPossibleAidDepartments($statut, $city, $age, $salary);
        $aidCities = $em->getRepository('PierreConnaitresesaidesBundle:Aid')->findPossibleAidCities($statut, $city, $age, $salary);

        $aidAll = array();

        if (count($aidCountries) > 0) {
            array_push($aidAll, $aidCountries);
        }
        if (count($aidRegions) > 0) {
            array_push($aidAll, $aidRegions);
        }
        if (count($aidDepartments) > 0) {
            array_push($aidAll, $aidDepartments);
        }
        if (count($aidCities) > 0) {
            array_push($aidAll, $aidCities);
        }

        $advantageCountries = $em->getRepository('PierreConnaitresesaidesBundle:Advantage')->findPossibleAdvantageCountries($statut, $city, $age, $salary);
        $advantageRegions = $em->getRepository('PierreConnaitresesaidesBundle:Advantage')->findPossibleAdvantageRegions($statut, $city, $age, $salary);
        $advantageDepartments = $em->getRepository('PierreConnaitresesaidesBundle:Advantage')->findPossibleAdvantageDepartments($statut, $city, $age, $salary);
        $advantageCities = $em->getRepository('PierreConnaitresesaidesBundle:Advantage')->findPossibleAdvantageCities($statut, $city, $age, $salary);

        $advantageAll = array();

        if (count($advantageCountries) > 0) {
            array_push($advantageAll, $advantageCountries);
        }
        if (count($advantageRegions) > 0) {
            array_push($advantageAll, $advantageRegions);
        }
        if (count($advantageDepartments) > 0) {
            array_push($advantageAll, $advantageDepartments);
        }
        if (count($advantageCities) > 0) {
            array_push($advantageAll, $advantageCities);
        }

        $offerAll = array();


        $form = $this->createFormBuilder()
            ->add('firstname', TextType::class, array(
                'label' => 'Prenom*',
            ))
            ->add('mailaddress', EmailType::class, array(
                'label' => 'Adresse mail*',
            ))
            ->add('issendvalidated', CheckboxType::class, array(
                'label' => 'Je souhaite être tenu au courant des actualités qui me concernent',
                'required' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Recevoir mes résultats',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $smtp_host_ip = gethostbyname('smtp.gmail.com');
            $transport = \Swift_SmtpTransport::newInstance($smtp_host_ip, 465, 'ssl')
                ->setUsername('pbelin.pierre@gmail.com')
                ->setSourceIp('0.0.0.0')
                ->setPassword('destunk01');

            /* $transport = \Swift_MailTransport::newInstance(); */

            $swift = \Swift_Mailer::newInstance($transport);

            $content = "This is a test :)";
            $message = \Swift_Message::newInstance("MAIL :D")
                ->setFrom(array('pierre.belin@hotmail.fr' => 'From'))
                ->setTo(array('pierre.belin@hotmail.fr' => 'To'))
                ->setBody($content, 'text/html')
                ->addPart(strip_tags($content), 'text/plain');

            $swift->send($message);

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
}
