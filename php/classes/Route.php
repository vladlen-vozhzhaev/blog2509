<?php
class Route{
    public static function view($uri, $filePath){ // $_SERVER['REQUEST_URI'] = /blog/2 $uri = /blog/{id}
        $content = "";
        $paths =  explode('/', $_SERVER['REQUEST_URI']); // $path теперь массив
        // /foo/bar/baz -> ['', 'foo', 'bar', 'baz']
        // /login -> ['', 'login']
        // /getArticle/2 -> ['', 'getArticle', 2]
        if(count($paths)>2){
            $uri = explode('/', $uri)[1];
            $uri = '/'.$uri.'/'.$paths[2];
        }
        if($_SERVER['REQUEST_URI'] == $uri && $_SERVER['REQUEST_METHOD'] == 'GET'){
            $content = file_get_contents($filePath);
            require_once('template.php');
            exit();
        }
    }

    public static function get($uri, $handler){
        $paths =  explode('/', $_SERVER['REQUEST_URI']); // $path теперь массив
        // /foo/bar/baz -> ['', 'foo', 'bar', 'baz']
        // /login -> ['', 'login']
        // /getArticle/2 -> ['', 'getArticle', 2]
        if(count($paths)>2){
            $uri = explode('/', $uri)[1];
            $uri = '/'.$uri.'/'.$paths[2];
        }
        if($_SERVER['REQUEST_URI'] == $uri && $_SERVER['REQUEST_METHOD'] == 'GET'){
            exit($handler());
        }
    }
    public static function post($uri, $handler){
        if($_SERVER['REQUEST_URI'] == $uri && $_SERVER['REQUEST_METHOD'] == 'POST'){
            exit($handler());
        }
    }

    /*
    $result = [];
        preg_match("/\{(\w+)\}/u", $uri, $result);
        $param = $result[1];
        if($param){
            $param
        }
    */
}