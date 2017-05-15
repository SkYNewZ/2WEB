<?php

namespace SupermarketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction() {
		return $this->render( 'SupermarketBundle:Default:index.html.twig' );
	}

	/**
	 * TODO: Contact form
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function contactAction() {
		return $this->render( 'SupermarketBundle:Default:contact.html.twig' );
	}
}
