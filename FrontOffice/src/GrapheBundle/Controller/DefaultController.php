<?php

namespace GrapheBundle\Controller;

use GrapheBundle\Entity\Classe;
use TicketBundle\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

class DefaultController extends Controller
{
    public function indexAction()
    {


        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $classes = $em->getRepository(Classe::class)->findAll();
        $totalEtudiant=0;

 foreach($classes as $classe) {
     $totalEtudiant=$totalEtudiant+$classe->getNbEtudiants();
 }
 $data= array();
 $stat=['classe', 'nbEtudiant'];
 $nb=0;
 array_push($data,$stat);
 foreach($classes as $classe) {
     $stat=array();
     array_push($stat,$classe->getNom(),(($classe->getNbEtudiants()) *100)/$totalEtudiant);
     $nb=($classe->getNbEtudiants() *100)/$totalEtudiant;
     $stat=[$classe->getNom(),$nb];
     array_push($data,$stat);
 }
 $pieChart->getData()->setArrayToDataTable(
     $data
 );
 $pieChart->getOptions()->setTitle('Pourcentages des étudiants par niveau');
 $pieChart->getOptions()->setHeight(500);
 $pieChart->getOptions()->setWidth(900);
 $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
 $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
 $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
 $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
 $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
 return $this->render('@Graphe\Default\index.html.twig', array('piechart' => $pieChart ,'count'=>$this->countbooks()));
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

