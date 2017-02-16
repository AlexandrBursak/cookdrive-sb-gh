<?php
/**
 * Created by PhpStorm.
 * User: zlemore
 * Date: 08.02.17
 * Time: 17:24
 */
require(__DIR__ . '/../vendor/autoload.php');
use Sunra\PhpSimple\HtmlDomParser;

//runtime/

//echo "beerlogaparser.php";

$filename = 'runtime/outputbeerloga.json';

//create or open file if exists
$file = fopen($filename, 'w');

//init service link
$SERVICE = 'http://beerlogapub.com.ua';

//open service's page
$html = HtmlDomParser::file_get_html($SERVICE) or die("Wrong service's URL.");
$c=0;
$productsArray = array();


foreach ($html->find('div.motopress-clmn div.bg') as $outter){
    $category = $outter->prev_sibling()->prev_sibling();
    $categoryName = trim($category->find('div.menu_padding h5 span', 0)->plaintext);
    $items = array();

    foreach ($outter->find('div.span4 div.svbox_price div.service-box_body') as $element) {

        $nameElement = trim(str_replace("\xe2\x80\xa9", '\\u2029', $element->find('h2.title', 0)->plaintext));
        $description = trim($element->find('div.service-box_txt', 0)->plaintext, '.');
        $price = trim($element->find('h5.sub-title', 0)->plaintext);
        $link = hash("md5", $nameElement.$description.$price.$categoryName);
    if (!empty(trim($nameElement))) {
        $items[] = array(
            'product_name' => $nameElement,
            'description' => $description,
            'price' => $price,
            'link'=>$link,
        );
    }
}

 $productsArray[$categoryName] = $items;

}
fwrite($file, json_encode($productsArray, JSON_UNESCAPED_UNICODE));
fclose($file);
?>