<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Users;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;

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
    public function add(Request $request,UserPasswordEncoderInterface $passwordEncoder): JsonResponse
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
        
           $entityManager =$this->getDoctrine()->getManager();
           $entityManager->persist($user);
           $entityManager->flush();
           $response = new JsonResponse(['status' => $user->getFirstName().' ' .$user->getLastName().' ' .$user->getEmail(). ' '. $user->getId()], 201);
           $response->headers->set('Content-Type', 'application/json');
           $response->headers->set('Access-Control-Allow-Origin', '*');
           return $response;

    }

    /**
     * @Route ("/userData/{id}",name="user_show",methods="GET")
     */

    public function loadUserByEmail ($id):JsonResponse
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
    

    
    /**
     * @Route ("/user/edit/{id}",name="user_edit",methods={"GET", "POST","PUT"})
     */


    public function editUser ($id,Request $request,UserPasswordEncoderInterface $passwordEncoder):JsonResponse
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


    }

    
     /**
      * @Route("/logout", name="app_logout",methods= "GET")
     */
       
     public function logout ()
     {
         throw new Exception('should not be reached');
     }

}

