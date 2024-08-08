<?php
session_start();
include("funcs.php");
// check_gene_id.php
// LOGINチェック
sschk();

$auth_id = '';
if ($_SESSION["kanri_flg"] == "1") {
    $auth_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

$pdo = db_conn();
$kanri_flg = 0;

// auth_idが一致するデータのみを取得するクエリに変更
$sql = "SELECT * FROM H_user_table WHERE kanri_flg = :kanri_flg";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
}

// 全データ取得
$values = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($values, JSON_UNESCAPED_UNICODE);

$sql_shr = "SELECT * FROM H_share_table WHERE auth_id = :auth_id";
$stmt_shr = $pdo->prepare($sql_shr);
$stmt_shr->bindValue(':auth_id', $auth_id, PDO::PARAM_INT);
$status_shr = $stmt_shr->execute();

if ($status_shr == false) {
    sql_error($stmt_shr);
}

// 全データ取得
$values_shr = $stmt_shr->fetchAll(PDO::FETCH_ASSOC);
$json_shr = json_encode($values_shr, JSON_UNESCAPED_UNICODE);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>従業員登録</title>
    <style>
        div { padding: 10px; font-size: 16px; }
    </style>
</head>
<body>

    <!-- Head[Start] -->
    <header>
    <?php include("menu.php"); ?>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div class="main">
        <form id="registration-form" method="POST" action="shr_insert.php">
            <div class="jumbotron">
                <fieldset>
                    <legend>一般アカウント登録</legend>
                    <!-- 隠しフィールドにユーザーIDを追加 -->
                    <input type="hidden" name="auth_id" value="<?= $auth_id ?>">
                    <table>
                        <tr>
                            <td>一般アカウントID：</td>
                            <td><input type="text" id="gene_id"></td>
                        </tr>
                    </table>
                    <!-- 従業員アカウントID -->

                    <!-- 隠しフィールドに従業員IDを追加 -->
                    <input type="hidden" name="gene_id" id="hidden_gene_id" value="">
                    <input type="submit" value="登録" class="subBtn">
                </fieldset>
            </div>
        </form>
        <table id="table_body">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>アカウントID</th>
                    <th>削除</th>
                </tr>
            <thead>
        </table>
    </div>
    <!-- Main[End] -->

    <!-- JSONデータをJavaScriptで利用 -->
    <script>
        // PHPからJSONデータをJavaScriptに埋め込む
        let userTableData = <?= $json ?>;
        let shareTableData = <?= $json_shr ?>;
        console.log(userTableData);
        console.log(shareTableData);

        const tableBody = document.getElementById('table_body');
        shareTableData.forEach(v => {
            let matchedRecord_user = userTableData.find(record =>
            record.id === v.gene_id);
            if (matchedRecord_user) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td>${matchedRecord_user.name}</td>
                <td>${matchedRecord_user.lid}</td>
                <td><a href="shr_delete.php?id=${v.id}" onclick="return confirmDelete();">削除</a></td>
                `;
                tableBody.appendChild(tr);
            }
        })
        // index_shareにデータを表示
        // const indexShare = document.getElementById('index_share');
        // for (let i = 0; i < shareTableData.length; i++) {
        //     let targetId = shareTableData[i].gene_id;
        //     let matchedRecord_user = userTableData.find(record => record.id === targetId);
        //     if (matchedRecord_user) {
        //         console.log("Found record:", matchedRecord_user);
        //         const contentShare_div = document.createElement('div');
        //         contentShare_div.innerHTML =`
        //         <p>${matchedRecord_user.name}</p>

        //         <a href="rcrd_delete.php?id=${targetId}>削除</a>
        //         `;
        //         indexShare.appendChild(contentShare_div);
        //     } else {
        //         console.log("No record found with id:", targetId);
        //     }
        // }

        // const indexShare = document.getElementById('index_share');
        // for (let i = 0; i < shareTableData.length; i++) {
        //     let targetId = shareTableData[i].gene_id;
        //     let matchedRecord_user = userTableData.find(record => record.id === targetId);
        //     if (matchedRecord_user) {
        //         console.log("Found record:", matchedRecord_user);
        //         const contentShare = document.createElement('p');
        //         contentShare.textContent = matchedRecord_user.name; // textContent を使用
        //         indexShare.appendChild(contentShare);
        //     } else {
        //         console.log("No record found with id:", targetId);
        //     }
        // }

        document.addEventListener('DOMContentLoaded', function() {
            let geneIdInput = document.getElementById('gene_id');
            let hiddenGeneId = document.getElementById('hidden_gene_id');

            geneIdInput.addEventListener('input', function() {
                let inputValue = geneIdInput.value;

                // `userTableData` から `lid` が `inputValue` と一致するレコードを探す
                let matchedRecord = userTableData.find(function(record) {
                    return record.lid === inputValue;
                });

                if (matchedRecord) {
                    // 一致するレコードが見つかった場合、`id` を `hidden_gene_id` の値に設定
                    hiddenGeneId.value = matchedRecord.id;
                } else {
                    // 一致するレコードが見つからない場合、隠しフィールドをクリア
                    hiddenGeneId.value = '';
                }
            });
        });
    </script>

    <script>
        // フォーム送信前にチェックを行う
        document.getElementById('registration-form').addEventListener('submit', function(event) {
            event.preventDefault(); // デフォルトのフォーム送信を防ぐ

            let geneId = document.getElementById('hidden_gene_id').value;

            // `gene_id` が存在するかどうかをサーバーに問い合わせる
            fetch('shr_check_gene_id.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'gene_id': geneId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    alert('このIDはすでに登録されています。');
                } else {
                    document.getElementById('registration-form').submit(); // 存在しない場合はフォームを送信
                }
            })
            .catch(error => console.error('Error:', error));
        });
        function confirmDelete() {
            return confirm("本当に削除してもよろしいですか？");
        }
    </script>

</body>
</html>
