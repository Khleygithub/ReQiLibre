<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
    
        // 1- Création du formulaire
        $form= $this->createForm(ContactType::class);

        // 3- Je récupère les données du formulaire inscrites par l'utilisateur dans tous les champs requis
        // En gros je lui dit : regarde si ya des données et récupère les moi de suite!! si ya rien il ne va pas beuguer
       $contact =  $form->handleRequest($request); // A partir de ce moment là on a le formulaire qui contient les données de la requette 


        // 4- Maintenant je dis à l'ordi, si tu trouve des données, affiche les moi
        if ($form->isSubmitted() && $form->isValid()) {

            // Alors récupère moi ces données avec getData() ensuite met les dans une variable qui s'appele $data
            // et affiche ces données avec dd()
            $data= $form->getData();

            // 6- Je vais remplir du coup l'adresse email du destinateur (celui qui envoie l'email via le formulaire quoi)
            //c'est le champs email du formulaire quoi. Je le récupère avec une variable $adress
            $address= $data['email'];
            $message= $data['message'];
            
             
            
        // 5- Je vais copier le code le site de symfony pour renseigner toute les infos de l'envoyeur
        // et le destinataire du mail (yaura 2 chose importante 1- renseigner les infos du mail 2-l'envoyer)
        $email = (new Email())
            ->from($address)                  // Le nom de l'editeur (l'utilisateur du formulaire)
            ->to('admin@symrecipe.com')     // moi ! l'admin , le destinataire du mail quoi
            ->subject('Demande de contact')
            ->text($message);                 // le message du mail ! que je recupere grace a ma variable $message
            // ->html('<p>See Twig integration for better HTML integration!</p>');     ça ya pas besoin pour l'instant ! c si je veux designer

        // 7- Maintenant que tout est bon! on va pouvoir envoyer le mail

        $mailer->send($email);



        }

        // 2- J'affiche le formulaire avec twig pour voir dja s'il s'affiche
        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'formulairecontact'=>$form
        ]);
    }
}
