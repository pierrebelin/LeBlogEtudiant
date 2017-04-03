<?php

namespace Pierre\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pierre\BlogBundle\Entity\Enquiry;
use Pierre\BlogBundle\Form\EnquiryType;

class BlogController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $blogs = $em->getRepository('PierreBlogBundle:Blog')
            ->getLatestBlogs();

        return $this->render('PierreBlogBundle:Blog:index.html.twig', array(
            'blogs' => $blogs
        ));
    }

    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from symblog')
                    ->setFrom('pbelin.pierre@gmail.com')
                    ->setTo($this->container->getParameter('pierre_blog.emails.contact_email'))
                    ->setBody($this->renderView('PierreBlogBundle:Blog:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                $this->get('mailer')->send($message);

                //$this->get('session')->setFlash('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('PierreBlogBundle_contact'));
            }
        }

        return $this->render('PierreBlogBundle:Blog:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function showAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('PierreBlogBundle:Blog')->findOneBy(array('slug' => $slug));

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        $comments = $em->getRepository('PierreBlogBundle:Comment')
            ->getCommentsForBlog($blog->getId());

        return $this->render('PierreBlogBundle:Blog:show.html.twig', array(
            'blog' => $blog,
            'comments' => $comments,
            'request' => $request
        ));
    }

    public function sidebarAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $tags = $em->getRepository('PierreBlogBundle:Blog')
            ->getTags();

        $tagWeights = $em->getRepository('PierreBlogBundle:Blog')
            ->getTagWeights($tags);

        $commentLimit = $this->container
            ->getParameter('pierre_blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository('PierreBlogBundle:Comment')
            ->getLatestComments($commentLimit);

        return $this->render('PierreBlogBundle:Blog:sidebar.html.twig', array(
            'latestComments' => $latestComments,
            'tags' => $tagWeights
        ));
    }

}
