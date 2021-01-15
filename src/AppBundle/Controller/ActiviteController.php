<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Activite;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ActiviteController extends Controller
{

	 /**
     * @Route("/activite", name="view_activite_route")
     */
     public function viewActiviteAction(){
     	$activites = $this->getDoctrine()->getRepository('AppBundle:Activite')->findAll();

     	return $this->render("pages/index_activite.html.twig",['activites' => $activites]);       //calling the view

     }


	 /**
     * @Route("/activite/create_activite", name="create_activite_route")
     */

     public function createActiviteAction(Request $request){
     	$activite = new activite;
     	$form = $this->createFormBuilder($activite)
     	->add('nom_a', TextType::Class, array('attr' => array('class' =>'form-control')))
     	->add('type', TextType::Class, array('attr' => array('class' =>'form-control')))
     	->add('description', TextareaType::Class, array('attr' => array('class' =>'form-control')))
     	->add('save', SubmitType::Class, array('label' => 'Ajouter l activite', 'attr' => array('class' =>'btn btn-primary', 'style' => 'margin-top:10px')))
     	->getForm();
     	$form->handleRequest($request);
     	if($form->isSubmitted() && $form->isValid()){
     		$nom_a = $form['nom_a']->getData();
     		$type = $form['type']->getData();
     		$description = $form['description']->getData();

     		$activite->setNomA($nom_a);
     		$activite->setType($type);
     		$activite->setDescription($description);

     		$em = $this->getDoctrine()->getManager(); //entity manager
     		$em->persist($activite);
     		$em->flush(); //saving data
     		$this->addFlash('message', 'Activite Ajouté Avec Succes ');
     		return $this->redirectToRoute('view_activite_route');
     	}
     	return $this->render("pages/create_activite.html.twig", ['form' => $form->createView()]);                 //calling the view

     }

	 /**
     * @Route("/activite/update_activite/{id}", name="update_activite_route")
     */

     public function updateActiviteAction(Request $request, $id){
          $activite = $this->getDoctrine()->getRepository('AppBundle:Activite')->find($id);
          $activite->setNomA($activite->getNomA());
          $activite->setType($activite->getType());
          $activite->setDescription($activite->getDescription());

          $form = $this->createFormBuilder($activite)
          ->add('nom_a', TextType::Class, array('attr' => array('class' =>'form-control')))
          ->add('type', TextType::Class, array('attr' => array('class' =>'form-control')))
          ->add('description', TextareaType::Class, array('attr' => array('class' =>'form-control')))
          ->add('save', SubmitType::Class, array('label' => 'Ajouter l activite', 'attr' => array('class' =>'btn btn-primary', 'style' => 'margin-top:10px')))
          ->getForm();
          $form->handleRequest($request);
          if($form->isSubmitted() && $form->isValid()){
               $nom_a = $form['nom_a']->getData();
               $type = $form['type']->getData();
               $description = $form['description']->getData();

               $em = $this->getDoctrine()->getManager();
               $activite = $em->getRepository('AppBundle:Activite')->find($id);

               $activite->setNomA($nom_a);
               $activite->setType($type);
               $activite->setDescription($description);

               $em->flush();

               $this->addFlash('message', 'Activite Ajouté Avec Succes ');
               return $this->redirectToRoute('view_activite_route');
          }
          return $this->render("pages/create_activite.html.twig", ['form' => $form->createView()]);



          

     	              //calling the view

     }          


	 /**
     * @Route("/activite/show_activite/{id}", name="show_activite_route")
     */

     public function showActiviteAction($id){
          $activite = $this->getDoctrine()->getRepository('AppBundle:Activite')->find($id);

     	return $this->render("pages/view_activite_route.html.twig", ['activite' => $activite]);                 //calling the view

     }


	 /**
     * @Route("/activite/delete_activite/{id}", name="delete_activite_route")
     */

     public function deleteActiviteAction($id){
     	$em = $this->getDoctrine()->getManager();
     	$activite = $em->getRepository('AppBundle:activite')->find($id);
     	$em->remove($activite);
     	$em->flush();
     	$this->addFlash('message', 'activite supprimé avec succes');

     	return $this->redirectToRoute("view_activite_route");                 //calling the view

     }

}