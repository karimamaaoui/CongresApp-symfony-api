<?php
namespace App\Email;

use App\Entity\User;
use Twig\Environment;


class Mailer
{
    /**
     *@var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig\Environment
     */
    private $twig;
  /*  
    public function __construct( \Swift_Mailer $mailer ,  \Twig\Environment $twig  )

    {
        $this->mailer=$mailer;
        $this->twig =$twig;
    }

        */
    
}

?>