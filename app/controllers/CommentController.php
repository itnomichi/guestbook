<?php
require_once "$dir/core/View.php";
require_once "$dir/app/models/Comment.php";

class CommentController
{
    public function create()
    {
        try {

            $data = [];
            $data['comment_name'] = $_POST['comment_name'];
            $data['comment_body'] = $_POST['comment_body'];
            $data['timestamp'] = date('Y-m-d h:i:s');

            $comment = new Comment();

            $validate = $comment->validateData($data);
            if ($validate !== true) {
                echo json_encode(['status' => false, 'message' => $validate]);
                exit();
            }

            $comment_id = $comment->createComment($data);
            if ($comment_id) {
                $data['status'] = true;
                $data['login'] = true;
                if (!(isset($_SESSION['login_user'])))
                    $data['login'] = false;
                $data['comment_id'] = $comment_id;
                $data['fm_comment_name'] = htmlentities($data['comment_name']);
                $data['fm_comment_body'] = nl2br(htmlentities($data['comment_body']));
                $data['timestamp'] = date('F j, Y, g:i a', strtotime($data['timestamp']));
                echo json_encode($data);
            } else {
                echo json_encode(['status' => false]);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function update()
    {
        try {

            $data = [];
            $data['comment_id'] = $_POST['comment_id'];
            $data['comment_name'] = $_POST['comment_name'];
            $data['comment_body'] = $_POST['comment_body'];
            $data['timestamp'] = date('Y-m-d h:i:s');

            $comment = new Comment();

            $validate = $comment->validateData($data);
            if ($validate !== true) {
                echo json_encode(['status' => false, 'message' => $validate]);
                exit();
            }

            $permission = $comment->validatePermission();
            if($permission == false){
                echo json_encode(['status' => false, 'message' => "You are not allowed to update."]);
                exit();
            }

            if($comment->updateComment($data)){
                $data['status'] = true;
                $data['fm_comment_name'] = htmlentities($data['comment_name']);
                $data['fm_comment_body'] = nl2br(htmlentities($data['comment_body']));
                $data['timestamp'] = date('F j, Y, g:i a', strtotime($data['timestamp']));
                echo json_encode($data);
            }else{
                echo json_encode(['status' => false]);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function delete()
    {
        try {
            $data = [];
            $data['comment_id'] = $_POST['comment_id'];
            $data['timestamp'] = date('Y-m-d h:i:s');

            $comment = new Comment();

            $permission = $comment->validatePermission();
            if($permission == false){
                echo json_encode(['status' => false, 'message' => "You are not allowed to delete."]);
                exit();
            }

            if($comment->deleteComment($data)){
                echo json_encode(['status' => true]);
            }else{
                echo json_encode(['status' => false]);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}