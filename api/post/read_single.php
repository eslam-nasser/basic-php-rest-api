<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Init db
    $databse = new Database();
    $connection = $databse->connect();

    // init Post object
    $post = new Post($connection);

    // Get Id from params
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    $post->read_single();

    // create array
    $post_arr = array(
        'id' => $post->id,
        'title' => $post->title,
        'body' => html_entity_decode($post->body),
        'author' => $post->author,
        'category' => array(
            'category_name' => $post->category_name,
            'category_id' => $post->category_id,
        )
    );

    echo json_encode($post_arr);

