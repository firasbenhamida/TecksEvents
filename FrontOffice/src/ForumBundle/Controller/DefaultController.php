<?php

namespace ForumBundle\Controller;

use AppBundle\Entity\User;
use ForumBundle\Entity\Categories;
use ForumBundle\Entity\commentaire;
use ForumBundle\EventListener\ImageUploadListener;
use ForumBundle\ImageUpload;
use ForumBundle\Entity\Vue;
use ForumBundle\Form\questionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use ForumBundle\Entity\question;
use ForumBundle\Entity\reponse;
use ForumBundle\Entity\fuser;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use TicketBundle\Entity\Book;

class DefaultController extends Controller
{

    /**
     * @Route("/forum", name="forum" )
     */
    public function newAction(Request $request)
    {
        // creates a task and gives it some dummy data for this example
        $task = new question();
        $form = $this->createForm(questionType::class,$task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod("POST"))
            {
                $question = new question();
                $em1 = $this->getDoctrine()->getManager();
                $date = new \DateTime();
                $question->setTitre("z");
                $question->setIdMembre(5);
                $question->setNom("z");
                $question->setDescription("z");
                $question->setCategorie("z");
                $question->setDate($date);
                $question->setImage($task->getImage());
                $em1->persist($question);
                $em1->flush();
                $modele = $this->getDoctrine()->getRepository(question::class)->find(75);
                return $this->render('@Forum/Default/index.html.twig',array('count'=>$this->countbooks(),'count'=>$this->countbooks()));
            }

        }

