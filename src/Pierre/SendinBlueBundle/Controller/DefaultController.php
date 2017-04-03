<?php

namespace Pierre\SendinBlueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PierreSendinBlueBundle:Default:index.html.twig');
    }
}
