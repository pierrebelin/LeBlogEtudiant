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

class SiteController extends Controller
{
    public function indexAction()
    {
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
                'label' => 'J\'en profite maintenant',
            ))
            ->getForm();

        $em = $this->getDoctrine()->getManager();
        $mainNews = $em->getRepository('PierreSiteBundle:MainNews')->getMainNews();

        return $this->render('PierreSiteBundle:Site:index.html.twig', array(
            'form' => $form->createView(),
            'mainNews' => $mainNews,
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

    public function donsAction()
    {
        return $this->render('PierreSiteBundle:Site:dons.html.twig');
    }

    public function faqAction()
    {
        return $this->render('PierreSiteBundle:Site:faq.html.twig');
    }

    public function footerAction()
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
                'label' => 'Je veux des news :)',
            ))
            ->getForm();

        return $this->render('PierreSiteBundle:Site:footer.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function modalsubscribeAction()
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

        return $this->render('PierreSiteBundle:Site:modalsubscribe.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function contactAction()
    {
        $form = $this->createFormBuilder()
            ->add('user', TextType::class, array(
                'label' => 'Prénom *',
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
            ->add('subject', ChoiceType::class, array(
                'label' => 'Sujet *',
                'placeholder' => 'Choisissez le sujet',
                'choices' => array(
                    'Avoir des informations supplémentaires' => 'Avoir des informations supplémentaires',
                    'Reporter une information incomplète ou invalide' => 'Reporter une information incomplète ou invalide',
                    'Proposer une idée d\'article' => 'Proposer son idée d\'article',
                    'Demande de partenariat' => 'Demande de partenariat',
                    'Autre sujet' => 'Autre sujet'
                ),
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('body', TextareaType::class, array(
                'label' => 'Message *',
                'attr' => array(
                    'placeholder' => 'Écrivez ce qui vous passe par la tête, même un simple "merci" me ferait énormément plaisir ! (20 caractères minimum)',
                    'class' => 'form-control vresize',
                    'minlength' => '20',
                    'maxlength' => '500'
                )
            ))
            ->add('subscribe', CheckboxType::class, array(
                'label' => 'Je souhaite être tenu au courant des bons plans',
                'required' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Envoyer',
            ))
            ->getForm();


        return $this->render('PierreSiteBundle:Site:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    // PHP from Ajax call to send mail from contact page
    public function sendcontactmailAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $sendinblue = $this->get('sendinblue_api');

            $mailer = $this->container->get('sendinblue');

            header('Content-Type: application/json');

            $response_array['status'] = $mailer->sendContactMail($sendinblue, $request->get('mail'), $request->get('user'), $request->get('subject'), $request->get('body'), $request->get('subscribe'));
            echo $response_array['status'];

            return new Response();
        } else {
            return $this->contactAction();
        }
    }

    // PHP from Ajax call to send mail from newsletter footer
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

    // Check if the Google Captcha is valid
    public function isCaptchaValid($code, $ip = null)
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
