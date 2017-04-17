<?php

namespace Pierre\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BlogController extends Controller
{

    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $maxArticles = $this->container->getParameter('pierre_blog.blog.max_article');
        $countArticles = $this->getDoctrine()
            ->getRepository('PierreBlogBundle:Blog')
            ->getCountBlogs();

        $pagination = array(
            'page' => $page,
            'route' => 'PierreBlogBundle_homepage',
//            'pages_count' => ceil($countArticles / $maxArticles),
            'pages_count' => 8,
            'route_params' => array()
        );

        $blogs = $em->getRepository('PierreBlogBundle:Blog')
            ->getLatestUpdatedBlogs($page, $maxArticles);

        return $this->render('PierreBlogBundle:Blog:index.html.twig', array(
            'blogs' => $blogs,
            'pagination' => $pagination
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

    public function sidebarAction(Request $request)
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

        return $this->render('PierreBlogBundle:Blog:sidebar.html.twig', array(
            'latestComments' => $latestComments,
            'form' => $form->createView(),
            'tags' => $tagWeights
        ));
    }

}
