<?php
  session_start();
  require '../common/validation.php';
  require '../common/database.php';

  $user_email = $_POST['user_email'];
  $user_password = $_POST['user_password'];

  $_SESSION['errors'] = [];

  emptyCheck($_SESSION['errors'], $user_email, "email is required");
  emptyCheck($_SESSION['errors'], $user_password, "password is required");

  if($_SESSION['errors']) {
    header('Location: ../../session/new.php');
    exit;
  }

  $database_handler = getDatabaseConnection();
  if ($statement = $database_handler->prepare('SELECT id, name, password FROM users WHERE email = :user_email')) {
    $statement->bindParam(':user_email', $user_email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$user || !password_verify($user_password, $user['password'])) {
      $_SESSION['errors'] = ['メールアドレスまたはパスワードが間違っています。'];
      header('Location: ../../session/new.php');
      exit;
    } else {
      $_SESSION['user'] = [
        'name' => $user['name'],
        'id' => $user['id']
      ];

      header('Location: ../../memo/');
      exit;
    }
  }
