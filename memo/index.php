<?php
    require '../common/auth.php';
    require '../common/database.php';

    if (!isLogin()) {
        header('Location: ../session/new.php');
        exit;
    }
    $user_name = getCurrentUserName();
    $user_id = getCurrentUserId();

    $memos = [];
    $database_handler = getDatabaseConnection();
    if ($statement = $database_handler->prepare("SELECT id, title, content, updated_at FROM memos WHERE user_id = :user_id ORDER BY updated_at DESC")) {
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();

        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
           array_push($memos, $result);
        }
    }

    if (isset($_GET['id'])) {
        foreach($memos as $memo) {
            if ($memo['id'] == $_GET['id']) {
                $edit_memo = $memo;
                break;
            }
        }
    }

    if (!isset($edit_memo) && !empty($memos)) { $edit_memo = $memos[0]; }
?>

<!DOCTYPE html>
<html lang="ja">
    <?php
        include_once "../partials/header.php";
        echo getHeader("Create a Memo");
    ?>
    <body class="bg-white">
        <div class="h-100">
            <div class="row h-100 m-0 p-0">
                <div class="col-3 h-100 m-0 p-0 border-left border-right border-gray">
                    <div class="left-memo-menu d-flex justify-content-between pt-2">
                        <div class="pl-3 pt-2">
                            Hi, <?php echo $user_name; ?>
                        </div>
                        <div class="pr-1">
                             <a href="./create.php" class="btn btn-success"><i class="fas fa-plus"></i></a>
                            <a href="../login/" class="btn btn-dark"><i class="fas fa-sign-out-alt"></i></a>
                        </div>
                    </div>
                    <div class="left-memo-title h3 pl-3 pt-3">
                        Memo List
                    </div>
                    <div class="left-memo-list list-group-flush p-0">
                        <?php if(empty($memos)): ?>
                            <div class="pl-3 pt-3 h5 text-info text-center">
                                <i class="far fa-surprise"></i> No memos found !
                            </div>
                        <?php endif; ?>
                        <?php foreach($memos as $memo): ?>
                            <a href="./index.php?id=<?php echo $memo['id']; ?>" class="list-group-item list-group-item-action <?php echo $edit_memo['id'] == $memo['id'] ? 'active' : ''; ?>">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?php echo $memo["title"] ?></h5>
                                    <small><?php echo date('Y/m/d H:i', strtotime($memo['updated_at'])); ?></small>
                                </div>
                                <p class="mb-1">
                                    <?php
                                        if (mb_strlen($memo['content']) <= 100) {
                                            echo $memo['content'];
                                        } else {
                                            echo mb_substr($memo['content'], 0, 100) . "...";
                                        }
                                    ?>
                                </p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-9 h-100">
                    <?php if(isset($edit_memo)): ?>
                        <form class="w-100 h-100" method="post">
                            <input type="hidden" name="edit_id" value="<?php echo $edit_memo['id']; ?>" />
                            <div id="memo-menu">
                                <button type="submit" class="btn btn-danger" formaction="./destroy.php"><i class="fas fa-trash-alt"></i></button>
                                <button type="submit" class="btn btn-success" formaction="./update.php"><i class="fas fa-save"></i></button>
                            </div>
                            <input type="text" id="memo-title" name="edit_title" placeholder="title" value="<?php echo $edit_memo['title']; ?>" />
                            <textarea id="memo-content" name="edit_content" placeholder="content"><?php echo $edit_memo['content']; ?></textarea>
                        </form>
                    <?php else: ?>
                        <div class="mt-3 alert alert-info">
                            <i class="fas fa-info-circle"></i><span> create a memo</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
