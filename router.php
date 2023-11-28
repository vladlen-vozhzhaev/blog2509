<?php
session_start();
$path =  explode('/', $_SERVER['REQUEST_URI']); // $path теперь массив
// /foo/bar/baz -> ['', 'foo', 'bar', 'baz']
// /login -> ['', 'login']
// /getArticle/2 -> ['', 'getArticle', 2]
$mysqli = new mysqli("127.0.0.1", "root", "", "blog2509");
require_once('php/classes/User.php');
require_once('php/classes/Blog.php');
require_once('php/classes/Route.php');

Route::view('/', 'views/mainPage.html');

Route::view('/blog/{id}', 'views/article.html');

Route::get('/getArticle/{id}', function (){return Blog::getArticleById(1);});
Route::get('/getArticles', function (){return Blog::getArticles();});
Route::get('/getUserData', function (){return User::getUserData();});
Route::get('/logout', function (){return User::logout();});

if(!empty($_SESSION['id'])){
    Route::view('/profile', "views/profile.html");
    Route::view('/addArticle', 'views/addArticle.html');
    Route::get('/login', function (){return header("Location: /profile");});
    Route::get('/reg', function (){return header("Location: /profile");});
    Route::post('/handlerAddArticle', function (){return Blog::handlerAddArticle();});
    Route::post('/changeAvatar', function (){return User::changeUserAvatar();});
}else{
    Route::view('/reg', "views/reg.html");
    Route::view('/login', "views/login.html");
    Route::post('/reg', function (){return User::handlerReg();});
    Route::post('/login', function (){return User::login();});
    header("Location: /login");
}