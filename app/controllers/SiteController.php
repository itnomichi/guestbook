<?php
require_once "$dir/core/View.php";
require_once "$dir/app/models/Comment.php";

class SiteController
{
    public function index()
    {
        $comment = new Comment();
        $comments = $comment->getAllComments();
        $view = new View();
        return $view->render('home.php', ['comments' => $comments]);
    }

    public function signin()
    {
        if ((isset($_SESSION['login_user']) && $_SESSION['login_user'] != '')) {
            return header ("Location: /");
        }
        $view = new View();
        return $view->render('signin.php');
    }
}