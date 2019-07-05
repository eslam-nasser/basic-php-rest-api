<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Init db
    $databse = new Database();
    $connection = $databse->connect();

    // init Post object
    $post = new Post($connection);

    // Get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    // create post
    if($post->create()){
        echo json_encode(array(
            'status' => true,
            'message' => 'Post created'
        ));
    }else{
        echo json_encode(array(
            'status' => false,
            'message' => 'Post not created'
        ));
    }