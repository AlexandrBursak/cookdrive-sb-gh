<?php
//parser library
require(__DIR__ . '/../vendor/autoload.php');
use Sunra\PhpSimple\HtmlDomParser;
$filename = 'runtime/output.json';
//create or open file if exists
    $file = fopen($filename, 'w');
//init service link
$SERVICE='http://cookdrive.com.ua';
//open service's page
$html = HtmlDomParser::file_get_html($SERVICE) or die("Wrong service's URL.");
$productsArray = array();
foreach ($html->find('a[data-category_id]') as $category){
    $link = $category->href;
    $categoryName = trim($category->plaintext);
    //open category's page
    $html = HtmlDomParser::file_get_html($SERVICE . $link) or die ("Category's url has changed.");
    $items = array();
    //find product
    foreach($html->find('section ul li') as $element) {

        if (($element->find('a div img'))){
            $linkElement =$SERVICE.$element->find('a',0)->href;
        }

        $nameElement = $element->find('a div.c__list-content h3.c__list-name', 0);

        if (!empty($nameElement)) {
            $items[] = array(
                'product_name' => !empty(trim($nameElement->plaintext)) ? $nameElement->plaintext : '',
                'subcategory' => trim($element->find('a div.c__list-product', 0)->plaintext),
                'weight' => !empty(trim($element->find('a div.c__list_short-details', 0)->plaintext))?
                    $element->find('a div.c__list_short-details', 0)->plaintext : '',
                'description' => trim($element->find('a div.c__list-desc', 0)->plaintext),
                'price' => !empty(trim((double)$element->find('a div.c__list-price', 0)->plaintext))?
                    (double)$element->find('a div.c__list-price', 0)->plaintext:'',
                'photo_url' => !empty(trim($SERVICE.$element->find('a img', 0)->src))?
                    $SERVICE.$element->find('a img', 0)->src :'',
                'link' => (trim($linkElement)),
                'product_id' => (integer)preg_replace('/[^0-9]/', '',$element->find('footer a.in-cart', 0)->outertext),  
            );
        }

    }

    $productsArray[$categoryName] = $items;
}
fwrite($file, json_encode($productsArray, JSON_UNESCAPED_UNICODE));
fclose($file);
?>
