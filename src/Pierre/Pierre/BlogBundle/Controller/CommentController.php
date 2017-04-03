<?php

namespace Pierre\BlogBundle\Controller;

use Pierre\SiteBundle\Entity\MailList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Pierre\BlogBundle\Entity\Comment;
use Pierre\BlogBundle\Form\CommentType;

/**
 * Comment controller.
 */
class CommentController extends Controller
{

    public function newAction(Request $request, $blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment = new Comment();
        $comment->setBlog($blog);

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('PierreBlogBundle_blog_show', array('slug' => $comment->getBlog()->getSlug())))
            ->setMethod('POST')
            ->add('user', TextType::class, array(
                'label' => 'Nom *',
            ))
            ->add('mail', EmailType::class, array(
                'label' => 'Mail * ',
            ))
            ->add('comment', TextareaType::class, array(
                'label' => 'Commentaire *'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Commenter',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid() && $form->isSubmitted()) {

                // Save the comment
                $comment->setMail($form->get('mail')->getData());
                $comment->setComment($form->get('comment')->getData());
                $comment->setUser($form->get('user')->getData());

                $em = $this->getDoctrine()->getManager();

                // Add mail in sendinblue
                $sendinblue = $this->get('sendinblue_api');
                $data = array("email" => $comment->getMail(),
                    "attributes" => array("NAME" => $comment->getUser()),
                    "listid" => array(7)
                );

                if ($sendinblue->create_update_user($data)['code'] == 'success') {
                    $this->addFlash(
                        'success',
                        'Votre commentaire a été ajouté, merci à vous !'
                    );
                    $em->persist($comment);
                    $em->flush();
                } else {
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue, est-il possible de nous le préciser par mail ? Nous ferons le nécessaire pour réparer cela au plus vite. Nous nous excusons du dérangement !'
                    );
                }

                unset($form);

                $form = $this->createFormBuilder()
                    ->setAction($this->generateUrl('PierreBlogBundle_blog_show', array('slug' => $comment->getBlog()->getSlug())))
                    ->setMethod('POST')
                    ->add('user', TextType::class, array(
                        'label' => 'Nom *',
                    ))
                    ->add('mail', EmailType::class, array(
                        'label' => 'Mail * ',
                    ))
                    ->add('comment', TextareaType::class, array(
                        'label' => 'Commentaire *'
                    ))
                    ->add('submit', SubmitType::class, array(
                        'label' => 'Commenter',
                    ))
                    ->getForm();

                header("location: " . $request->getUri());
                exit();
            }
        }

        return $this->render('PierreBlogBundle:Comment:form.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView()
        ));
    }

    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('PierreBlogBundle:Blog')->find($blog_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }

}
