<?php
require_once "$dir/core/DB.php";

class Comment
{
    private $db = null;

    public function __construct()
    {
        $this->db = DB::open();
    }

    public function getAllComments()
    {
        try {
            $comments = [];
            $sql = "SELECT * FROM comments WHERE delete_flg = '0'";
            $sth = $this->db->query($sql);
            $comments = $sth->fetchAll();
            return $comments;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function createComment($data)
    {
        try {

            $current_timestamp = date('Y-m-d h:i:s');

            $this->db->beginTransaction();

            $sql = "INSERT INTO comments (comment_name, comment_body, created_at, update_at) VALUES (?, ?, ?, ?)";
            $sth = $this->db->prepare($sql);
            $sth->execute(array($data['comment_name'], $data['comment_body'], $current_timestamp, $current_timestamp));
            $comment_id = $this->db->lastInsertId();

            $this->db->commit();
            return $comment_id;

        } catch (\Throwable $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function updateComment($data)
    {
        try {

            $this->db->beginTransaction();

            $sql = "UPDATE comments SET comment_name=?, comment_body=?, update_at=? WHERE comment_id=?";
            $sth = $this->db->prepare($sql);
            $sth->execute(array($data['comment_name'], $data['comment_body'], $data['timestamp'], $data['comment_id']));

            $this->db->commit();

            return true;
        } catch (\Throwable $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function deleteComment($data)
    {
        try {

            $this->db->beginTransaction();

            $sql = "UPDATE comments SET delete_flg='1',update_at=?  WHERE comment_id=?";
            $sth = $this->db->prepare($sql);
            $sth->execute(array($data['timestamp'], $data['comment_id']));

            $this->db->commit();

            return true;

        } catch (\Throwable $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function validateData($data)
    {
        if (!isset($data['comment_name']) || $data['comment_name'] == '')
            return "Name is required.";

        if (mb_strlen($data['comment_name']) > 50)
            return "Name can only enter a maximum of 50 characters";

        return true;
    }

    public function validatePermission()
    {
        if (!isset($_SESSION['login_user']) || $_SESSION['login_user'] == '')
            return false;
        return true;
    }
}