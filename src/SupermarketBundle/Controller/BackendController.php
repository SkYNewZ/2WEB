<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 15/05/17
 * Time: 16:11
 */

namespace SupermarketBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BackendController extends Controller {

	public function indexAction(){
		return $this->render('SupermarketBundle:Admin:index.html.twig');
	}

	public function getUserAction(){
		$em = $this->getDoctrine()->getManager();
		$users = $em->getRepository('SupermarketBundle:User')->findAll();
		return $this->render('SupermarketBundle:Admin:user.html.twig', array(
			'number' => count($users),
		));
	}

	public function getAction($route, $key){
		$em = $this->getDoctrine()->getManager();
		$receipts = $em->getRepository('SupermarketBundle:Receipts')->findBy(array('validate' => $key));
		return $this->render($route, array(
			'receipts' => $receipts,
		));
	}

	public function getAllAction(){
		$em = $this->getDoctrine()->getManager();
		$receipts = $em->getRepository('SupermarketBundle:Receipts')->findAll();
		foreach ($receipts as $receipt){
			$receipt->setContent(json_decode($receipt->getContent()));
		}
		return $this->render('SupermarketBundle:Admin:receipts.html.twig', array(
			'receipts' => $receipts,
		));
	}

	public function getCountAllAction(){
		$em = $this->getDoctrine()->getManager();
		$receipts = $em->getRepository('SupermarketBundle:Receipts')->findAll();
		return $this->render('SupermarketBundle:Admin:all.html.twig', array(
			'number' => count($receipts),
		));
	}

	public function validAction(Request $request){
		$id = $request->query->get('id');
		$em = $this->getDoctrine()->getManager();
		$receipt = $em->getRepository('SupermarketBundle:Receipts')->find($id);
		$receipt->setValidate(1);
		$em->flush();
		return $this->redirectToRoute('backend');
	}

	public function searchUserAction(Request $request){
		$name = $request->query->get('query');
		$em = $this->getDoctrine()->getManager();

		$RAW_QUERY = "SELECT * FROM user WHERE 
						username LIKE '%".$name."%'
						OR last_name LIKE '%".$name."%'
						OR first_name LIKE '%".$name."%'
						OR email LIKE '%".$name."%'
						OR id LIKE '%".$name."%'
						OR billing LIKE '%".$name."%'
						OR delivery LIKE '%".$name."%'
						OR roles LIKE '%".$name."%'
						;";
		$statement = $em->getConnection()->prepare($RAW_QUERY);
		$statement->execute();
		return $this->render('SupermarketBundle:Admin:search_users.html.twig', array(
			'users' => $result = $statement->fetchAll(),
		));
	}

	public function searchReceiptAction(Request $request){
		$receipt = $request->query->get('query');
		$em = $this->getDoctrine()->getManager();

		$RAW_QUERY = "SELECT * FROM receipts WHERE 
						id LIKE '%".$receipt."%'
						OR user_id LIKE '%".$receipt."%'
						OR delivery LIKE '%".$receipt."%'
						OR billing LIKE '%".$receipt."%'
						OR content LIKE '%".$receipt."%'
						OR date LIKE '%".$receipt."%'
						;";
		$statement = $em->getConnection()->prepare($RAW_QUERY);
		$statement->execute();
		$receipts = $statement->fetchAll();
		foreach ($receipts as &$result){
			$result['content'] = json_decode($result['content']);
		}
		return $this->render('SupermarketBundle:Admin:search_receipt.html.twig', array(
			'receipts' => $receipts,
		));
	}

	public function listUsersAction(){
		$em = $this->getDoctrine()->getManager();
		$users = $em->getRepository('SupermarketBundle:User')->findAll();
		return $this->render('SupermarketBundle:Admin:list_users.html.twig', array(
			'users' => $users,
		));
	}

}