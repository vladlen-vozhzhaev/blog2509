<?php
class User{
    public static function handlerReg(){
        global $mysqli;
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
        if($result->num_rows){
            return json_encode(["result"=>"exist"]);
        }else{
            $mysqli->query("INSERT INTO `users`(`name`, `lastname`, `email`, `pass`) VALUES ('$name','$lastname','$email','$pass')");
            return json_encode(["result"=>"success"]);
        }
    }
    public static function login(){
        global $mysqli;
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
        $row = $result->fetch_assoc(); // Преобразуем ответ от БД в массив, где ключи массива = названиям столбцов
        if(password_verify($pass, $row['pass'])){
            $_SESSION['name'] = $row['name'];
            $_SESSION['lastname'] = $row['lastname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['img'] = $row['img'];
            $_SESSION['id'] = $row['id'];
            return json_encode(["result"=>'success']);
        }else{
            return json_encode(['result'=>'error']);
        }
    }
    public static function getUserData(){
        return json_encode($_SESSION);
    }
    public static function logout(){
        session_destroy();
        header("Location: /");
    }
    public static function changeUserAvatar(){
        global $mysqli;
        $userId = $_SESSION['id'];
        $img = $_FILES['avatar'];
        $extension = explode('/', $img['type'])[1];
        $fileName = time().'.'.explode('/', $img['type'])[1];
        if($extension == 'jpeg' || $extension=='png'){
            $uploadDir = 'img/'.$fileName;
            move_uploaded_file($img['tmp_name'], $uploadDir);
            $mysqli->query("UPDATE users SET img='/$uploadDir' WHERE id='$userId'");
            $_SESSION['img'] = "/$uploadDir";
            header("Location: /profile");
        }else{
            echo "Недопустимый формат файла";
        }
    }
}
