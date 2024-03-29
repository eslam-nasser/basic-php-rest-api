<?php
    class Post{
        // DB stuff
        private $conn;
        private $table = 'posts';
        

        // Post props
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // Constructor with db
        public function __construct($db){
            $this->conn = $db;
        }

        // Get all posts
        public function read(){
            // create query
            $query = 'SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM ' . $this->table . ' p
                LEFT JOIN
                    categories c ON p.category_id = c.id
                ORDER BY
                    p.created_at DESC';

            // prepare statment
            $stmt = $this->conn->prepare($query);

            // run query
            $stmt->execute();

            return $stmt;
        }

        // Get single post
        public function read_single(){
            // create query
            $query = 'SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM ' . $this->table . ' p
                LEFT JOIN
                    categories c ON p.category_id = c.id
                WHERE  p.id = ?
                LIMIT 0,1
            ';

            // prepare statment
            $stmt = $this->conn->prepare($query);

            // Bind id 
            $stmt->bindParam(1, $this->id);

            // run query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set props
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }

        // create post
        public function create(){
            $query = 'INSERT INTO '. $this->table . '
                SET 
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
            ';

            // prepare statment
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data 
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            // run query
            if($stmt->execute()){
                return true;
            }else{
                printf('Error: %s.\n', $stmt->error);
                return false;
            }
        }

        // update post
        public function update(){
            $query = 'UPDATE '. $this->table . '
                SET 
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
                WHERE id = :id
            ';

            // prepare statment
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data 
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);

            // run query
            if($stmt->execute()){
                return true;
            }else{
                printf('Error: %s.\n', $stmt->error);
                return false;
            }
        }

        // delete single post
        public function delete(){
            // create query
            $query = 'DELETE FROM '.$this->table. ' WHERE id = :id';

            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':id', $this->id);
            // run query
            if($stmt->execute()){
                return true;
            }else{
                printf('Error: %s.\n', $stmt->error);
                return false;
            }


        }
    }