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

    /**
     * @Route("/user/edit/{id}", name="user_edit")
     */
    public function updateAction($id)
    {
        $entityManage = $this->getDoctrine()->getManager();

        $user = $entityManage->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No Use Found for id'.$id
            );
        }

        $user->setName('逍遥子');
        $entityManage->flush();

        return $this->redirectToRoute('user_show', [
            'id' => $user->getId()
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete")
     */
    public function deleteAction($id)
    {
        $entityManage = $this->getDoctrine()->getManager();
        $user = $entityManage->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No User Fount for id'.$id
            );
        }

        $entityManage->remove($user);
        $entityManage->flush();

        return $this->redirectToRoute('user_show', [
            'id' => $id
        ]);
    }
}
