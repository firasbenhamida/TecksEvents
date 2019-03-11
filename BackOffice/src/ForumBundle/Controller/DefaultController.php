<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Categories;
use ForumBundle\Entity\commentaire;
use ForumBundle\Entity\Vue;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\HttpFoundation\Request;
use ForumBundle\Entity\question;
use ForumBundle\Entity\reponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends Controller
{

    /**
     * @Route("/test", name="test")
     */

    public function indexAction()
    {
        return $this->render('@Forum/Default/index.html.twig');
    }

    /**
     * @Route("/afficher", name="afficher")
     */

    public function listModelAction()
    {
        $modele = $this->getDoctrine()->getRepository(question::class)->findAll();
        $modeles = $this->getDoctrine()->getRepository(Categories::class)->findAll();
        return $this->render("@Forum/Default/affichertopics.html.twig", array('modele' => $modele,'modeles' => $modeles));
    }

    /**
     * @Route("/categorie", name="categorie")
     */

    public function categorielAction()
    {
        $modele = $this->getDoctrine()->getRepository(Categories::class)->findAll();
        return $this->render("@Forum/Default/categorie.html.twig", array('modele' => $modele));
    }

    /**
     * @Route("/repondre/{id_q}", name="repondre" , requirements={"id_q"="\d+"})
     */

    public function traiterAction(Request $request, $id_q)
    {
        if ($request->isMethod("POST")) {

            if($request->get("idcomm")!=NULL)
            {
                $modele = $this->getDoctrine()->getRepository(commentaire::class)->find($request->get("idcomm"));
                $em = $this->getDoctrine()->getManager();
                $em->remove($modele);
                $em->flush();
            }

            if($request->get("descriptionr")!=NULL)
            {
                $comm = new commentaire();
                $date=new \DateTime();
                $em1 = $this->getDoctrine()->getManager();
                $comm->setDescription($request->get("descriptionr"));
                $comm->setIdQ($id_q);
                $comm->setIdR($request->get("idr"));
                $comm->setIdM($request->get("idm"));
                $comm->setNom($request->get("nom"));
                $comm->setDate($date);
                $em1->persist($comm);
                $em1->flush();
            }
            if($request->get("description")!=NULL)
            {
                $reponse = new reponse();
                $date=new \DateTime();
                $em1 = $this->getDoctrine()->getManager();
                $reponse->setDescription($request->get("description"));
                $reponse->setIdQ($id_q);
                $reponse->setIdM($request->get("id"));
                $reponse->setNom($request->get("nom"));
                $reponse->setDate($date);
                $em1->persist($reponse);
                $em1->flush();
            }

        }
        $modele = $this->getDoctrine()->getRepository(question::class)->find($id_q);
        $modeles = $this->getDoctrine()->getRepository(reponse::class)->findBy(array('idQ' => $id_q));
        $modeless = $this->getDoctrine()->getRepository(commentaire::class)->findBy(array('idQ' => $id_q));
        return $this->render("@Forum/Default/traitertopic.html.twig", array('modele' => $modele, 'modeles' => $modeles,'modeless' => $modeless));
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
        return $this->redirectToRoute("afficher");

    }

    /**
     * @Route("/renommer/{id_c},{type}", name="renommer" , requirements={"id_q"="\d+"})
     */

    public function renameAction(Request $request,$id_c,$type)
    {
        if ($request->isMethod("POST"))
        {
            $KKK = new  Categories();
            $KKK=$this->getDoctrine()->getRepository(Categories::class)->find($id_c);
            $em1= $this->getDoctrine()->getManager();
            $KKK->setId($id_c);
            $KKK->setType($request->get("description"));
            $em1->persist($KKK);
            $em1->flush();

            $KKK = new  question();
            $KKK=$this->getDoctrine()->getRepository(question::class)->findBy(array('categorie' => $type));
            foreach ($KKK as $K)
            {
                $em1= $this->getDoctrine()->getManager();
                $K->setCategorie($request->get("description"));
                $em1->persist($K);
                $em1->flush();
            }

            return  $this->redirectToRoute("categorie");

        }
        $modele = $this->getDoctrine()->getRepository(Categories::class)->find($id_c);
        return $this->render("@Forum/Default/rename.html.twig", array('modele' => $modele));

    }

    /**
     * @Route("/ajoutc/", name="ajoutc" )
     */

    public function ajoutcAction(Request $request)
    {
        if ($request->isMethod("POST"))
        {
            $KKK = new  Categories();
            $em1= $this->getDoctrine()->getManager();
            $KKK->setType($request->get("description"));
            $em1->persist($KKK);
            $em1->flush();

            return  $this->redirectToRoute("categorie");
        }

        return $this->render("@Forum/Default/ajoutc.html.twig");

    }

    /**
     * @Route("/supprimerc/{id_c},{type}", name="supprimerc" )
     */

    public function suppceAction($id_c,$type)
    {
        $modele = $this->getDoctrine()->getRepository(Categories::class)->find($id_c);
        $em = $this->getDoctrine()->getManager();
        $em->remove($modele);
        $em->flush();
        $modeles = $this->getDoctrine()->getRepository(question::class)->findBy(array('categorie' => $type));
        if ($modeles != NULL)
        {
            foreach ($modeles as $e)
            {
                $modeless = $this->getDoctrine()->getRepository(reponse::class)->findBy(array('idQ' => $e->getId()));
                if ($modeless != NULL)
                {
                    foreach ($modeless as $ee)
                    {
                        $modelesss = $this->getDoctrine()->getRepository(commentaire::class)->findBy(array('idQ' => $e->getId()));
                        if ($modelesss != NULL) {
                            foreach ($modelesss as $eee) {
                                $emm = $this->getDoctrine()->getManager();
                                $emm->remove($eee);
                                $emm->flush();
                            }
                        }

                        $emm = $this->getDoctrine()->getManager();
                        $emm->remove($ee);
                        $emm->flush();
                    }
                }

                $emm = $this->getDoctrine()->getManager();
                $emm->remove($e);
                $emm->flush();
            }
        }
        return $this->redirectToRoute("categorie");
    }

    /**
     * @Route("/statc/", name="statc" )
     */

    public function statAction()
    {
        $tab= array();
        $modele = $this->getDoctrine()->getRepository(Categories::class)->findAll();
        foreach ($modele as $e)
        {
            $X=0;
            $modeles = $this->getDoctrine()->getRepository(question::class)->findBy(array('categorie' => $e->getType()));
            foreach ($modeles as $ee)
            {
                $modeless = $this->getDoctrine()->getRepository(Vue::class)->findBy(array('idq' => $ee->getId()));
                foreach ($modeless as $eee)
                {
                    $X=$X+sizeof($eee->getTab());
                }
            }
            $tab[sizeof($tab)]=$X;
            $X=5;
        }
        return $this->render('@Forum/Default/statc.html.twig',array('modele' => $modele,'tab' => $tab,'X0' => $tab[0],'X1' => $tab[1],'X2' => $tab[2],'X3' => $tab[3]));
    }


}
