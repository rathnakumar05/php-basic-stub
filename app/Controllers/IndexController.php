<?php
namespace App\Controllers;

use Exception;

class IndexController{
    public function indexAction(){
        return view("index/index");
    }
}

?>