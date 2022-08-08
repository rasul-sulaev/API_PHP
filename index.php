<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header("Content-type: application/json");

require_once "connect.php";
require_once "functions.php";

$method = $_SERVER['REQUEST_METHOD'];

$q = $_GET['q'];
$params = explode('/', $q);

$type = $params[0];
$id = isset($params[1]) && $params[1] !== "" ? $params[1] : null;


if ($method === 'GET') {
    if ($type === 'posts') {
        if (isset($id)) {
            getPost($connect, $id);
        } else {
            getPosts($connect);
        }
    }
} elseif ($method === 'POST') {
    if ($type === 'posts') {
        createPost($connect, $_POST);
    }
} elseif ($method === 'PUT') {
    $data = file_get_contents('php://input');

    if ($type === 'posts' && isset($id)) {
        updatePost($connect, $id, $data);
    }
} elseif ($method === 'DELETE') {
    if ($type === 'posts' && isset($id)) {
        deletePost($connect, $id);
    }
}