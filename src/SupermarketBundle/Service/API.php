<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 13/05/17
 * Time: 17:42
 */

namespace SupermarketBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class API extends Controller{

	protected $client;

	/**
	 * API constructor.
	 *
	 * @param $client
	 */
	public function __construct($client)
	{
		$this->client = $client;
	}


	/**
	 * Do request
	 * @param $url
	 * @param $params
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	private function getHTTP($url, $params){
		try {
			return json_decode($this->client
				->get("$url?".http_build_query($params))
				->getContent());
		} catch (Circle\RestClientBundle\Exceptions\CurlException $exception) {
			throw new \Exception('Error with the API');
		}
	}

	/**
	 * Get menu categories
	 * @return mixed
	 */
	public function getMenu(){
		$catalogue = $this->getHTTP(
			'https://api.zalando.com/categories', array(
				'key' => 'homme,femme,enfant,maison',
				'pageSize' => '20000'
			));
		return $catalogue;
	}

	/**
	 * Get sub menu categories + menu
	 * @return mixed
	 */
	public function getSubMenu(){
		$catalogue = $this->getMenu()->content;
		foreach($catalogue as $first){
			$noms_sub_menu = $this->GetHTTP(
				'https://api.zalando.com/categories', array(
					'key' => implode(",", $first->childKeys),
					'pageSize' => '20000')
			)->content;
			for ($i = 0; $i < count($first->childKeys); $i++){
				$first->childKeys[$noms_sub_menu[$i]->key] = $first->childKeys[$i];
				$first->childKeys[$noms_sub_menu[$i]->key] = $noms_sub_menu[$i]->name;
				unset($first->childKeys[$i]);
			}
		}
		return $catalogue;
	}

	/**
	 * Get article list by category
	 * @param $category
	 * @param $page
	 * @param $size
	 *
	 * @return mixed
	 */
	public function getArticlesList($category, $page, $size){
		$articles = $this->getHTTP(
			'https://api.zalando.com/articles', array(
				'category' => $category,
				'pageSize' => $size,
				'page' => $page,
		))->content;
		return $articles;
	}

	/**
	 * Get brands
	 * @return mixed
	 */
	public function getBrands(){
		return $this->GetHTTP(
			'https://api.zalando.com/brands', array(
				'pageSize' => '18')
		)->content;
	}

	/**
	 * Get one product
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getOneArticle($id){
		return $this->GetHTTP('https://api.zalando.com/articles/'.$id, array());
	}

	/**
	 * Get all article
	 * @param $page
	 * @param $size
	 *
	 * @return mixed
	 */
	public function getAllArticle($page, $size){
		return $this->GetHTTP('https://api.zalando.com/articles/', array(
			'pageSize' => $size,
			'page' => $page,
			)
		)->content;
	}

	public function searchProducts($search, $page = 1, $size = 25){
		return $this->getHTTP('https://api.zalando.com/articles/', array(
			'fullText' => $search,
			'pageSize' => $size,
			'page' => $page
		))->content;

	}

}