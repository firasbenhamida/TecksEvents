<?php

namespace TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TicketBundle\Entity\Book;
use TicketBundle\Entity\Evenement;
use TicketBundle\Entity\event;
use TicketBundle\Entity\Ticket;


class DefaultController extends Controller
{
    public function generateRandomString($length = 5)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function indexAction(Request $request, $id)
    {
        $events_repo = $this->getDoctrine()->getRepository(event::class);
        $event = $events_repo->find($id);
        if ($request->isMethod('POST'))
        {
            $ticket = new Ticket();
            $matricule = $this->generateRandomString();
            $pre = $request->get('prenom_person');
            $nom = $request->get('nom_person');
            $ticket->setPrix($request->get('prix'));
            $ticket->setType($request->get('type'));
            $ticket->setCodee($matricule);
            $ticket->setIdevent($event);
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
            return $this->redirectToRoute("ticket_homepage", array("id"=>$id,"ticket" => $ticket));
        }
        return $this->render("@Ticket/Default/index.html.twig", array("event" => $event,"count"=>$this->countbooks()));
    }


    public function choisirTAction()
    {
        $modele = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
        return $this->render("@Ticket/Default/choisirT.html.twig", array('modele' => $modele,'count'=>$this->countbooks()));
    }

    public function PaymentAction()
    {
        return $this->render("@Ticket/Default/Payment.html.twig",array('count'=>$this->countbooks()));
    }

    public function buyTAction($id)
    {
      if($id=!0){
        return $this->render("@Ticket/Default/index.html.twig");
      }
    }

    public function bookpageAction()
    {
       // $modele = $this->getDoctrine()->getRepository(event::class)->findAll();
            return $this->render("@Ticket/Default/bookpage.html.twig",array('count'=>$this->countbooks()));

    }
public function bookAction($nom,$prix)
{/*
    $ticket = new Ticket();
    $matricule = $this->generateRandomString();
    $pre = $request->get('prenom_person');
    $nom = $request->get('nom_person');
    $ticket->setPrix(0);
    $ticket->setType($request->get('type'));
    $ticket->setCodee($matricule);
    $ticket->setIdevent($event);
    $em = $this->getDoctrine()->getManager();
    $em->persist($ticket);
    $em->flush();
    */
    $em = $this->getDoctrine()->getManager();

 $b=new Book();
 $b->setNomevent($nom);
 $b->setPrixt($prix);
 $b->setPrixt($prix);
 $b->setPrixt($prix);

    $b->setCode($this->generateRandomString());
    $em->persist($b);
    $em->flush();
    return $this->render("@Ticket/Default/bookpage.html.twig",array('count'=>$this->countbooks()));

}


    public function viewbooksAction(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            return $this->render("@Ticket/Default/payment.html.twig",array('prix' => $request->get('prix')));
        }

        $modele = $this->getDoctrine()->getRepository(Book::class)->findAll();
        $a=new Book();
         $count=0;
        $sum=0;
        foreach ($modele as $a)
        {
            $count++;
          $sum += $a->getPrixt();
        }
        if($count >=5)
        {
            $sum= $sum *0.8;
        }
        return $this->render("@Ticket/Default/books.html.twig", array('books' => $modele,'sum'=>$sum,'count'=>$this->countbooks()));

    }

    public function deletebookAction($id)
    {
        $entity = $this->getDoctrine()->getRepository(Book::class)->findOneBy(array("id"=>$id));
$em=$this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
        $modele = $this->getDoctrine()->getRepository(Book::class)->findAll();
        $a=new Book();
        $count=0;
        $sum=0;
        foreach ($modele as $a)
        {
            $count++;
            $sum += $a->getPrixt();
        }
        if($count >=5)
        {
            $sum= $sum *0.8;
        }
        return $this->render("@Ticket/Default/books.html.twig", array('books' => $modele,'sum'=>$sum,'count'=>$this->countbooks()));

    }

    public function countbooks()
    {
        $em=$this->getDoctrine()->getManager();
        $modele = $this->getDoctrine()->getRepository(Book::class)->findAll();
        $count=0;
        $sum=0;
        foreach ($modele as $a)
        {
            $count++;
            $sum += $a->getPrixt();
        }

return $count;
    }
}