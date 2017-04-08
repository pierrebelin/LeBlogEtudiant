<?php

namespace Pierre\SiteBundle\Controller;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Doctrine\ORM\EntityRepository;

class SiteController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('user', TextType::class, array(
                'label' => 'Nom *',
            ))
            ->add('mail', EmailType::class, array(
                'label' => 'Mail * ',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'S\'abonner',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid() && $form->isSubmitted()) {
                $sendinblue = $this->get('sendinblue_api');

                $mailer = $this->container->get('sendinblue');

                $resMailer = $mailer->subscribeToNewsletter($sendinblue, $form->get('mail')->getData(), $form->get('user')->getData());
                echo "            <script>
                $(window).load(function(){
                    $('#subscribeModal').modal('show');
                });
            </script>";

                if ($resMailer == 'success') {


                    $this->addFlash(
                        'success',
                        'Votre mail a été envoyé, nous répondrons dès que possible. Merci à vous !'
                    );
                } else {
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue, est-il possible de nous le préciser par mail ? Nous ferons le nécessaire pour réparer cela au plus vite. Nous nous excusons du dérangement !'
                    );
                }
            }

            header("location: " . $request->getUri());
            exit();
        }

        return $this->render('PierreSiteBundle:Site:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function aproposAction()
    {
        return $this->render('PierreSiteBundle:Site:apropos.html.twig');
    }

    public function mentionslegalesAction()
    {
        return $this->render('PierreSiteBundle:Site:mentionslegales.html.twig');
    }

    public function cguAction()
    {
        return $this->render('PierreSiteBundle:Site:cgu.html.twig');
    }

    public function errorAction()
    {
        return $this->render('PierreSiteBundle:Site:error.html.twig');
    }

    public function footerAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('PierreSiteBundle_newsletter'))
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

        return $this->render('PierreSiteBundle:Site:footer.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function contactAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('user', TextType::class, array(
                'label' => 'Prénom *',
            ))
            ->add('mail', EmailType::class, array(
                'label' => 'Mail * ',
            ))
            ->add('subject', ChoiceType::class, array(
                'label' => 'Sujet *',
                'placeholder' => 'Choisissez le sujet',
                'choices' => array(
                    'Avoir des informations supplémentaires' => 'Avoir des informations supplémentaires',
                    'Reporter une information incomplète ou invalide' => 'Reporter une information incomplète ou invalide',
                    'Proposer une idée d\'article' => 'Proposer son idée d\'article',
                    'Autre sujet (à définir dans le message)' => 'Autre sujet'
                ),
            ))
            ->add('body', TextareaType::class, array(
                'label' => 'Message *'
            ))
            ->add('subscribe', CheckboxType::class, array(
                'label' => 'Je souhaite être tenu au courant des bons plans',
                'required' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Envoyer',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid() && $form->isSubmitted()) {

                $sendinblue = $this->get('sendinblue_api');

                $mailer = $this->container->get('sendinblue');

                $resMailer = $mailer->sendMailToMe($sendinblue, $form->get('mail')->getData(), $form->get('user')->getData(), $form->get('subject')->getData(), $form->get('body')->getData(), $form->get('subscribe')->getData());

                if ($resMailer == 'success') {
                    $this->addFlash(
                        'success',
                        'Votre mail a bien été envoyé ! <br> Je vous remercie d\'avance pour votre message :)'
                    );
                } else {
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue, est-il possible de nous le préciser par mail ? <br> Je ferai le nécessaire pour réparer cela au plus vite. Je suis désolé du dérangement'
                    );
                }
                return $this->redirect($request->getUri());
            }
        } else {
            return $this->render('PierreSiteBundle:Site:contact.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }


    public function newsletterAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $sendinblue = $this->get('sendinblue_api');

            $mailer = $this->container->get('sendinblue');

            header('Content-Type: application/json');
            $response_array['status'] = $mailer->subscribeToNewsletter($sendinblue, $request->get('mail'), $request->get('user'));
            echo $response_array['status'];

            return new Response();
        } else {
            return $this->footerAction();
        }
    }

    public
    function isCaptchaValid($code, $ip = null)
    {
        if (empty($code)) {
            return false; // Si aucun code n'est entré, on ne cherche pas plus loin
        }
        $params = [
            'secret' => '6LcO2RcUAAAAANbfmsIBFfGf8UP4_9z21z_d6Qr3',
            'response' => $code
        ];
        if ($ip) {
            $params['remoteip'] = $ip;
        }
        $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Evite les problèmes, si le ser
            $response = curl_exec($curl);
        } else {
            // Si curl n'est pas dispo, un bon vieux file_get_contents
            $response = file_get_contents($url);
        }

        if (empty($response) || is_null($response)) {
            return false;
        }

        $json = json_decode($response);
        return $json->success;
    }
}
