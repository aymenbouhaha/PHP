<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Translation\t;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionInterface $session): Response
    {
        if (!$session->has("todos")){
            $message="Bienvenue sur votre plateforme de gestion des todos";
            $this->addFlash("welcome",$message);
            $todos=[
              "lundi" =>"na9ra",
              "mardi"=>"nal3eb",
              "mercredi"=>"nal3eb mara okhra"
            ];
            $session->set("todos",$todos);
        }
        return $this->render('session/index.html.twig');
    }

    #[Route('/add/{cle}/{value}')]
    public function addToDo($cle, $value ,SessionInterface $session){
        if (! $session->has("todos")){
            $this->addFlash("error","Error :la liste n'est pas encore intialisée");
        }else{
            $todos=$session->get("todos");
            if (array_key_exists($cle,$todos)){
                $this->addFlash("error","Error: la todos existe deja");
            }else{
                $todos[$cle]=$value;
                $session->set("todos",$todos);
                $this->addFlash("success","Success : ajout de $cle avec succés");
            }
        }
        return $this->redirectToRoute('app_session');
    }


    #[Route("/delete/{position}")]
    public function deleteToDo($position,SessionInterface $session){
        if (! $session->has("todos")){
            $this->addFlash("error","Error :la liste n'est pas encore intialisée");
        }else{
            $todos=$session->get("todos");
            if (count($todos)<$position){
                $this->addFlash("error","Error :la position n'exite pas");
            }else{
                $counter=0;
                foreach ($todos as $cle => $value){
                    $counter++;
                    if ($counter==$position){
                        unset($todos[$cle]);
                    }
                }
                $session->set("todos",$todos);
                $this->addFlash("success","Success : Suppression avec succés");
            }
        }
        return $this->redirectToRoute("app_session");
    }

    #[Route("/reset")]
    public function resetToDo(SessionInterface $session){
        $session->remove("todos");
        $this->addFlash("success","Success : Reset avec succés");
        return $this->redirectToRoute("app_session");
    }

}
