<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 15/05/17
 * Time: 01:18
 */

namespace SupermarketBundle\Controller;


use SupermarketBundle\Entity\Receipts;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
			$add = true;
			foreach ($array as &$key){
				if ($key['id'] == $request->request->get('id')){
					$key['quantity'] += 1;
					$add = false;
				}
			}
			$session->set( 'product', $array );
			if ($add){
				array_push( $array, $request->request->all() );
				$session->set( 'product', $array );
				die();
			}
		} else {
			$session->set( 'product', array( $request->request->all() ) );
		}
		$response = new Response();
		$response->setContent(json_encode(array(
			'cart' => $session->get('product'),
		)));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	public function deleteAction( $id ) {
		$session = new Session();
		$array   = $session->get( 'product' );
		if ( ! empty( $array ) ) {
			foreach ( $array as $k => $c ) {
				if ( $c['id'] == $id ) {
					unset( $array[ $k ] );
					$array = array_values($array);
					break;
				}
			}
		}
		$session->set( 'product', $array );
		$response = new Response();
		$response->setContent(json_encode(array(
			'cart' => $session->get('product'),
		)));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	public function updateAction($id, $number) {
		$session = new Session();
		$array   = $session->get( 'product' );
		if ( ! empty( $array ) ) {
			foreach ( $array as $k => &$c ) {
				if ( $c['id'] == $id ) {
					$c['quantity'] += $number;
					$new_quantity = $c['quantity'];
					if ($new_quantity == 0){
						unset($array[$k]);
						$array = array_values($array);
					}
					break;
				}
			}
		}
		$session->set( 'product', $array );
		$response = new Response();
		$response->setContent(json_encode(array(
			'new_quantity' => $new_quantity,
		)));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
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

	public function payAction(){
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
		return $this->render('SupermarketBundle:Default:pay.html.twig', array(
			'articles' => $articles,
		));
	}

	public function confirmAction(){
		$session  = new Session();
		$products = $session->get( 'product' );
		if (isset($products)){
			$api      = $this->container->get( 'supermarket.api' );
			$articles = array();
			$total = 0;
			if ($session->get( 'product' ) != null){
				foreach ( $products as $prod ) {
					array_push( $articles, $api->getOneArticle( $prod['id'] ) );
					$total += $api->getOneArticle($prod['id'])->units[0]->price->value;
				}
				for ( $i = 0; $i < count( $articles ); $i ++ ) {
					$articles[ $i ]->season = $products[ $i ]['quantity'];
				}
			}
			$receipt = new Receipts();
			$receipt->setDate(time());
			$receipt->setValidate(0);
			$receipt->setTotal($total);
			$receipt->setUserId($this->getUser()->getId());
			$receipt->setBilling($this->getUser()->getBilling());
			$receipt->setDelivery($this->getUser()->getDelivery());
			$receipt->setContent(json_encode($articles));
			$em    = $this->getDoctrine()->getManager();
			$em->persist( $receipt);
			$em->flush();
			$session->clear();
		}
		return $this->render('SupermarketBundle:Default:confirm.html.twig');
	}

}