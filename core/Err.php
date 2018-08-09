<?php

class Err
{
    public static function response(\Throwable $ex, $status)
    {
        $err_msg = 'Oops, something went wrong.';
        if($status == '404')
            $err_msg = 'Not found';

        if (APP_ENV == 'local') {
            $err_msg = $ex->getMessage();
        }
        return header("HTTP/1.0 $status $err_msg");
    }
}