<?php
    require '../common/auth.php';
    require '../common/database.php';

    if (!isLogin()) {
        header('Location: ../session/new.php');
        exit;
    }

    $edit_id = $_POST['edit_id'];
    $user_id = getCurrentUserId();

    $database_handler = getDatabaseConnection();

    try {
        if ($statement = $database_handler->prepare("DELETE FROM memos WHERE id = :edit_id AND user_id = :user_id")) {
            $statement->bindParam(":edit_id", $edit_id);
            $statement->bindParam(":user_id", $user_id);
            $statement->execute();
        }
    } catch (Throwable $e) {
        echo $e->getMessage();
        exit;
    }

    header('Location: ../../memo');
    exit;
