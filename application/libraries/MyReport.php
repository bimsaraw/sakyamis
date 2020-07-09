<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\codeigniter\Friendship;// All you need to do is to claim this friendship

    function setup()
    {
        //Now you can access database that you configured in codeigniter
        $this->src("sale_database")
        ->query("select * from orders")
        ->pipe($this->dataStore("orders"));
    }
}
