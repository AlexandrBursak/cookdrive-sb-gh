<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Service;
use phpDocumentor\Reflection\Types\Null_;
use Yii;
use yii\db\Query;
use yii\console\Controller;
use app\models\Product;
use app\models\ACategory;

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

        $product = Product::find()->where(['link' => $item['link']])
            ->one();

        if (empty($product)){
            $product = new Product();
        }

        //TODO: якщо продукт не знайдено по лінку, то створюємо новий,
        //TODO: якщо товар знайдено, але хеш-сумма не збігається, то оновлюємо товару всі поля,
        //TODO: якщо хеш-сума збігається, то оновлюємо дату

        $product->product_name = $item['product_name'];
        $product->description=$item["description"];
        $product->weight=$item["weight"];
        $product->price=$item["price"];
        $product->photo_url=$item["photo_url"];
        $product->date_add=date("Y:m:d");
        $product->category=$categoryName;
        $product->sub_category=$item["subcategory"];
        $service = ((new Query())->select('id')
            ->from('service')
            ->where(['link'=>'http://cookdrive.com.ua'])
            ->one());
        if (empty($service["id"])){
            $serviceinsert = new Service();
            $serviceinsert->name = "CookDrive";
            $serviceinsert->link = "http://cookdrive.com.ua";
            $serviceinsert->save();
        }
        $service = ((new Query())->select('id')
            ->from('service')
            ->where(['link'=>'http://cookdrive.com.ua'])
            ->one());
        $product->serv_id=$service["id"];
        $product->link = $item['link'];
        $product->product_id = $item['product_id'];
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
        $this->deleteData();
        $commandPath = \Yii::getAlias('@app') . "/commands/";
        $filepath=\Yii::getAlias('@app') ."/runtime/";
            $output = array();
        $return_var = false;
        echo exec("php " . $commandPath . "index.php", $output, $return_var);
        if ($return_var == 0) {
        $fileJSON = fopen("$filepath". "output.json", 'r');
        $contents = fread($fileJSON, filesize($filepath.'output.json'));
        $sets_json = json_decode($contents, JSON_UNESCAPED_UNICODE);
        if ($fileJSON && $contents) {
            if (!empty($sets_json)) {
              //  $this->deleteData();

                foreach ($sets_json as $category => $set) {
                    if (isset($set)) {
                        Yii::$app->db->createCommand()->insert('category', [
                            'name' => $category,
                        ])->execute();
                        $this->importSet($set, $category);
                    }
                }

            }
        }
    }
    }

    private function deleteData(){
        Product::deleteAll();
        ACategory::deleteAll();
    }

    public function actionIndex()
    {
        // This is the entry point of the import command
        $this->importFile();
    }
}