        return $this->render('@Forum/Default/form.html.twig' ,[
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/", name="index")
     */

    public function indexAction()
    {
        $user=$this->getUser();
        if($user != NULL)
        {
            $date = new \DateTime();
            $x = new \DateTime();
            $ban = new fuser();
            $ban = $this->getDoctrine()->getRepository(fuser::class)->findBy(array('idm' => $this->getUser()->GetId()));
            foreach ($ban as $e) {
                if($e->getFban()<=$date && $e->getBan()==1)
                {
                    $em1 = $this->getDoctrine()->getManager();
                    $e->setActivite("ExBanned");
                    $e->setBan(0);
                    $e->setDban(NULL);
                    $e->setDuree(NULL);
                    $e->setFban(NULL);
                    $em1->persist($e);
                    $em1->flush();
                }

                if($date->format('y') == $e->getLactiv()->format('y') && $date->format('m') - $e->getLactiv()->format('m')>=2
                    || ($date->format('y') + 1) == $e->getLactiv()->format('y') && ($date->format('m') + 12 - $e->getLactiv()->format('m'))>=2 )
                {
                    $em1 = $this->getDoctrine()->getManager();
                    $e->setActivite("Innactif");
                    $em1->persist($e);
                    $em1->flush();
                }
            }
        }
        $modele = $this->getDoctrine()->getRepository(question::class)->find(78);

        return $this->render('@Forum/Default/index.html.twig',array('modele' => $modele,'count'=>$this->countbooks()));
    }

    /**
     * @Route("/ajouter", name="ajouter" )
     */

    public function ajouterAction(Request $request)
    {
        $task = new question();
        $form = $this->createForm(questionType::class,$task);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            if ($request->isMethod("POST")) {
                $question = new question();
                $date = new \DateTime();
                $em1 = $this->getDoctrine()->getManager();
                $question->setTitre($request->get("titre"));
                $question->setIdMembre($request->get("id"));
                $question->setNom($request->get("nom"));
                $question->setDescription($request->get("description"));
                $question->setCategorie($request->get("select"));
                $question->setDate($date);
                $question->setImage($task->getImage());
                $em1->persist($question);
                $em1->flush();

                $tab= array();
                $Vue = new Vue();
                $em1 = $this->getDoctrine()->getManager();
                $Vue->setIdq($question->getId());
                $Vue->setTab($tab);
                $em1->persist($Vue);
                $em1->flush();

                $date = new \DateTime();
                $ban = new fuser();
                $ban = $this->getDoctrine()->getRepository(fuser::class)->findBy(array('idm' => $this->getUser()->GetId()));
                foreach ($ban as $e) {
                    $em1 = $this->getDoctrine()->getManager();
                    if($e->getNbc()>=5)
                    {
                        $e->setActivite("Active");
                    }
                    $e->setNbc($e->getNbc()+1);
                    $e->setLactiv($date);
                    $em1->persist($e);
                    $em1->flush();
                }

                return $this->redirectToRoute("afficherq");
            }
        }
        $user=$this->getUser();
        if($user != NULL)
        {
            $banned = new fuser();
            $ban = $this->getDoctrine()->getRepository(fuser::class)->findBy(array('idm' => $this->getUser()->GetId()));
            foreach ($ban as $e) {
                $banned=$e;
            }
        }
        $modele = $this->getDoctrine()->getRepository(Categories::class)->findAll();
        return $this->render("@Forum/Default/ajouterq.html.twig", array('banned' => $banned,'modele' => $modele,'count'=>$this->countbooks(),'form' => $form->createView()));
    }

    /**
     * @Route("/afficherq", name="afficherq")
     */

    public function listModelAction()
    {
        $modele = $this->getDoctrine()->getRepository(question::class)->findAll();
        $modele1 = $this->getDoctrine()->getRepository(Categories::class)->findAll();
        $modele2 = $this->getDoctrine()->getRepository(Vue::class)->findAll();
        return $this->render("@Forum/Default/afficherq.html.twig", array('modele' => $modele, 'modele1' => $modele1, 'modele2' => $modele2,'count'=>$this->countbooks()));
    }

    /**
     * @Route("/consulter/{id_q}", name="consulter" , requirements={"id_q"="\d+"})
     */

    public function traiterAction(Request $request, $id_q)
    {
        if ($request->isMethod("POST")) {

            if ($request->get("idban") != NULL) {
                return $this->redirectToRoute('ban',array('id' => $request->get("idban")));
            }

            if ($request->get("idcomm") != NULL) {
                $modele = $this->getDoctrine()->getRepository(commentaire::class)->find($request->get("idcomm"));
                $em = $this->getDoctrine()->getManager();
                $em->remove($modele);
                $em->flush();
            }

            if ($request->get("idreponse") != NULL) {
                $modeles = $this->getDoctrine()->getRepository(reponse::class)->find($request->get("idreponse"));
                if ($modeles != NULL)
                {
                    foreach ($modeles as $e)
                    {
                        $emm = $this->getDoctrine()->getManager();
                        $emm->remove($e);
                        $emm->flush();
                    }
                }
                $modeless = $this->getDoctrine()->getRepository(commentaire::class)->findBy(array('idR' => $request->get("idreponse")));
                if ($modeless != NULL)
                {
                    foreach ($modeless as $e)
                    {
                        $emm = $this->getDoctrine()->getManager();
                        $emm->remove($e);
                        $emm->flush();
                    }
                }
            }

            if ($request->get("idquestion") != NULL) {
                return $this->redirectToRoute('supprimer',array('id_q' => $request->get("idquestion")));
            }

            if ($request->get("descriptionr") != NULL) {
                $comm = new commentaire();
                $date = new \DateTime();
                $em1 = $this->getDoctrine()->getManager();
                $comm->setDescription($request->get("descriptionr"));
                $comm->setIdQ($id_q);
                $comm->setIdR($request->get("idr"));
                $comm->setIdM($request->get("idm"));
                $comm->setNom($request->get("nom"));
                $comm->setDate($date);
                $em1->persist($comm);
                $em1->flush();

                $date = new \DateTime();
                $ban = new fuser();
                $ban = $this->getDoctrine()->getRepository(fuser::class)->findBy(array('idm' => $this->getUser()->GetId()));
                foreach ($ban as $e) {
                    $em1 = $this->getDoctrine()->getManager();
                    if($e->getNbc()>=5)
                    {
                        $e->setActivite("Active");
                    }
                    $e->setNbc($e->getNbc()+1);
                    $e->setLactiv($date);
                    $em1->persist($e);
                    $em1->flush();
                }
            }
            if ($request->get("description") != NULL) {
                $reponse = new reponse();
                $date = new \DateTime();
                $em1 = $this->getDoctrine()->getManager();
                $reponse->setDescription($request->get("description"));
                $reponse->setIdQ($id_q);
                $reponse->setIdM($request->get("id"));
                $reponse->setNom($request->get("nom"));
                $reponse->setDate($date);
                $em1->persist($reponse);
                $em1->flush();

                $date = new \DateTime();
                $ban = new fuser();
                $ban = $this->getDoctrine()->getRepository(fuser::class)->findBy(array('idm' => $this->getUser()->GetId()));
                foreach ($ban as $e) {
                    $em1 = $this->getDoctrine()->getManager();
                    if($e->getNbc()>=5)
                    {
                        $e->setActivite("Active");
                    }
                    $e->setNbc($e->getNbc()+1);
                    $e->setLactiv($date);
                    $em1->persist($e);
                    $em1->flush();
                }
            }
        }
        $user=$this->getUser();
        if($user != NULL)
        {
            $vue = new Vue();
            $vue = $this->getDoctrine()->getRepository(Vue::class)->findBy(array('idq' => $id_q));
            foreach ($vue as $e) {
                $tab = $e->getTab();
                $em1 = $this->getDoctrine()->getManager();
                if (!in_array($this->getUser()->GetId(), $tab)) {
                    $tab[sizeof($tab)] = $this->getUser()->GetId();
                    $e->setTab($tab);
                    $em1->persist($e);
                    $em1->flush();
                }
            }
            $banned = new fuser();
            $ban = $this->getDoctrine()->getRepository(fuser::class)->findBy(array('idm' => $this->getUser()->GetId()));
            foreach ($ban as $e) {
                $banned=$e;
                }
        }
        else{$banned = new fuser();$banned->setBan(0);}
        $infooo = new fuser();
        $info = $this->getDoctrine()->getRepository(fuser::class)->findAll();
        $model = $this->getDoctrine()->getRepository(User::class)->findAll();
        $vues = $this->getDoctrine()->getRepository(Vue::class)->findBy(array('idq' => $id_q));
        $modele = $this->getDoctrine()->getRepository(question::class)->find($id_q);
        $infoo = $this->getDoctrine()->getRepository(fuser::class)->findBy(array('idm' => $modele->getIdMembre()));
        foreach ($infoo as $e) {
            $infooo=$e;
        }
        $modeles = $this->getDoctrine()->getRepository(reponse::class)->findBy(array('idQ' => $id_q));
        $modeless = $this->getDoctrine()->getRepository(commentaire::class)->findBy(array('idQ' => $id_q));
        return $this->render("@Forum/Default/consulter.html.twig", array('modele' => $modele, 'modeles' => $modeles, 'modeless' => $modeless, 'model' => $model, 'vues' => $vues,'count'=>$this->countbooks(),'banned' => $banned,'info' => $info,'infooo' => $infooo));
    }


    /**
     * @Route("/edit{id_q}", name="edit" )
     */

    public function editAction(Request $request)
    {
        if ($request->isMethod("POST")) {
            $id_m = 5;
            $nom = "hamza";
            $question = new question();
            $em1 = $this->getDoctrine()->getManager();
            $question->setTitre($request->get("titre"));
            $question->setIdMembre($id_m);
            $question->setNom($nom);
            $question->setDescription($request->get("description"));
            $em1->persist($question);
            $em1->flush();
            return $this->redirectToRoute("afficherq");
        }

        return $this->render("@Forum/Default/ajouterq.html.twig",array('count'=>$this->countbooks()));
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

    /**
     * @Route("/supprimer/{id_q}", name="supprimer" , requirements={"id_q"="\d+"})
     */

    public function deleteModeleAction($id_q)
    {
        $modele = $this->getDoctrine()->getRepository(question::class)->find($id_q);
        $em = $this->getDoctrine()->getManager();
        $em->remove($modele);
        $em->flush();
        $modeles = $this->getDoctrine()->getRepository(reponse::class)->findBy(array('idQ' => $id_q));
        if ($modeles != NULL)
        {
            foreach ($modeles as $e)
            {
                $emm = $this->getDoctrine()->getManager();
                $emm->remove($e);
                $emm->flush();
            }
        }
        $modeless = $this->getDoctrine()->getRepository(commentaire::class)->findBy(array('idQ' => $id_q));
        if ($modeless != NULL)
        {
            foreach ($modeless as $e)
            {
                $emm = $this->getDoctrine()->getManager();
                $emm->remove($e);
                $emm->flush();
            }
        }
        return $this->redirectToRoute("afficherq");

    }

    /**
     * @Route("/ban/{id}", name="ban" , requirements={"id_q"="\d+"})
     */

    public function banAction(Request $request,$id)
    {
        if ($request->isMethod("POST"))
        {
            if($request->get('bandef'))
            {
                $modele = $this->getDoctrine()->getRepository(question::class)->findBy(array('idMembre' => $request->get('id')));
                if ($modele != NULL)
                {
                    foreach ($modele as $a)
                    {
                        $emm = $this->getDoctrine()->getManager();
                        $emm->remove($a);
                        $emm->flush();
                    }
                }
                $modeles = $this->getDoctrine()->getRepository(reponse::class)->findBy(array('idM' => $request->get('id')));
                if ($modeles != NULL)
                {
                    foreach ($modeles as $e)
                    {
                        $emm = $this->getDoctrine()->getManager();
                        $emm->remove($e);
                        $emm->flush();
                    }
                }
                $modeless = $this->getDoctrine()->getRepository(commentaire::class)->findBy(array('idM' => $request->get('id')));
                if ($modeless != NULL)
                {
                    foreach ($modeless as $e)
                    {
                        $emm = $this->getDoctrine()->getManager();
                        $emm->remove($e);
                        $emm->flush();
                    }
                }
                return $this->redirectToRoute("afficherq");
            }
            $em1 = $this->getDoctrine()->getManager();
            $date = new \DateTime();
            $datee = new \DateTime();
            $fuser = new fuser();
            $fuser = $this->getDoctrine()->getRepository(fuser::class)->findBy(array('idm' => $request->get('id')));
            foreach ($fuser as $e)
            {
                $e->setActivite("Banned");
                $e->setBan(1);
                $e->setDban($date);
                $e->setNbc(0);
                $e->setDuree($request->get('nb'));
                $datee->setDate($date->format('Y'), $date->format('m')+$request->get('nb'),$date->format('d'));
                $e->setFban($datee);
                $em1->persist($e);
                $em1->flush();
            }


        }
        $modele = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render("@Forum/Default/ban.html.twig",array('modele' => $modele));

    }
}
