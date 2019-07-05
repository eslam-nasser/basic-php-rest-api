<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
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

    // SET id to delete
    $post->id = $data->id;

    // delete post
    if($post->delete()){
        echo json_encode(array(
            'status' => true,
            'message' => 'Post deleted'
        ));
    }else{
        echo json_encode(array(
            'status' => false,
            'message' => 'Post not deleted'
        ));
    }