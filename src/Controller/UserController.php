<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName('李慕白');
        $user->setAge(100);
        $user->setGender('male');
        $user->setRoles('student');

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Save user id'.$user->getId());
    }

    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function showAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'Not User Found for id'.$id
            );
        }

        return new Response('check'.$user->getName());
    }
}
