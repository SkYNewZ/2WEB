<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 14/05/17
 * Time: 01:30
 */

namespace SupermarketBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends Controller {

	public function showAction( $name, $page = 1, $size = 25, Request $request ) {

		if ( $request->query->get( 'page' ) !== null ) {
			$page = $request->query->get( 'page' );
		}

		if ( $request->query->get( 'size' ) !== null ) {
			$size = $request->query->get( 'size' );
		}

		$api = $this->container->get( 'supermarket.api' );

		return $this->render( 'SupermarketBundle:Default:articles.html.twig', array(
			'articles' => $api->getArticlesList( $name, $page, $size ),
		) );
	}

	public function singleAction( $id ) {
		$api = $this->container->get( 'supermarket.api' );

		return $this->render( 'SupermarketBundle:Default:single.html.twig', array(
			'article' => $api->getOneArticle( $id ),
		) );
	}

	public function allProductsAction( $page = 1, $size = 25, Request $request ) {

		if ( $request->query->get( 'page' ) !== null ) {
			$page = $request->query->get( 'page' );
		}

		if ( $request->query->get( 'size' ) !== null ) {
			$size = $request->query->get( 'size' );
		}
		$api = $this->container->get( 'supermarket.api' );

		return $this->render( 'SupermarketBundle:Default:all.html.twig', array(
			'articles' => $api->getAllArticle( $page, $size ),
		) );
	}

}