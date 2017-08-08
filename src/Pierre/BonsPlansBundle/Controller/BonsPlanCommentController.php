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

/**
 * Comment controller.
 */
class BonsPlanCommentController extends Controller
{

    public function newAction(Request $request, $bonsplan_id)
    {
        $bonsplan = $this->getBonsPlan($bonsplan_id);

        $bonsplanscomment = new BonsPlanComment();
        $bonsplanscomment->setBonsPlan($bonsplan);

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('PierreBonsPlansBundle_bonsplan_show', array('slug' => $bonsplanscomment->getBonsPlan()->getSlug())))
            ->setMethod('POST')
            ->add('user', TextType::class, array(
                'label' => 'Prénom *',
            ))
            ->add('mail', EmailType::class, array(
                'label' => 'Mail * ',
            ))
            ->add('comment', TextareaType::class, array(
                'label' => 'Commentaire *'
            ))
            ->add('subscribe', CheckboxType::class, array(
                'label' => 'Je souhaite être tenu au courant des bons plans',
                'required' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Commenter',
            ))
            ->getForm();


        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid() && $form->isSubmitted()) {

                // Save the comment
                $bonsplanscomment->setMail($form->get('mail')->getData());
                $bonsplanscomment->setComment($form->get('comment')->getData());
                $bonsplanscomment->setUser($form->get('user')->getData());

                $captcha = $_POST['g-recaptcha-response'];

                $controllerSite = new SiteController();

                if($controllerSite->isCaptchaValid($captcha)) {
                    $em = $this->getDoctrine()->getManager();

                    // Add mail in sendinblue
                    $sendinblue = $this->get('sendinblue_api');

                    $mailer = $this->container->get('sendinblue');

                    $resMailer = $mailer->postComment($sendinblue, $form->get('mail')->getData(), $form->get('user')->getData(), $form->get('subscribe')->getData());

                    if ($resMailer == 'success') {
                        $em->persist($bonsplanscomment);
                        $em->flush();
                        $this->addFlash(
                            'success',
                            'Votre commentaire a bien été ajouté ! Merci pour votre intérêt à cet article :)'
                        );

                    } else {
                        $this->addFlash(
                            'danger',
                            'Une erreur est survenue, est-il possible de nous le préciser par mail ? Je ferai le nécessaire pour réparer cela au plus vite. Je suis désolé du dérangement'
                        );
                    }

                    unset($form);

                    header("location: " . $request->getUri());
                    exit();
                } else {

                }
            }
        }

        return $this->render('PierreBonsPlansBundle:BonsPlanComment:form.html.twig', array(
            'bonsplanscomment' => $bonsplanscomment,
            'form' => $form->createView()
        ));
    }

    protected function getBonsPlan($bonsplans_id)
    {
        $em = $this->getDoctrine()->getManager();

        $bonsplans = $em->getRepository('PierreBonsPlansBundle:BonsPlan')->find($bonsplans_id);

        if (!$bonsplans) {
            throw $this->createNotFoundException('Unable to find Bons Plans post.');
        }

        return $bonsplans;
    }



}
