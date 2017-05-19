<?php

namespace SupermarketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction() {
		$api  = $this->container->get( 'supermarket.api' );
		$mens = $api->getMen();
		$womens = $api->getWomen();
		return $this->render( 'SupermarketBundle:Default:index.html.twig', array(
			'mens' => $mens,
			'womens' => $womens,
		) );
	}

	/**
	 * TODO: Contact form
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function contactAction() {
		return $this->render( 'SupermarketBundle:Default:contact.html.twig' );
	}

	public function historyAction(){
		$em    = $this->getDoctrine()->getManager();
		$receipts = $em->getRepository( 'SupermarketBundle:Receipts' )->findBy(array('userId' => $this->getUser()->getId()));
		foreach ($receipts as $receipt){
			$receipt->setContent(json_decode($receipt->getContent()));
		}
		return $this->render('SupermarketBundle:Default:history.html.twig', array(
			'receipts' => array_reverse($receipts),
		));
	}
}
