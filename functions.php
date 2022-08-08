<?php
function getPosts($connect) {
    $posts = mysqli_query($connect, "SELECT * FROM posts");
    $postsList = [];

    while ($post = mysqli_fetch_assoc($posts)) {
        $postsList[] = $post;
    }
    echo json_encode($postsList);
}

function getPost($connect, $id) {
    $id = (int)$id;

    $post = mysqli_query($connect, "SELECT * FROM posts WHERE id = $id");
    $post = mysqli_fetch_assoc($post);

    if (!$post || !is_integer($id)) {
        http_response_code(404);

        $res = [
            "status" => false,
            "status-text" => "Not found",
        ];
        echo json_encode($res);
    } else {
        echo json_encode($post);
    }
}


function createPost($connect, $data) {
    $title = $data['title'];
    $body  = $data['body'];

    mysqli_query($connect, "INSERT INTO posts (id, title, body) VALUES (NULL, '$title', '$body')");
    http_response_code(201);

    $res = [
        "status" => true,
        "post_id" => mysqli_insert_id($connect),
    ];

    echo json_encode($res);
}


function updatePost($connect, $id, $data) {
    $data = json_decode($data, true);

    $id = (int)$id;
    $title = $data['title'];
    $body  = $data['body'];

    mysqli_query($connect, "UPDATE posts SET title = '$title', body = '$body' WHERE id = $id");
    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Post is updated",
    ];

    echo json_encode($res);
}


function deletePost($connect, $id) {
    $id = (int)$id;

    mysqli_query($connect, "DELETE FROM posts WHERE id = $id");
    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Post is deleted"
    ];

    echo json_encode($res);
}