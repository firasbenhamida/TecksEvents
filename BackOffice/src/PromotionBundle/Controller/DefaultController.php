<?php

namespace PromotionBundle\Controller;

use PromotionBundle\Entity\Book;
use PromotionBundle\Entity\Ticket;
use Symfony\Component\Routing\Annotation\Route;
use PromotionBundle\Entity\Promotion;
use PromotionBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Promotion/Default/index.html.twig');
    }



    public function ajoutAction(Request $request)
    {
        $em1=$this->getDoctrine()->getManager();
        $Promotion = new  Promotion();

        if ($request->isMethod("POST"))
        {

            $Promotion->setTitre($request->get("stock"));
            $Promotion->setPromo($request->get("stock1"));

            $Promotion->setIdEvent($request->get("idevent"));

            $em1->persist($Promotion);
            $em1->flush();

        }

        $evenet = new  Evenement();
        $evenet=$em1->getRepository(Evenement::class)->findAll();
        return $this->render("@Promotion/Default/ajout.html.twig",array('evenements'=>$evenet));

    }





    public function deleteModeleAction($id){
        $modele=$this->getDoctrine()->getRepository(Promotion::class)->find($id);
        $em= $this->getDoctrine()->getManager();
        $em->remove($modele);
        $em->flush();
        return  $this->redirectToRoute("afficherP");

    }



    public function deleteModeleTAction($id){
        $modele=$this->getDoctrine()->getRepository(Ticket::class)->find($id);
        $em= $this->getDoctrine()->getManager();
        $em->remove($modele);
        $em->flush();
        return  $this->redirectToRoute("afficherT");

    }




    public function afficherPAction()
    {

        $modele = $this->getDoctrine()->getRepository(Promotion::class)->findAll();
        return $this->render("@Promotion/Default/afficherP.html.twig", array('modele' => $modele));



    }

    public function afficherBAction()
    {

        $modele = $this->getDoctrine()->getRepository(Book::class)->findAll();
        return $this->render("@Promotion/Default/afficherB.html.twig", array('modele' => $modele));



    }

    public function afficherTAction()
    {

        $modele = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
        return $this->render("@Promotion/Default/afficherT.html.twig", array('modele' => $modele));
    }


    public function modifierPAction($id,Request $request){



        if ($request->isMethod("POST"))
        {
            $KKK = new  Promotion();
            $KKK=$this->getDoctrine()->getRepository(Promotion::class)->find($id);
            $em1= $this->getDoctrine()->getManager();
            $KKK->setId($request->get("id"));
            $KKK->setPromo($request->get("promo"));
            $em1->persist($KKK);
            $em1->flush();


        return  $this->redirectToRoute("afficherP");

    }


        $modele = $this->getDoctrine()->getRepository(Promotion::class)->find($id);
        return $this->render("@Promotion/Default/ModifierP.html.twig", array('modele' => $modele));
    }



    public function modifierTAction($id,Request $request){




       // return $this->render("@Forum/Default/traitertopic.html.twig", array('modele' => $modele, 'modeles' => $modeles,'modeless' => $modeless));

        if ($request->isMethod("POST"))
        {
            $KKK = new  Ticket();
            $KKK = $this->getDoctrine()->getRepository(Ticket::class)->find($id);
            $em1= $this->getDoctrine()->getManager();
            $em2= $this->getDoctrine()->getManager();
            $KKK->setPrix($request->get("prix"));
            $KKK->setType($request->get("type"));
            $em1->persist($KKK);
            $em1->flush();
            $em2->flush();


            return  $this->redirectToRoute("afficherT");

        }


        $modele = $this->getDoctrine()->getRepository(Ticket::class)->find($id);
        return $this->render("@Promotion/Default/ModifierT.html.twig", array('modele' => $modele));
    }



}
