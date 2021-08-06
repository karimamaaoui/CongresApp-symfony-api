<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Users;
use App\Repository\UserRepository;
use Exception;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RegisterController extends AbstractController
{   
    

    public function __construct(UserRepository $userRepository)
    {
            $this->userRepository=$userRepository;
    }

    /**
     * @Route("/api/register", name="app_register",methods={"GET", "POST"})
     * 
     */
    public function add(\Swift_Mailer $mailer, Request $request,UserPasswordEncoderInterface $passwordEncoder): JsonResponse
    {   
          
           $user= new User();
           $data=json_decode($request->getContent(),true);

           $user->setPassword(
               $passwordEncoder->encodePassword(
                   $user,
                   $data["password"]
               )
           );
           $user->setFirstName($data['firstName']);
           $user->setLastName($data['lastName']);
           $user->setEmail($data['email']);
           $user->setCreatedAt(new \DateTime());
           $user->setUpdatedAt(new \DateTime());
           $entityManager =$this->getDoctrine()->getManager();
           $entityManager->persist($user);
           $entityManager->flush();
           
           $email = (new Swift_Message("HELLO FROM CONGRESSES APPLICATION"))

           ->setFrom ("securesally@gmail.com")
                ->setTo($user->getEmail())
                //->subject ("Please confirm your email")
                //->text("welcome") 
                //->html('<p>My HTML content</p>');
                ->setSubject("Please confirm your email")
               // ->setBody("click here");
               ->setBody(
                   $this->renderView('confirm.html.twig',
                    ['name'=>$user->getFirstName(),
                    'link'=>"http://localhost:3000/login"
                    ]));

                $mailer->send($email);
                if (!$mailer)
                {
                    $user->setIsVerified=0;
                }
                else {
                    $user->setIsVerified=1;

                }

           $response = new JsonResponse(['status' => $user->getFirstName().' ' .$user->getLastName().' ' .$user->getEmail(). ' '. $user->getId()], 201);
           $response->headers->set('Content-Type', 'application/json');
           $response->headers->set('Access-Control-Allow-Origin', '*');
         //  $this->redirectToRoute('api_login_check');
           return $response;

    }

    /**
     * @Route("/api/admin/register", name="app_register_admin",methods={"GET", "POST"})
     * 
     */
    public function addAdmin(\Swift_Mailer $mailer, Request $request,UserPasswordEncoderInterface $passwordEncoder): JsonResponse
    {   
          
           $user= new User();
           $data=json_decode($request->getContent(),true);

           $user->setPassword(
               $passwordEncoder->encodePassword(
                   $user,
                   $data["password"]
               )
           );
           $user->setFirstName($data['firstName']);
           $user->setLastName($data['lastName']);
           $user->setEmail($data['email']);
           $user->setCreatedAt(new \DateTime());
           $user->setUpdatedAt(new \DateTime());
           $user->setRoles(['ROLE_ADMIN']);
           $entityManager =$this->getDoctrine()->getManager();
           $entityManager->persist($user);
           $entityManager->flush();
           
        /*   $email = (new Swift_Message("HELLO FROM CONGRESSES APPLICATION"))

           ->setFrom ("securesally@gmail.com")
                ->setTo($user->getEmail())
                //->subject ("Please confirm your email")
                //->text("welcome") 
                //->html('<p>My HTML content</p>');
                ->setSubject("Please confirm your email")
               // ->setBody("click here");
               ->setBody(
                   $this->renderView('confirm.html.twig',
                    ['name'=>$user->getFirstName(),
                    'link'=>"http://localhost:3000/login"
                    ]));*/

           //     $mailer->send($email);
           /*     if (!$mailer)
                {
                    $user->setIsVerified=0;
                }
                else {
                    $user->setIsVerified=1;

                }
*/
           $response = new JsonResponse(['status' => $user->getFirstName().' ' .$user->getLastName().' ' .$user->getEmail(). ' '. $user->getId()], 201);
           $response->headers->set('Content-Type', 'application/json');
           $response->headers->set('Access-Control-Allow-Origin', '*');
         //  $this->redirectToRoute('api_login_check');
           return $response;

    }


    /**
     * @Route ("/userData/{id}",name="user_show",methods="GET")
     */

  /*  public function loadUserByEmail ($id):JsonResponse
    {  
        $user= $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($id);
        if(!$user)
        {
            throw $this->createNotFoundException('No user found for email ' .$id);
        }            

        $response = new JsonResponse('check out this user ' .$user->getFirstName().' ' .$user->getLastName().' ' .$user->getEmail().' '.$user->getId());
        return $response;

    }
    */

    
    /**
     * @Route ("/user/edit/{id}",name="user_edit",methods={"GET", "POST","PUT"})
     */


   /* public function editUser ($id,Request $request,UserPasswordEncoderInterface $passwordEncoder):JsonResponse
    {

        $entityManager = $this->getDoctrine()
                                ->getManager();
        $user = $entityManager->getRepository(User::class)
                                ->find($id);
        $data=json_decode($request->getContent(),true);

                        
        if(!$user)
        {
            throw $this->createNotFoundException('No user found for id ' .$id);
        }            
        empty($data['password'])?true:$user->setPassword($passwordEncoder->encodePassword($user,$data["password"]));
       
        empty($data['firstName'])?true: $user->setFirstName($data['firstName']);
        empty($data['lastName'])?true: $user->setLastName($data['lastName']);
        
        $entityManager->persist($user);
        $entityManager->flush();
        $response = new JsonResponse(['status' => $user->getFirstName().' ' .$user->getLastName().' ' .$user->getEmail(). ' '. $user->getPassword()], 201 );
        return $response;


    }*/

    
     /**
      * @Route("/logout", name="app_logout",methods= "GET")
     */
       
     public function logout ()
     {
         throw new Exception('should not be reached');
     }

}

