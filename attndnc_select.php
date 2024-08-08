<?php
// 0. SESSION開始！！
session_start();
// 1. 関数群の読み込み
include("funcs.php");

// LOGINチェック
sschk();
$pdo = db_conn();
// 2. データ登録SQL作成
include("menu_auth_gene.php");

// データ取得SQL作成
$sql = "SELECT * FROM H_attendance_table WHERE auth_id = :auth_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':auth_id', $auth_id, PDO::PARAM_INT);
$status = $stmt->execute();

$sql_mmbr = "SELECT * FROM H_member_table WHERE auth_id = :auth_id";
$stmt_mmbr = $pdo->prepare($sql_mmbr);
$stmt_mmbr->bindValue(':auth_id', $auth_id, PDO::PARAM_INT);
$status_mmbr = $stmt_mmbr->execute();

// データ表示
$values = [];
if ($status === false) {
    sql_error($stmt);
} else {
    $values = $stmt->fetchAll(PDO::FETCH_ASSOC); // 全データ取得
}

$names = [];
$members = [];// select要素用
if ($status_mmbr === false) {
    sql_error($stmt_mmbr);
} else {
    while ($row = $stmt_mmbr->fetch(PDO::FETCH_ASSOC)) {
        $names[$row['id']] = $row['name'];
        $members[] = [// select要素用
          'm_id' => $row['id'],
          'm_name' => $row['name']
      ];
    }
}

// JSONエンコード
$json = json_encode($values, JSON_UNESCAPED_UNICODE);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'JSONエンコードエラー: ' . json_last_error_msg();
    exit;
}
$json_mmbr = json_encode($members, JSON_UNESCAPED_UNICODE);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'JSONエンコードエラー: ' . json_last_error_msg();
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>チェック項目作成</title>
<style>
div{padding: 10px;font-size:16px;}
img.photo { width: 100px; height: 100px; object-fit: cover; }
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
<?php include("menu.php");?>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="main">
    <div class="container jumbotron">絞り込み
        <select name="recorder" id="id_sel_recorder">
          <option value="">記録者：全て</option>
          <?php foreach ($members as $member): ?>
            <option value="<?= h($member['m_id']) ?>"><?= h($member['m_name']) ?></option>
          <?php endforeach; ?>
        </select>
        <input type="date" id="date_picker" class="input_date" />
        <table id="record_table">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>名前</th>
                    <th>出勤</th>
                    <th>退勤</th>
                    <?php if($_SESSION["kanri_flg"] == "1"){ ?>
                    <th>削除</th>
                    <th>編集</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody id="table_body">
            </tbody>
        </table>
    </div>
</div>
<!-- Main[End] -->

<script>
    function formatDateTime(dateTimeStr) {
        const date = new Date(dateTimeStr);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return {
            y_m_d: `${year}/${month}/${day}`,
            h_m: `${hours}:${minutes}`
        };
    }

    function extractDate(dateTimeStr) {
        return dateTimeStr.split(' ')[0];
    }

    const jsonString = '<?= isset($json) ? $json : '' ?>';
    const jsonString_mmbr = '<?= isset($json_mmbr) ? $json_mmbr : '' ?>';
    let data = [];
    let members = [];

    try {
        data = JSON.parse(jsonString);
        members = JSON.parse(jsonString_mmbr);
    } catch (e) {
        console.error('Error parsing JSON:', e);
    }

    function filterData() {
        const selRecorder = document.getElementById('id_sel_recorder').value;
        const pickDate = document.getElementById('date_picker').value;

        const filteredData = data.filter(row => {
            return (selRecorder === "" || row.mmbr_id == selRecorder) &&
                (pickDate === "" || extractDate(row.date) == pickDate);
        });

        displayData(filteredData);
      }

      function displayData(filteredData) {
      // console.log(filteredData);
        const tableBody = document.getElementById('table_body');
        tableBody.innerHTML = '';

        filteredData.forEach(v => {
            const member = members.find(m => m.m_id == v.mmbr_id);
            const memberName = member ? member.m_name : '記録者不明（名簿から削除されています）';

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${formatDateTime(v.date).y_m_d}</td>
                <td>${memberName}</td>
                <td>${v.clock_in == null ? "-" : v.clock_in}</td>
                <td>${v.clock_out == null ? "-" : v.clock_out}</td>
                <?php if($_SESSION["kanri_flg"] == "1"){ ?>
                <td><a href="attndnc_delete.php?id=${v.id}" onclick="return confirmDelete();">削除</a></td>
                <td><a href="attndnc_detail.php?id=${v.id}">編集</a></td>
                <?php } ?>
            `;
            tableBody.prepend(tr);
        });
    }

    document.getElementById('id_sel_recorder').addEventListener('change', filterData);
    document.getElementById('date_picker').addEventListener('change', filterData);

    window.onload = filterData;

    function confirmDelete() {
        return confirm("本当に削除してもよろしいですか？");
    }
</script>
</body>
</html>
