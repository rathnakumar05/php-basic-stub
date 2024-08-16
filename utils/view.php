<?php
use App\Exceptions\ViewException as ViewException;

function view($path, $data=[]){
    $view_path = __DIR__ . '/../app/Views/'  .$path. '.php';
    if (file_exists($view_path)) {
        extract($data);
        include($view_path);
    } else {
        throw new ViewException("View file not found: $view_path");
    }
}

?>