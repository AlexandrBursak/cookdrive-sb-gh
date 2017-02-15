<?php
/**
 * Created by PhpStorm.
 * User: zlemore
 * Date: 08.02.17
 * Time: 17:22
 */

namespace app\commands;


use yii\console\Controller;
use app\models\Product;
use yii\db\Query;
use app\models\Service;

date_default_timezone_set('Europe/Kiev');

class BeerlogaController extends Controller
{
    private function importItem($item, $categoryName)
    {

        $str = hash("md5", $item['product_name'] . $item["description"] . $item["price"] . $categoryName);

        $product = Product::find()->where(['link' => $str])
           ->one();
            if (!isset($product))
                $product = new Product();

        $product->product_name = $item['product_name'];
        $product->description = $item["description"];
        $product->price = $item["price"];
        $product->date_add = date("Y:m:d");
        $product->category = $categoryName;
        $service = ((new Query())->select('id')
            ->from('service')
            ->where(['link' => 'http://beerlogapub.com.ua'])
            ->one());
        if (empty($service["id"])) {
            $serviceinsert = new Service();
            $serviceinsert->name = "Beerloga";
            $serviceinsert->link = "http://beerlogapub.com.ua";
            $serviceinsert->save();
        }
        $service = ((new Query())->select('id')
            ->from('service')
            ->where(['link' => 'http://beerlogapub.com.ua'])
            ->one());
        $product->serv_id = $service["id"];
        $product->save();

    }

    private function importSet($set, $categoryName)
    {

        if (is_array($set)) {
            foreach ($set as $category) {
                $this->importItem($category, $categoryName);
            }
        }
    }

    private function importFile()
    {
        // Start the parser here
        $commandPath = \Yii::getAlias('@app') . "/commands/";
        $filepath = \Yii::getAlias('@app') . "/runtime/";
        $output = array();
        $return_var = false;
        echo exec("php " . $commandPath . "beerlogaparser.php", $output, $return_var);
        if ($return_var == 0) {
            $fileJSON = fopen($filepath . "outputbeerloga.json", 'r');
            $contents = fread($fileJSON, filesize($filepath . 'outputbeerloga.json'));
            $sets_json = json_decode($contents, JSON_UNESCAPED_UNICODE);
            if ($fileJSON && $contents) {
                if (!empty($sets_json)) {
                    //  $this->deleteData();

                    foreach ($sets_json as $category => $set) {
                        if (isset($set)) {

                            $this->importSet($set, $category);
                        }
                    }

                }
            }
        }
    }

    private function deleteData()
    {
        Product::deleteAll();
    }

    public function actionIndex()
    {
        // This is the entry point of the import command
        $this->importFile();
    }

}