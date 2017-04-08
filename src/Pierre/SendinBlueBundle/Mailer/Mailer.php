<?php

namespace Pierre\SendinBlueBundle\Mailer;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\C;

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
    protected $columnFirstName = 'PRENOM';

    // ID LISTS SENDINBLUE
    protected $idlistnewsletter = 6;
    protected $idlistcontact = 14;
    protected $idlistparnetaire = 10;

    // ID TEMPLATE MAIL SENDINBLUE


    public function __construct($sendinblue_contact)
    {
        $this->mailcontact = $sendinblue_contact;
    }

    public function sendMailToMe($sendinblue, $mail, $user, $subject, $body, $subscribe)
    {
        $data = array("id" => 11, "to" => $mail);

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
        $data = array("id" => 12, "to" => $mail);

        if ($this->addToMailist($sendinblue, $mail, $user, $subscribe) == 'success') {
            $sendinblue->send_transactional_template($data);
            return "success";
        } else {
            return "fail";
        }
    }

    public function contactMail($sendinblue, $mail, $user, $subscribe)
    {
        $data = array("id" => 12, "to" => $mail);

        if ($this->addToMailist($sendinblue, $mail, $user, $subscribe) == 'success') {
            $sendinblue->send_transactional_template($data);
            return "success";
        } else {
            return "fail";
        }
    }

    // Add to newsletter list the user
    public function subscribeToNewsletter($sendinblue, $mail, $user)
    {
        $data = array("id" => 7, "to" => $mail);
        $idlist = $this->idlistnewsletter;


        if ($this->isUserExists($sendinblue, $mail)['code'] == 'success') {
            // SI IL EST DANS LA LISTE -> WARNING
            if ($this->isUserInList($sendinblue, $mail, $idlist)) {
                return 'warning';
            } else {
                if ($this->addToMailist($sendinblue, $mail, $idlist)['code'] == 'success') {
                    return 'success';
                } else {
                    return 'error';
                }
            }
        } else {
            if ($this->createUser($sendinblue, $mail, $user, $idlist)['code'] == 'success') {
                $sendinblue->send_transactional_template($data);
                return 'success';
            } else {
                return 'error';
            }
        }
    }


    public function createUser($sendinblue, $mail, $user, $islist)
    {
        $data = array("email" => $mail,
            "attributes" => array($this->columnFirstName => $user),
            "listid" => array($islist)
        );
        return $sendinblue->create_update_user($data);
    }


    public function addToMailist($sendinblue, $mail, $idlist)
    {
        // UNBLACKLIST THE USER
        $data_mailist = array("email" => $mail,
            'blacklisted' => 0,
        );
        $sendinblue->create_update_user($data_mailist);


        $data = array("id" => $idlist,
            "users" => array($mail)
        );
        return ($sendinblue->add_users_list($data)['code']);
    }

    // Return success if exists and error if not
    public function isUserExists($sendinblue, $mail)
    {
        $data = array("email" => $mail);
        return $sendinblue->get_user($data);
    }

    public function isUserInList($sendinblue, $mail, $idlist)
    {
        $data = array("email" => $mail);
        $arrayID = $sendinblue->get_user($data)['data']['listid'];
        return in_array($idlist, $arrayID);
    }
}