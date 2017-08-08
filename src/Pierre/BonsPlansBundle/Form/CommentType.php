<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pierre\BonsPlansBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;



class BonsPlanCommentType extends AbstractType
{

    public function getName()
    {
        return 'pierre_bonsplansbundle_bonsplancommenttype';
    }

}
