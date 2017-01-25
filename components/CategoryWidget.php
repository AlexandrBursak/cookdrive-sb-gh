<?php

namespace app\components;

use yii\base\Widget;
use app\models\Product;
use Yii;

class CategoryWidget extends Widget {
	public $tpl;
	public $data;
	public $categoryHtml;

	public function init(){
		parent::init();
		if ($this->tpl === null) {
			$this->tpl = 'category';
		}
		$this->tpl .= '.php';
	} 

	public function run (){

		// $category = Yii::$app->cache->get('category');
		// if($category) return $category;

		$this->data = Product::find()->asArray()->select('category')->distinct()->all();
		$this->categoryHtml = $this->getCategoryHtml($this->data);

		// Yii::$app->cache->set('category', $this->categoryHtml, 60);
		return $this->categoryHtml;
	} 

	public function getCategoryHtml ($data){
		$str = '';
		foreach ($data as $category) {
			$str .= $this->catToTemplate($category);
		}
		return $str;
	}

	protected function catToTemplate($category){
		ob_start();
		include __DIR__ . '/category_tpl/' . $this->tpl;
		return ob_get_clean();
	}

}