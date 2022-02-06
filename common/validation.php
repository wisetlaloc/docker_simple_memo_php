<?php

/**
 * check if input is empty
 * @param $error_messages
 * @param $input
 * @param $error_message
 */
function emptyCheck(&$error_messages, $input, $error_message){
    if (empty(trim($input))) {
        array_push($error_messages, $error_message);
    }
}

/**
 * check if input is greater than or equal to mininum
 * @param $error_messages
 * @param $input
 * @param $error_message
 * @param int $minimum
 */
function gtEqCheck(&$error_messages, $input, $error_message, $minimum = 8){
    if (mb_strlen($input) <= $minimum) {
        array_push($error_messages, $error_message);
    }
}

/**
 * check if input is less than or equal to mininum
 * @param $error_messages
 * @param $input
 * @param $error_message
 * @param int $maximum
 */
function ltEqCheck(&$error_messages, $input, $error_message, $maximum = 255){
    if (mb_strlen($input) >= $maximum) {
        array_push($error_messages, $error_message);
    }
}

/**
 * check if input is in email format
 * @param $error_messages
 * @param $input
 * @param $error_message
 */
function emailFormatCheck(&$error_messages, $input, $error_message) {
    if (filter_var($input, FILTER_VALIDATE_EMAIL) == false) {
        array_push($error_messages, $error_message);
    }
}

/**
 * check if input is ascii-only
 * @param $error_messages
 * @param $input
 * @param $error_message
 */
function asciiCheck(&$error_messages, $input, $error_message) {
    if (preg_match("/^[a-zA-Z0-9]+$/", $input) == false) {
        array_push($error_messages, $error_message);
    }
}

/**
 * check if input is an unique email
 * @param $error_messages
 * @param $input
 * @param $error_message
 */
function emailUniqueCheck(&$error_messages, $input, $error_message) {
    $database_handler = getDatabaseConnection();
    if ($statement = $database_handler->prepare('SELECT id FROM users WHERE email = :user_email')) {
        $statement->bindParam(':user_email', $input);
        $statement->execute();
    }

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        array_push($error_messages, $error_message);
    }
}


