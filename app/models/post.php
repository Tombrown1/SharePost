<?php
    class Post {
        private $db;    

    public  function __construct(){
        $this->db = new Database;
    }

    public function getPosts(){
        $this->db->query('SELECT *,
                          posts.post_id as postId,
                          users.id as usersId,
                          posts.created_at as postCreated,
                          users.created_at as userCreated 
                          FROM posts                          
                          INNER JOIN users
                          ON posts.user_id = users.id
                          ORDER BY posts.created_at DESC
                          ');
        $results = $this->db->resultSet();

        return $results;
    }
    public function addPost($data){
        $this->db->query('INSERT INTO posts (title, user_id, body) VALUES (:title, :user_id, :body)');
        // Bind Values
        $this->db->bind(':title',   $data['title']);
        $this->db->bind(':user_id',  $data['user_id']);
        $this->db->bind(':body',   $data['body']);

        // Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function updatePost($data){
        $this->db->query('UPDATE posts SET title = :title, body = :body WHERE post_id = :post_id');
        // Bind Values
        $this->db->bind(':post_id',  $data['post_id']);
        $this->db->bind(':title',   $data['title']);        
        $this->db->bind(':body',   $data['body']);

        // Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getPostById($id){
        $this->db->query('SELECT * FROM posts WHERE post_id = :post_id');

        $this->db->bind(':post_id', $id);

        $row = $this->db->single();
        return $row;
    }

    public function deletePost($id){
        $this->db->query('DELETE FROM posts WHERE post_id = :post_id');
         // Bind Values
        $this->db->bind(':post_id',  $id);
        // Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}
?>