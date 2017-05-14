<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 14/05/17
 * Time: 01:52
 */

namespace SupermarketBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrandsController extends Controller {

	public function drawAction(){
		$api  = $this->container->get( 'supermarket.api' );
		return $this->render('SupermarketBundle:Brands:draw.html.twig', array(
			'brands' => $api->getBrands(),
		));
	}

}