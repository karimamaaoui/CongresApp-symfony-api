<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Users;
use App\Repository\UserRepository;
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
           $response = new JsonResponse(['status' => $user], 201);
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
}

