<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EditProfileType;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
* @Route("/profil")
*/
class UsersController extends AbstractController
{
    /**
    * @Route ("/" , name="profil")
    */
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'current_menu' => 'profil' 
            ]
        );
    }

    /**
     * @Route("/liste", name="profil_liste", methods={"GET"})
     */
    public function liste(UsersRepository $usersRepository): Response
    {
        return $this->render('users/liste.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="profil_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Users $users): Response
    {
        if ($this->isCsrfTokenValid('delete'.$users->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($users);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profil_liste');
    }
    
    /**
    * @Route ("/edit" , name="profil_edit")
    */
    public function edit(Request $request)
    {
        $user= $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès.');
            return $this->redirectToRoute('profil');
        }

        return $this->render('users/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route ("/editPassword" , name="password_edit")
    */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $old_pwd = $request->get('old_password'); 
            $new_pwd = $request->get('new_password'); 
            $new_pwd_confirm = $request->get('new_password_confirm');
            $user = $this->getUser();
            $checkPass = $passwordEncoder->isPasswordValid($user, $old_pwd);
            if($checkPass === true) {
                if($new_pwd == $new_pwd_confirm){
                    $new_pwd_encoded = $passwordEncoder->encodePassword($user, $new_pwd_confirm); 
                    $user->setPassword($new_pwd_encoded);
                    $em->flush();
                    $this->addFlash('success', 'Mot de passe mis à jour');

                    return $this->redirectToRoute('profil');
                }
                else $this->addFlash('warning', 'Les deux mots de passe sont différents');
            } 
            else {
                $this->addFlash('danger', 'Ancien mot de passe incorrect');
            }
        }
        return $this->render('users/editPassword.html.twig');
    }
}
