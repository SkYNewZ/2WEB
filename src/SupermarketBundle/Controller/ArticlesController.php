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

	public function searchAction(Request $request){
		$api = $this->container->get( 'supermarket.api' );
		$results = $api->searchProducts(
			$request->query->get('search_query'),
			$request->query->get('page'),
			$request->query->get('size')
		);
		return $this->render( 'SupermarketBundle:Default:search.html.twig', array(
			'articles' => $results,
		));
	}

}