<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Viz\DataVizBundle\Controller;

use Doctrine\Tests\Common\Annotations\Null;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class PageController extends Controller
    {
    public function indexAction(Request $request,$id=null){

        $em = $this->getDoctrine()
            ->getManager();
       $metanodes = $em->getRepository('VizDataVizBundle:MetaNodes')
            ->getMetaNodes();

        $metaedges=$em->getRepository('VizDataVizBundle:MetaEdges')
            ->getMetaEdges();

      $hashtags  =$em->getRepository('VizDataVizBundle:ClusterHashtags')
            ->getHashtags();

        $defaultData = array('message' => "shit");
        $form = $this->createFormBuilder($defaultData)
            -> add('hashtags', 'choice', array(
                    'choices'=>$hashtags,  'multiple' => true,'constraints' => array(
                    new NotBlank())))
            ->getForm();
        $cloned= clone $form;
        $session=$this->get('session');

        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $d=  $this->get('request')->request->get('form');
              	$dat=array();
                for($i=0;$i<sizeof($d['hashtags']);$i++){
                        $index=$d['hashtags'];
                        $index=$index[$i];
                        $dat[]=$hashtags[$index];
                    }
                $this->get('session')->set('message', $dat);
                $fo = $this->createFormBuilder($defaultData)
                    -> add('hashtags', 'choice', array(
                        'choices'=>$hashtags,  'multiple' => true,'constraints' => array(
                            new NotBlank())))
                    ->getForm();
            $resp= $this->redirect('hashtag');
            return $resp;
            }
            else {
                $errors = $form->getErrorsAsString();
                var_dump($errors);
            }
        }

        return $this->render('VizDataVizBundle:Page:index.html.twig',array(
          'metadata'=>array('nodes'=>$metanodes, 'edges'=>$metaedges,'hashtags'=>$hashtags,'flag'=>11,'d'=>'none'),
            'form' => $form->createView()));
    }
public function hashtagAction(){
    $dat= $this->get('session')->get('message');

    $this->get('session')->clear();
    $hashtags=array();

    $em = $this->getDoctrine()
        ->getManager();
static $htedges;
   static $htnodes;

    $defaultData = array('message' => "shit");


    $hashtags  =$em->getRepository('VizDataVizBundle:ClusterHashtags')
        ->getHashtags();

    $for = $this->createFormBuilder($defaultData)
        -> add('hashtags', 'choice', array(
            'choices'=>$hashtags,  'multiple' => true,'constraints' => array(
                new NotBlank())))
        ->getForm();

    if($dat){
    $htedges=$em->getRepository('VizDataVizBundle:Edges')
        ->getEdgesByHashtag($dat);
    $htnodes=$em->getRepository('VizDataVizBundle:Nodes')
        ->getNodesByHashtag($dat);
        return $this->render('VizDataVizBundle:Page:index.html.twig',array(
            'metadata'=>array('nodes'=>$htnodes, 'edges'=>$htedges,'hashtags'=>$hashtags,'flag'=>22,'d'=>$dat),
            'form' => $for->createView()));

    }
    else{
        $resp= $this->redirect('/');
        return $resp;
    }
}

    public function  communityAction(){
       $request = $this->get('request');
        $mod=$request->get('id');
        $em = $this->getDoctrine()
            ->getManager();
        $e= $em->getRepository('VizDataVizBundle:Edges')
            ->getClusterEdges($mod);
        $n= $em->getRepository('VizDataVizBundle:Nodes')
            ->getClusterNodes($mod);
        return new Response(json_encode(array('nodes'=>$n,'edges'=>$e)));


    }


}
