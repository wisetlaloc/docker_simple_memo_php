<?php
  session_start();
  require '../common/auth.php';

  if(isLogin()) {
    header('Location: ../memo');
    exit;
  }

  require '../common/validation.php';
  require '../common/database.php';

  $user_name = $_POST['user_name'];
  $user_email = $_POST['user_email'];
  $user_password = $_POST['user_password'];

  $_SESSION['errors'] = [];

  emptyCheck($_SESSION['errors'], $user_name, "username is required");
  emptyCheck($_SESSION['errors'], $user_email, "email is required");
  emptyCheck($_SESSION['errors'], $user_password, "password is required");
  ltEqCheck($_SESSION['errors'], $user_name, "username should be 255 characters at most");
  ltEqCheck($_SESSION['errors'], $user_email, "email should be 255 characters at most");
  ltEqCheck($_SESSION['errors'], $user_password, "password should be 255 characters at most");
  gtEqCheck($_SESSION['errors'], $user_password, "password should be 8 characters at least");

  if(!$_SESSION['errors']) {
    emailFormatCheck($_SESSION['errors'], $user_email, "email is invalid");
    asciiCheck($_SESSION['errors'], $user_name, "username should only contain alphanumerics");
    asciiCheck($_SESSION['errors'], $user_password, "password should only contain alphanumerics");
    emailUniqueCheck($_SESSION['errors'], $user_email, "the email is already registered");
  }

  if($_SESSION['errors']) {
    header('Location: ../../user/new.php');
    exit;
  }

  $database_handler = getDatabaseConnection();

  try {
    if ($statement = $database_handler->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)')) {
      $password = password_hash($user_password, PASSWORD_DEFAULT);

      $statement->bindParam(':name', htmlspecialchars($user_name));
      $statement->bindParam(':email', $user_email);
      $statement->bindParam(':password', $password);
      $statement->execute();
    }

    $_SESSION['user'] = [
                'name' => $user_name,
                'id' => $database_handler->lastInsertId()
    ];
  } catch (Throwable $e) {
    echo $e->getMessage();
    exit;
  }

  // redirect
  header('Location: ../../memo/');
  exit;