<?php
if(!function_exists('secure_password')) {
    function secure_password($password, $algorithm = PASSWORD_BCRYPT, $options = array('cost' => 12)) {
        //Hashes the passed string using the password_hash function in PHP. If this function does not exist
        //it uses the PHP crypt function instead
        if(function_exists('password_hash')) {
            return password_hash($password, $algorithm, $options);
        }
        else {
            return crypt($password, '$5$'.rand_str(rand(100,200)).'$');
        }
    }
}
if(!function_exists('verify_secure_password')) {
    function verify_secure_password($user_input, $db_output) {
        if(function_exists('password_verify')) {
            return password_verify($user_input, $db_output);
        }
        else {
            return crypt($user_input, $db_output);
        }
    }
}
if(!function_exists('rand_str')) {
    function rand_str($lenght, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
        $str = '';
        $count = strlen($charset);
        while($lenght--) {
            $str .= $charset[mt_rand(0, $count-1)];
        }
        return $str;
    }
}