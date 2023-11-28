<?php
class Blog{
    public static function handlerAddArticle(){
        global $mysqli;
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_POST['author'];
        $mysqli->query("INSERT INTO articles (title, content, author) VALUES ('$title', '$content', '$author')");
        header("Location: /blog.php");
    }
    public static function getArticleById($articleId){
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM articles WHERE id = '$articleId '");
        return json_encode($result->fetch_assoc());
    }
    public static function getArticles(){
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM articles"); // Запрос к БД
        $articles = []; // Пустой массив
        while (($row = $result->fetch_assoc()) != null){ // Перебираем статьи из БД
            $articles[] = $row; // Сохраняем статьи (по одной) в массив
        }
        return json_encode($articles); // Отправляем результат клиенту

        // ['title'=>'Заголовок1', 'author'=>'Ivan'] -> {'title':'Заголовок1', 'author':'Ivan'}
    }
}
