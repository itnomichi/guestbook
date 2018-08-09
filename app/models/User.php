<?php
require_once "$dir/core/DB.php";

class User
{
    private $db = null;

    public function __construct()
    {
        $this->db = DB::open();
    }

    public function signin($username, $password)
    {
        try {
            $sql = "SELECT count(*) AS cnt FROM users WHERE username = ? AND password = ?";
            $sth = $this->db->prepare($sql);
            $sth->execute(array($username, md5($password)));
            $red = $sth->fetch();
            if ($red['cnt'] > 0) {
                $_SESSION['login_user'] = $username;
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}