<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 14/05/17
 * Time: 01:30
 */

namespace SupermarketBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticlesController extends Controller {

	public function showAction($name){
		$api  = $this->container->get( 'supermarket.api' );
		return $this->render('SupermarketBundle:Default:articles.html.twig', array(
			'articles' => $api->getArticlesList($name),
			'name' => $name,
		));
	}

	public function singleAction($id){
		$api  = $this->container->get( 'supermarket.api' );
		return $this->render('SupermarketBundle:Default:single.html.twig', array(
			'article' => $api->getOneArticle($id),
		));
	}

	public function allProductsAction(){
		$api  = $this->container->get( 'supermarket.api' );
		return $this->render('SupermarketBundle:Default:all.html.twig', array(
			'articles' => $api->getAllArticle(),
		));
	}

}