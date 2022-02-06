<?php
  session_start();
  require '../common/auth.php'

  if(isLogin()) {
    header('Location: ../memo');
    exit;
  }
?>

<!DOCTYPE html>
<html lang="ja">
    <?php
        include_once "../partials/header.php";
        echo getHeader("Sign Up");
    ?>
    <body>
        <div class="d-flex align-items-center justify-content-center h-100">
            <form method="post" action="./create.php">
                <div class="card rounded login-card-width shadow">
                    <div class="card-body">
                        <?php
                            include "../partials/error_message.php";
                        ?>
                        <div class="rounded-circle mx-auto border-gray border d-flex mt-3 icon-circle">
                            <img src="../public/images/animal_stand_zou.png" class="w-75 mx-auto p-2" alt="icon"/>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="mt-3 h2">SimpleMemo</div>
                        </div>
                        <div class="row mt-3">
                            <div class="offset-2 col-8 offset-2">
                                <label class="input-group w-100">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                                    </span>
                                    <input type="text" name="user_name" class="form-control" placeholder="username" autocomplete="off" maxlength="255" />
                                </label>
                                <label class="input-group w-100">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                    </span>
                                    <input type="text" name="user_email" class="form-control" placeholder="email" autocomplete="off" maxlength="255" />
                                </label>
                                <label class="input-group w-100">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </span>
                                    <input type="password" name="user_password" class="form-control" placeholder="password" autocomplete="off" maxlength="255" />
                                </label>
                                <button type="submit" class="form-control btn btn-success">
                                   Sign Up
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
