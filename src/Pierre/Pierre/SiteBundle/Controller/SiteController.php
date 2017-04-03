<?php

namespace Pierre\SiteBundle\Controller;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function indexAction()
    {
        return $this->render('PierreSiteBundle:Site:index.html.twig');
    }

    public function aproposAction()
    {
        return $this->render('PierreSiteBundle:Site:apropos.html.twig');
    }

    public function contactAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('user', TextType::class, array(
                'label' => 'Nom *',
            ))
            ->add('mail', EmailType::class, array(
                'label' => 'Mail * ',
            ))
            ->add('subject', ChoiceType::class, array(
                'label' => 'Sujet *',
                'placeholder' => 'Choisissez le sujet',
                'choices' => array(
                    'Avoir des informations supplémentaires' => 'Avoir des informations supplémentaires'
                ),
            ))
            ->add('body', TextareaType::class, array(
                'label' => 'Message *'
            ))
            ->add('subscribe', CheckboxType::class, array(
                'label' => 'Je souhaite être tenu au courant des actualités qui me concernent',
                'required' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Envoyer',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid() && $form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();

                $sendinblue = $this->get('sendinblue_api');
                $data_mail= array("to" => array($this->getParameter('sendinblue_contact')=>"to whom!"),
                    "from" => array($form->get('mail')->getData(),"from email!"),
                    "subject" => "[CONTACT] - " . $form->get('subject')->getData(),
                    "text" => $form->get('body')->getData(),
                );

                var_dump($data_mail);

                $sendinblue->send_email($data_mail);

                if ($sendinblue->send_email($data_mail)['code'] == 'success') {
                    $this->addFlash(
                        'success',
                        'Votre mail a été envoyé, nous répondrons dès que possible. Merci à vous !'
                    );

                    $data_mailist = array("email" => $form->get('mail')->getData(),
                        "attributes" => array("NAME" => $form->get('user')->getData()),
                        "listid" => array(7)
                    );
                    $sendinblue->create_update_user($data_mailist);

                } else {
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue, est-il possible de nous le préciser par mail ? Nous ferons le nécessaire pour réparer cela au plus vite. Nous nous excusons du dérangement !'
                    );
                }
                //return $this->redirect($request->getUri());
            }
        } else {
            return $this->render('PierreSiteBundle:Site:contact.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }
}
