<?php
require_once "$dir/core/View.php";
require_once "$dir/app/models/User.php";

class UserController
{
    public function signin()
    {
        try {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = new User();
            if ($user->signin($username, $password)) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function signout()
    {
        if(session_destroy())
        {
            header("Location: /");
        }
    }
}