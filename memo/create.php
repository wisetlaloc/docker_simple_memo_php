<?php
    require '../common/auth.php';
    require '../common/database.php';

    if (!isLogin()) {
       header('Location: ../session/new.php');
       exit;
    }

    $user_id = getCurrentUserId();
    $database_handler = getDatabaseConnection();

    try {
        $title = "New Memo";
        if ($statement = $database_handler->prepare("INSERT INTO memos (user_id, title, content) VALUES(:user_id, :title, null)")) {
            $statement->bindParam(":user_id", $user_id);
            $statement->bindParam(":title", $title);
            $statement->execute();
        }

        $edit_id = $database_handler->lastInsertId();
    } catch (Throwable $e) {
        echo $e->getMessage();
        exit;
    }
    header("Location: ../memo/index.php?id=$edit_id");
    exit;
