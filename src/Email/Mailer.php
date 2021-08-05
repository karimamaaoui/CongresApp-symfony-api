<?php
namespace App\Email;


class Mailer
{
    /**
     *@var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;
    
    public function __construct( \Swift_Mailer $mailer 
            )

    {
        $this->mailer=$mailer;
     //   $this->twig =$twig;
    }
}

?>