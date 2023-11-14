<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    // 1- Affche et connecte un Utilisateur
    #[Route(path: '/login', name: 'app_security_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    // 2- Déconnecte un Utilisateur
    #[Route(path: '/logout', name: 'app_security_logout')]
    public function logout(): Response
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        // return $this->redirectToRoute('app_security_login');
    }






    // ------------------------------ INSCRIPTION CONTROLLER ----------------------------




    #[Route(path: '/inscription', name: 'app_security_inscription')]
    public function inscription (UserRepository $repository, Request $request, UserPasswordHasherInterface $passwordHasher) : Response
    {

        // 1- Creation du formulaire
        $form = $this->createForm(UserType::class);
        


// 2- Gérez la requette du formulaire (ex: formulaire est ce que tu me m'envoyer tel données etc..)
// (handleRequest ou Request) ou "Remplir les données du formulaire d'inscription"
$form->handleRequest($request);


// 3- Condtion pour le formulaire ( tester si le formulaire est envoyé et valid alors :
    if ($form->isSubmitted()&& $form->isValid()){
         // a- recuperez les données (avec Get) ou "on récupere l'utilisateur du formulaire"
        $user = $form->getData();
        // en gros la il dit ehh si formulaire le formulaire est soumis et valide alors 
        //(créer la variable utilisateur et récuper les données du form avec get) 

        //b- (attention HACHER (crypter) le mot de passe avant de l'envoyer à la base de donnée)

        $hasherPassword = $passwordHasher->hashPassword($user, $user->getPassword());
        //ça y est la le mot de pass est haché
        // maintenant modifier le mot de passe de l'utilisateur en le remplaçant par le mot de pass hasher
        $user->setPassword($hasherPassword);
        //c- maintenant une fois que c'est récupérer on va rajouter (enregistrer) l'utilisateur avec 
        // le mot de pass modif à la base de donner
        
         $repository->add($user, true); 

         //renvoyez le nouveau utilisateur à la page de connexion

        return $this->redirectToRoute('app_security_login');
    }
   
            


    // 4- Ici j'affiche mon formulaire (la page d'inscription)
        return $this->render('security/inscription.html.twig',[
            'fofo'=>$form->createView()
        ]);





    }

    
}
