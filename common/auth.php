<?php

if(!isset($_SESSION)){
    session_start();
}

/**
 * returns true if logged in
 * @return bool
 */
function isLogin() {
    if (isset($_SESSION['user'])) {
        return true;
    }

    return false;
}

/**
 * get username of current_user
 * @return string
 */
function getCurrentUserName() {
    if (isset($_SESSION['user'])) {
        $name = $_SESSION['user']['name'];

        if (mb_strlen($name > 7)) {
            $name = mb_substr($name, 0, 7) . "...";
        }

        return $name;
    }

    return "";
}

/**
 * get current_user_name
 * @return int|null
 */
function getCurrentUserId() {
    if (isset($_SESSION['user'])) {
        return $_SESSION['user']['id'];
    }

    return null;
}