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
    protected $idtemplatenewsletter = 7;
    protected $idtemplatecontact = 11;

    public function __construct($sendinblue_contact)
    {
        $this->mailcontact = $sendinblue_contact;
    }

    public function sendContactMail($sendinblue, $mail, $user, $subject, $body, $subscribe)
    {
        if ($subscribe == "true") {
            $data = array("id" => $this->idtemplatenewsletter, "to" => $mail);
            $this->addToContactList($sendinblue, $mail, $user, $data, $this->idlistnewsletter, true);
        }
        $data = array("id" => $this->idtemplatecontact, "to" => $mail);
        $this->addToContactList($sendinblue, $mail, $user, $data, $this->idlistcontact, false);

        $data_mail = array("to" => array($this->mailcontact => $this->nameContact),
            "from" => array($mail, $user),
            "subject" => "[CONTACT] - " . $subject,
            "text" => $body,
        );

        return $sendinblue->send_email($data_mail);
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

    public function sendResultsMail($sendinblue, $mail, $user, $results, $subscribe)
    {
        if ($subscribe == "true") {
            $data = array("id" => $this->idtemplatenewsletter, "to" => $mail);
            $this->addToContactList($sendinblue, $mail, $user, $data, $this->idlistnewsletter, true);
        } else {
            $data = array("id" => $this->idtemplatecontact, "to" => $mail);
            $this->addToContactList($sendinblue, $mail, $user, $data, $this->idlistcontact, false);
        }
        // Envoyer le mail contenant les informations
        $data_mail = array("to" => array($mail => $user),
            "from" => array($this->mailcontact, $this->nameContact),
            "subject" => "Résultats de votre recherche d'aides - Le Blog Étudiant",
            "html" => $this->getMailResults($results),
        );

        return $sendinblue->send_email($data_mail)['code'];
    }


    // Add to newsletter list the user
    public function subscribeToNewsletter($sendinblue, $mail, $user)
    {
        $data = array("id" => $this->idtemplatenewsletter, "to" => $mail);
        return $this->addToContactList($sendinblue, $mail, $user, $data, $this->idlistnewsletter, true);
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


    public function addToContactList($sendinblue, $mail, $user, $data, $idlist, $sendmail)
    {
        if ($this->isUserExists($sendinblue, $mail)['code'] == 'success') {
            // SI IL EST DANS LA LISTE -> WARNING
            if ($this->isUserInList($sendinblue, $mail, $idlist)) {
                return 'warning';
            } else {
                if ($this->addToUsersList($sendinblue, $mail, $idlist) == 'success') {
                    return 'success';
                } else {
                    return 'error';
                }
            }
        } else {
            if ($this->createUser($sendinblue, $mail, $user, $idlist) == 'success') {
                if ($sendmail) {
                    $sendinblue->send_transactional_template($data);
                }
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


    public function addToUsersList($sendinblue, $mail, $idlist)
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

    public function getMailResults($results)
    {
        return
            '<body style="margin:0; padding:0;"><meta content="IE=edge" http-equiv="X-UA-Compatible" />
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />' . $this->getCSSTextMailResults() . '

<p class="title">Voici vos r&eacute;sultats de votre recherche sur Le Blog &Eacute;tudiant</p>
	
			' . $results . '
			
<div class="after-table">
	<p>Vous pouvez &agrave; tout moment recommencer votre recherche en <a href="http://le-blog-etudiant.fr/identifier-ses-aides/aides-etudiants-francais" target="_blank">cliquant ici</a></p>
	<p>Pensez &agrave; partager &agrave; vos amis pour qu&#39;ils puissent aussi en profiter ☺</p>
</div>
<div class="footer">
	<h2>Le Blog Etudiant</h2>
	<p>Enfin, pour être au courant en temps réel des dernières nouvelles :</p>
    <p class="social-link"><a href="https://www.facebook.com/blogetudiant" target="_blank">Facebook</a></p>
    <p class="social-link"><a href="https://twitter.com/Le_BlogEtudiant" target="_blank">Twitter</a></p>
</div>
</body>';
    }


    public function getCSSTextMailResults()
    {
        return
            '<style type="text/css">
*{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;}
body{font-family: sans-serif; line-height: 24px;}

.tr-odd {
    background-color: #C4D7ED;
    padding-top: 15px;
    font-size: 14px;
    padding-bottom: 15px;
}

.msg-noresult {
    text-align:center;
    color:#676a6c;
}
.social-link {
    margin-bottom: 10px;
    padding-bottom: 0px;
}
tr {
    padding-top: 15px !important;
    padding-bottom: 15px !important;
}
.tr-even {
    background-color: #ECF0F1;
    padding-top: 15px !important;
    padding-bottom: 15px !important;
    font-size: 14px;
}
h3 {
    text-align: center;
    color: #2980B9;
    font-family: sans-serif;

}

a {
    text-decoration: none;
}
p {
    text-align: center;
    color:#676a6c;
    font-size: 14px;
    font-family: sans-serif;
}
.footer {
    text-align: center;
    margin-top: 40px;
}
.footer h2 {
    font-size: 18px;
    color: #375D81;
    font-family: sans-serif;
}

.title {
    margin-bottom: 50px;
}
.after-table {
    margin-top:40px;
}

    @media only screen and (max-width:640px){table[class=full]{width:100%!important;}}
    @media only screen and (max-width:479px){table[class=fullcenter]{width:100%!important;text-align:center!important;}}</style>';
    }
}