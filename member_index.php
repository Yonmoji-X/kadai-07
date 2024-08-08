<?php
        session_start();

        include("funcs.php");

// LOGINチェック
sschk();
        $auth_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        ?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>衛生管理</title>
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
        <style>div{padding: 10px;font-size:16px;}</style>
    </head>
    <body>

        <!-- Head[Start] -->
        <header>
        <?php include("menu.php");?>
            <!-- <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
                </div>
            </nav> -->
        </header>
        <!-- Head[End] -->

        <!-- Main[Start] -->
        <div class="main">
            <form method="POST" action="member_insert.php">
                <div class="jumbotron">
                    <fieldset>
                        <legend>従業員登録</legend>
                        <input type="hidden" name="auth_id" value="<?= $auth_id ?>">
                        <table>
                            <tr>
                                <td>
                                    名前:
                                </td>
                                <td>
                                    <input type="text" name="name">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email：
                                </td>
                                <td>
                                    <input type="text" name="email">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    備考
                                </td>
                                <td>
                                    <textArea name="content" rows="4" cols="40"></textArea>
                                </td>
                            </tr>
                        </table>
                        <input type="submit" value="送信" class="subBtn">
                    </fieldset>
                </div>
            </form>
        </div>
        <!-- Main[End] -->

    </body>
</html>

