<?php
class Blog{
    public static function handlerAddArticle(){
        global $mysqli;
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_POST['author'];
        $html = new simple_html_dom();
        $html->load($content);
        $img = $html->getElementByTagName('img');
        $meta = explode(',', $img->src)[0];
        $base64 = explode(',',$img->src)[1]; // это надо будет сохранить в файл
        $extension = explode(';', explode('/', $meta)[1])[0];
        $fileName = "img/blog/".microtime().".".$extension;
        $ifp = fopen($fileName, 'wb');
        fwrite($ifp, base64_decode($base64));
        fclose($ifp);
        $img->src = "/".$fileName;
        $content = $html->save();
        $mysqli->query("INSERT INTO articles (title, content, author) VALUES ('$title', '$content', '$author')");
        return json_encode(['result'=>'success']);
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
