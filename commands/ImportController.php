<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\Product;

/**
 * This command parses cookdrive.com.ua and imports items into the data base. It must be run every day in the morning to keep foods and prices up-to-date
 *
 *
 *
 */

date_default_timezone_set('Europe/Kiev');
class ImportController extends Controller
{

// insert into database
    private function importItem($item, $categoryName) {

        $product = new Product();
        $product->product_name = $item['product_name'];
        $product->description=$item["description"];
        $product->weight=$item["weight"];
        $product->price=$item["price"];
        $product->photo_url=$item["photo_url"];
        $product->date_add=date("Y:m:d");
        $product->category=$categoryName;
        $product->sub_category=$item["subcategory"];
        $product->save();

    }

    private function importSet($set, $categoryName) {

        if (is_array($set)) {
            foreach ($set as $category) {
                    $this->importItem($category, $categoryName);
            }
        }
    }

    private function importFile(){
        // Start the parser here
        $commandPath = \Yii::getAlias('@app') . "/commands/";
        $output = array();
        $return_var = false;
        echo exec("php " . $commandPath . "index.php", $output, $return_var);
        if ($return_var == 0) {
        $fileJSON = fopen('output.json', 'r');
        $contents = fread($fileJSON, filesize('output.json'));
        $sets_json = json_decode($contents, JSON_UNESCAPED_UNICODE);
        if ($fileJSON && $contents) {
            if (!empty($sets_json)) {
                $this->deleteData();

                foreach ($sets_json as $key => $set) {
                    if (isset($set)) {

                        $this->importSet($set, $key);
                    }
                }

            }
        }
    }
    }

    private function deleteData(){
        Product::deleteAll();
    }

    public function actionIndex()
    {
        // This is the entry point of the import command
        $this->importFile();
    }
}
