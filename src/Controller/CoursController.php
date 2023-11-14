<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoursController extends AbstractController
{

    #[IsGranted("ROLE_ADMIN")]
    #[Route(path: '/cours/create', name: 'app_cours_create')]
    public function createCours (CoursRepository $repository, Request $request): Response
    {

        // 1- Creation du formulaire
        $form = $this->createForm(CoursType::class);
        


        // 2- Gérez la requette du formulaire (ex: formulaire est ce que tu me m'envoyer tel données etc..)
        // (handleRequest ou Request) ou "Remplir les données su formulaire d'inscription"
        $form->handleRequest($request);


        // 3- Condtion pour le formulaire ( tester si le formulaire est envoyé et valid alors :
    if ($form->isSubmitted()&& $form->isValid()){
         // a- recuperez les données (avec Get) ou "on récupere l'utilisateur du formulaire"
        $cours = $form->getData();
        // en gros la il dit ehh si formulaire le formulaire est soumis et valide alors 
        //(créer la variable cours et récuper les données du form avec get) 

        //b- maintenant une fois que c'est récupérer on va rajouter (enregistrer) le nouveau cours 
        // à la base de donner

       
        
         $repository->save($cours, true);

         //renvoyez l'Administrateur à la page de la liste des cours

        return $this->redirectToRoute('app_cours_listCours');
    }
   



        return $this->render("cours/create.html.twig", [
            "form"=>$form->createView()
        ]);

    }

    #[IsGranted("ROLE_USER")]
    #[Route(path: '/cours/list', name: 'app_cours_listCours')]

    // envoyer les infos des cours de la base de donner au twig au template
public function listCours(CoursRepository $repository): Response
{
    // envoyer au twig

    return $this->render("cours/listCours.html.twig", [

        // la jai demander au repository de me recuperer les cours/ cette 
        //instruction repond a la demande du haut la 
        "cours"=>$repository->findAll()
    ]);
}


// ---------------------------------- UPDATE ------------

#[IsGranted("ROLE_ADMIN")]
    #[Route(path: '/cours/update/{id}', name: 'app_cours_update')]
    public function updateCours (CoursRepository $repository, Cours $cours, Request $request): Response
    {

        // 1- Creation du formulaire
        $form = $this->createForm(CoursType::class, $cours);
        


        // 2- Gérez la requette du formulaire (ex: formulaire est ce que tu me m'envoyer tel données etc..)
        // (handleRequest ou Request) ou "Remplir les données su formulaire d'inscription"
        $form->handleRequest($request);


        // 3- Condtion pour le formulaire ( tester si le formulaire est envoyé et valid alors :
    if ($form->isSubmitted()&& $form->isValid()){
         // a- recuperez les données (avec Get) ou "on récupere l'utilisateur du formulaire"
        $cours = $form->getData();
        // en gros la il dit ehh si formulaire le formulaire est soumis et valide alors 
        //(créer la variable cours et récuper les données du form avec get) 

        //b- maintenant une fois que c'est récupérer on va rajouter (enregistrer) le nouveau cours 
        // à la base de donner

       
        
         $repository->save($cours, true);

         //renvoyez l'Administrateur à la page de la liste des cours

        return $this->redirectToRoute('app_cours_listCours');
    }
   



        return $this->render("cours/create.html.twig", [
            "form"=>$form->createView()
        ]);

    }



    // ---------------------------------- DELETE ------------


    #[Route('/cours/delete/{id}', name: 'app_cours_delete', methods:['GET'])]
    public function deleteCours(CoursRepository $repository, Cours $cours,):Response
    {

        $repository->remove($cours, true);
        $response = ['succes' => 'Tâche supprimée'];


        return $this->render("cours/listCours.html.twig", [

            // la jai demander au repository de me recuperer les cours/ cette 
            //instruction repond a la demande du haut la 
            "cours"=>$repository->findAll()
        ]);

    }     

}
