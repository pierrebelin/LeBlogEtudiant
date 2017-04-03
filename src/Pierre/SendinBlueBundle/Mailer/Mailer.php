<?php

namespace Pierre\SendinBlueBundle\Mailer;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Created by PhpStorm.
 * User: Pierre BELIN
 * Date: 25/02/2017
 * Time: 12:08
 */
class Mailer extends Controller
{
    //protected $sendinblue;
    protected $mailcontact;
    protected $nameContact = "Le Blog Etudiant";

    public function __construct($sendinblue_contact)
    {
        $this->mailcontact = $sendinblue_contact;
    }

    public function sendMailToMe($sendinblue, $mail, $user, $subject, $body, $subscribe)
    {
        $data = array( "id" => 11, "to" => $mail);

        $data_mail = array("to" => array($this->mailcontact => $this->nameContact),
            "from" => array($mail, $user),
            "subject" => "[CONTACT] - " . $subject,
            "text" => $body,
        );

        if ($sendinblue->send_email($data_mail)['code'] == 'success') {
            $this->addToMailist($sendinblue, $mail, $user, $subscribe);
            $sendinblue->send_transactional_template($data);
            return "success";
        } else {
            return "fail";
        }
    }

    public function postComment($sendinblue, $mail, $user, $subscribe)
    {
        $data = array( "id" => 12, "to" => $mail);

        if ($this->addToMailist($sendinblue, $mail, $user, $subscribe) == 'success') {
            $sendinblue->send_transactional_template($data);
            return "success";
        } else {
            return "fail";
        }
    }

    public function contactMail ($sendinblue, $mail, $user, $subscribe)
    {
        $data = array( "id" => 12, "to" => $mail);

        if ($this->addToMailist($sendinblue, $mail, $user, $subscribe) == 'success') {
            $sendinblue->send_transactional_template($data);
            return "success";
        } else {
            return "fail";
        }
    }


    public function subscribeToNewsletter ($sendinblue, $mail, $user)
    {
        $data = array( "id" => 7, "to" => $mail);

        if ($this->addToMailist($sendinblue, $mail, $user, true) == 'success') {
            $sendinblue->send_transactional_template($data);
            return "success";
        } else {
            return "fail";
        }
    }


    public function addToMailist($sendinblue, $mail, $user, $subscribe)
    {
        //$data = array('email' => $mail);
        //$alreadyExist = $sendinblue->get_user($data);
        // TODO S'il est déjà dans la newsletter, ne pas l'enlever

        if ($subscribe == 1) {
            $data_mailist = array("email" => $mail,
                'blacklisted' => 0,
                "attributes" => array("PRENOM" => $user),
                "listid" => array(6),
            );
        } else {
            $data_mailist = array("email" => $mail,
                'blacklisted' => 0,
                "attributes" => array("PRENOM" => $user),
                "listid" => array(14),
            );
        }
        return($sendinblue->create_update_user($data_mailist)['code']);
    }
}