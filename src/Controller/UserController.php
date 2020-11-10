<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\UpdatePassword;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * Permet d'afficher l'utilisateur
     * 
     * @Route("/user/{id}/{nom}", name="compte_user")
     * 
     * @return Response 
     */
    public function user(AuthenticationUtils $utils)
    {
        return $this->render('User/user.html.twig');
    }

    /**
     * Permet d'afficher l'utilisateur connecté
     * 
     * @Route("/user", name="compte_myuser")
     * 
     * @return Response 
     */
    public function monprofil()
    {
        return $this->render('User/user.html.twig',[
            'user' => $this->getUser()
        ]);
    }

    /**
     * Permet d'afficher le formulaire de connexion et le faire
     * 
     * @Route("/login", name="compte_login")
     * 
     * @return Response 
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('User/login.html.twig',[
            'haserror' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Deconnexion
     * 
     * @Route("/logout", name="compte_logout")
     *
     * @return Response
     */
    public function logout(){
        //quedalle hehe
    }

    /**
     * Formulaire d'inscription
     *
     * @Route("/register", name="compte_register")
     * 
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $user = new User();

        $form=$this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash=$encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'utilisateur {$user->getPrenom()} {$user->getNom()} a bien été enregistré"
            );

            return $this->redirectToRoute('compte_login');
        }

        return $this->render('User/register.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * Formulaire de modification du profil
     *
     * @Route("/user/profil", name="compte_profil")
     * 
     * @return Response
     */
    public function modifprofil(Request $request, EntityManagerInterface $manager){
        $user = $this->getUser();

        $form=$this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "La modification du profil a bien été enregistrée"
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('User/profil.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier le mpd
     * 
     * @route("/user/password-update", name="password_update")
     * 
     * @return Response
     */
    public function UpdatePassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $updatepassword = new UpdatePassword();

        $user = $this->getUser();

        $form=$this->createForm(PasswordUpdateType::class, $updatepassword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //verifier que l'ancien mot de passe soit le meme
            if (!password_verify($updatepassword->getOldPass(), $user->getHash())) {
                //gerer l'erreur
                $form->get('OldPass')->addError(new FormError("Le mot de passe que vous avez tape n'est pas votre mot de passe actuel"));
            }
            else {
                $newPass = $updatepassword->getNewPass();
                $hash = $encoder->encodePassword($user, $newPass);

                $user->setHash($hash);

                $manager->persist($updatepassword);
                $manager->flush();
            }            

            $this->addFlash(
                'success',
                "La modification du mot de passe a bien été enregistré"
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('User/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
