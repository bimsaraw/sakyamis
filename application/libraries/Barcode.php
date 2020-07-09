<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode {

public function generate($id) {
    require_once("./vendor/picqer/php-barcode-generator/src/BarcodeGeneratorHTML.php");
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    echo $generator->getBarcode($id, $generator::TYPE_CODE_128);
}

}

 ?>
