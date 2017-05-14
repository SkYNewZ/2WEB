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

	public function __construct($client)
	{
		$this->client = $client;
	}


	private function getHTTP($url, $params){
		try {
			return json_decode($this->client
				->get("$url?".http_build_query($params))
				->getContent());
		} catch (Circle\RestClientBundle\Exceptions\CurlException $exception) {
			throw new \Exception('Error with the API');
		}
	}

	public function getMenu(){
		$catalogue = $this->getHTTP(
			'https://api.zalando.com/categories', array(
				'key' => 'homme,femme,enfant,maison',
				'pageSize' => '20000'
			));
		return $catalogue;
	}

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

	public function getArticlesList($category){
		$articles = $this->getHTTP(
			'https://api.zalando.com/articles', array(
				'category' => $category,
		))->content;
		return $articles;
	}

	public function getBrands(){
		return $this->GetHTTP(
			'https://api.zalando.com/brands', array(
				'pageSize' => '18')
		)->content;
	}

	public function getOneArticle($id){
		return $this->GetHTTP('https://api.zalando.com/articles/'.$id, array());
	}

	public function getAllArticle(){
		return $this->GetHTTP('https://api.zalando.com/articles/', array(
				'pageSize' => '50')
		)->content;
	}

}