<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 15/05/17
 * Time: 01:18
 */

namespace SupermarketBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends Controller {

	/**
	 * Add article to cart
	 *
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @internal param $article
	 *
	 * @internal param Request $request
	 */
	public function addAction( Request $request ) {
		$session = new Session();
		if ( $session->get( 'product' ) !== null ) {
			$array = $session->get( 'product' );
			var_dump($array);
			$add = true;
			foreach ($array as &$key){
				if ($key['id'] == $request->request->get('id')){
					$key['quantity'] += 1;
					$add = false;
					var_dump($key);
				}
			}
			$session->set( 'product', $array );
			var_dump($array);
			if ($add){
				array_push( $array, $request->request->all() );
				$session->set( 'product', $array );
				die();
			}
		} else {
			$session->set( 'product', array( $request->request->all() ) );
		}
		return $this->redirectToRoute( 'checkout' );
	}

	public function deleteAction( $id ) {
		$session = new Session();
		$array   = $session->get( 'product' );
		if ( ! empty( $array ) ) {
			foreach ( $array as $k => $c ) {
				if ( $c['id'] == $id ) {
					unset( $array[ $k ] );
					break;
				}
			}
		}
		$session->set( 'product', $array );
		return $this->redirectToRoute( 'checkout' );
	}

	public function updateAction($id, $number) {
		$session = new Session();
		$array   = $session->get( 'product' );
		if ( ! empty( $array ) ) {
			foreach ( $array as $k => &$c ) {
				if ( $c['id'] == $id ) {
					$c['quantity'] += $number;
					break;
				}
			}
		}
		$session->set( 'product', $array );
		return $this->redirectToRoute( 'checkout' );
	}

	/**
	 * Display cart
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewAction() {
		$session  = new Session();
		/*$session->clear();*/
		$products = $session->get( 'product' );
		$api      = $this->container->get( 'supermarket.api' );
		$articles = array();
		if ($session->get( 'product' ) != null){
			foreach ( $products as $prod ) {
				array_push( $articles, $api->getOneArticle( $prod['id'] ) );
			}
			for ( $i = 0; $i < count( $articles ); $i ++ ) {
				$articles[ $i ]->season = $products[ $i ]['quantity'];
			}
		}

		return $this->render( 'SupermarketBundle:Default:checkout.html.twig', array(
			'articles' => $articles,
		) );
	}

}