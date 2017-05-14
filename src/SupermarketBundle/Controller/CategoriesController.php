<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 13/05/17
 * Time: 16:04
 */

namespace SupermarketBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends Controller {

	public function drawAction() {
		$api  = $this->container->get( 'supermarket.api' );
		$data = $api->getSubMenu();


		return $this->render( 'SupermarketBundle:Categories:header.html.twig', array(
			'categories' => $data,
		) );
	}

	public function sideAction() {
		$api  = $this->container->get( 'supermarket.api' );
		$data = $api->getSubMenu();


		return $this->render( 'SupermarketBundle:Categories:side.html.twig', array(
			'categories' => $data,
		) );
	}

	public function footerAction() {
		$api  = $this->container->get( 'supermarket.api' );
		$data = $api->getSubMenu();


		return $this->render( 'SupermarketBundle:Categories:footer.html.twig', array(
			'categories' => $data,
		) );
	}
}