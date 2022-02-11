<?php

// Подключение к СУБД
$db_connect= new mysqli('127.0.0.1', 'usr2022','1');

// Создание базы данных
$db_connect-> query('CREATE DATABASE IF NOT EXISTS InLineTest');

// Выбор базы данных
$db_connect-> query('USE InLineTest');

// Создание таблицы записей
$db_connect-> query('CREATE TABLE IF NOT EXISTS posts (userId INT,	
                                                       id INT PRIMARY KEY AUTO_INCREMENT, 
                                                       title CHAR (100), 
                                                       body TINYTEXT)');
// Создание таблицы комментариев
$db_connect-> query('CREATE TABLE IF NOT EXISTS comments (postId INT, 
	                                                      id INT PRIMARY KEY AUTO_INCREMENT,
	                                                      name CHAR (100),
	                                                      email CHAR (50),
	                                                      body TINYTEXT)');

// Получаем массивы строк
$posts = file_get_contents("https://jsonplaceholder.typicode.com/posts");
$comments = file_get_contents("https://jsonplaceholder.typicode.com/comments");

// Нарезаем строки по значениям
preg_match_all('~\{(.+)\}~sU', $posts, $arr_posts, PREG_PATTERN_ORDER);
preg_match_all('~\{(.+)\}~sU', $comments, $arr_comments, PREG_PATTERN_ORDER);

$p_count=0;
$c_count=0;

// Заполняем таблицу сообщений
foreach ($arr_posts[1] as $i) {
    $res = explode(',', preg_replace('~".+":~', "", $i)); //Получаем готовый набор значений
    try {
        $db_connect-> query("INSERT posts (userId, id, title, body) VALUES ($res[0], $res[1], $res[2], $res[3])"); //Добавлям значения в таблицу
        $p_count++;
    } catch (Exception $e) {
        echo "Ошибка MySQL: $db_connect->error\n";
    }

}

// Заполняем таблицу комментариев
foreach ($arr_comments[1] as $i) {
    $res = explode(',', preg_replace('~".+":~', "", $i));
    try {
        $db_connect-> query("INSERT comments (postId, id, name, email, body) VALUES ($res[0], $res[1], $res[2], $res[3], $res[4])");
        $c_count++;
    } catch (Exception $e) {
        echo "Ошибка MySQL: $db_connect->error\n";
    }

}

echo "Добавлено $p_count сообщений и $c_count комментариев!";
