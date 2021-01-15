<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Participant;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ParticipantController extends Controller
{

	 /**
     * @Route("/participant", name="view_participant_route")
     */
     public function viewParticipantAction(){
     	$participants = $this->getDoctrine()->getRepository('AppBundle:Participant')->findAll();

     	return $this->render("pages/index.html.twig",['participants' => $participants]);       //calling the view

     }


	 /**
     * @Route("/participant/create", name="create_participant_route")
     */

     public function createParticipantAction(Request $request){
     	$participant = new participant;
     	$form = $this->createFormBuilder($participant)
     	->add('num', TextType::Class, array('attr' => array('class' =>'form-control')))
     	->add('nom', TextType::Class, array('attr' => array('class' =>'form-control')))
     	->add('prenom', TextType::Class, array('attr' => array('class' =>'form-control')))
     	->add('save', SubmitType::Class, array('label' => 'Ajouter le Participant', 'attr' => array('class' =>'btn btn-primary', 'style' => 'margin-top:10px')))
     	->getForm();
     	$form->handleRequest($request);
     	if($form->isSubmitted() && $form->isValid()){
     		$num = $form['num']->getData();
     		$nom = $form['nom']->getData();
     		$prenom = $form['prenom']->getData();

     		$participant->setNum($num);
     		$participant->setNom($nom);
     		$participant->setPrenom($prenom);

     		$em = $this->getDoctrine()->getManager(); //entity mana
     		$em->persist($participant);
     		$em->flush(); //saving data
     		$this->addFlash('message', 'Participant Ajouté Avec Succes ');
     		return $this->redirectToRoute('view_participant_route');
     	}
     	return $this->render("pages/create.html.twig", ['form' => $form->createView()]);                 //calling the view

     }

	 /**
     * @Route("/participant/update/{id}", name="update_participant_route")
     */

     public function updateParticipantAction($id){

     	return $this->render("pages/update.html.twig");                 //calling the view

     }          


	 /**
     * @Route("/participant/show/{id}", name="show_participant_route")
     */

     public function showParticipantAction($id){

     	return $this->render("pages/view.html.twig");                 //calling the view

     }


	 /**
     * @Route("/participant/delete/{id}", name="delete_participant_route")
     */

     public function deleteParticipantAction($id){
     	$em = $this->getDoctrine()->getManager();
     	$participant = $em->getRepository('AppBundle:Participant')->find($id);
     	$em->remove($participant);
     	$em->flush();
     	$this->addFlash('message', 'Participant supprimé avec succes');

     	return $this->redirectToRoute("view_participant_route");                 //calling the view

     }

}