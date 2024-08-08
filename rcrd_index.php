<?php
session_start();

// 1. 関数群の読み込み
include("funcs.php");

// LOGINチェック → funcs.phpへ関数化しましょう！
sschk();

// セッションからユーザーのauth_idを取得
// $auth_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
// try {

// } catch(PDOException $e) {
//   echo 'Database error: ' . $e->getMessage();
// }

// 2. データ取得SQL作成
$pdo = db_conn();
include("menu_auth_gene.php");
$sql = "SELECT * FROM H_template_table WHERE auth_id = :auth_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':auth_id', $auth_id, PDO::PARAM_INT);
$status = $stmt->execute();

$sql_ref = "SELECT * FROM H_member_table WHERE auth_id = :auth_id";
$stmt_ref = $pdo->prepare($sql_ref);
$stmt_ref->bindValue(':auth_id', $auth_id, PDO::PARAM_INT);
$status_ref = $stmt_ref->execute();
// 3. データ表示
$values = "";
if ($status == false) {
    sql_error($stmt);
}
if ($status_ref == false) {
    sql_error($stmt_ref);
}

$members = [];
while ($row = $stmt_ref->fetch(PDO::FETCH_ASSOC)) {
    $members[] = [
      'm_id' => $row['id'],
      'm_name' => $row['name']
  ];
}

// 全データ取得
$values = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($values, JSON_UNESCAPED_UNICODE);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>H_</title>
<!-- <link href="./css/all.css" rel="stylesheet"> -->
<style>
div{padding: 10px;font-size:16px;}

/* .item_field {
    border-bottom: solid 0.5px #ddd;
    border: none;
    border-radius: none;
    background: white;
    margin: 10px 0px;
    width: 600px;
} */

.radioBtn {
    clip: rect(1px, 1px, 1px, 1px);
    position: absolute !important;
  }

  .radioBtn_label {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin-right: 18px;
    border-radius: 50px;
    transition: all .2s;
    background: #eee;
    /* border: solid 0.5px #ddd; */
}

.radioBtn:checked + .radioBtn_label {
    /* background: black; */
    /* background: #f56500; */
    background: #63d4db;
    color: #fff;
    text-shadow: 0 0 1px rgba(0,0,0,.7);
}

.radioBtn_input:focus + .radioBtn_label {
    outline-color: #4D90FE;
    outline-offset: -2px;
    outline-style: auto;
    outline-width: 5px;
}

@media screen and (max-width: 767px) {
  .item_field {
    width: 400px;
  }
}

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
<form method="POST" action="rcrd_insert.php" enctype="multipart/form-data">
  <div class="jumbotron">
    <h3>チェック</h3>
    <fieldset>
        <select name="admin_or_emp" id="id_admin_or_emp">
            <option value="0">従業員</option>
            <option value="1">管理者</option>
        </select>
        <select name="work_in_or_out" id="id_work_in_or_out">
            <option value="1">出勤時</option>
            <option value="0">退勤時</option>
        </select>
        <select name="recorder">
          <?php foreach ($members as $member): ?>
            <option value="<?= h($member['m_id']) ?>"><?= h($member['m_name']) ?></option>
          <?php endforeach; ?>
        </select>
        <div id="items_container"></div>


        <input type="hidden" name="auth_id" value="<?= h($auth_id) ?>">
        <input type="submit" value="完了" class="subBtn">
    </fieldset>
  </div>
</form>
</div>
<!-- Main[End] -->

<script>
  const jsonString = '<?= $json ?>';
  let data = [];

  try {
    data = JSON.parse(jsonString);
    console.log(data);
  } catch (e) {
    console.error('Error parsing JSON:', e);
  }

  function filterData() {
    const adminOrEmp = document.getElementById('id_admin_or_emp').value;
    const workInOrOut = document.getElementById('id_work_in_or_out').value;

    const filteredData = data.filter(row =>
      row.admin_or_emp == adminOrEmp && row.work_in_or_out == workInOrOut
    );

    displayData(filteredData);
  }

  function displayData(filteredData) {
    const container = document.getElementById('items_container');
    container.innerHTML = '';

    filteredData.forEach((row, index) => {
      const itemField = document.createElement('div');
      itemField.classList.add('item_field');
      itemField.style.borderBottom = 'solid 0.5px #ddd';
      // itemField.style.border = 'solid 0.5px #ddd';
      // itemField.style.borderRadius = '10px';
      itemField.style.background = 'white';
      itemField.style.margin = '10px 0px';
      itemField.style.width = '500px';
//       itemField.style.@media screen and (max-width: 767px) {
//   .item-field {
//     width: 400px;
//   }
// }


      const titleBox = document.createElement('div');
      titleBox.id = 'title_box';
      const titleP = document.createElement('p');
      titleP.textContent = row.title;

      // Hidden field for title
      const titleInput = document.createElement('input');
      titleInput.type = 'hidden';
      titleInput.name = `title_${index}`;
      titleInput.value = row.id;
      // titleInput.value = row.title;

      titleBox.appendChild(titleP);
      titleBox.appendChild(titleInput);
      itemField.appendChild(titleBox);

      if (row.check_exist == 1) {
  const checkBox = document.createElement('div');
  checkBox.id = 'check_box';

  // Yesボタンとそのラベルを作成
  const yesButton = document.createElement('input');
  yesButton.type = 'radio';
  yesButton.name = `check_item_${index}`;
  yesButton.value = 'YES';
  yesButton.id = `check_box_yes_${index}`;
  yesButton.classList.add('radioBtn');
  // yesButton.style.display = 'none';
  // yesButton.style.clip = 'rect(1px, 1px, 1px, 1px)';
  // yesButton.style.position = 'absolute !important';

  const yesLabel = document.createElement('label');
  yesLabel.htmlFor = `check_box_yes_${index}`;
  yesLabel.textContent = 'YES';
  yesLabel.classList.add('radioBtn_label');
  // yesLabel.style.background = 'skyblue';
  // yesButton.style.position = 'absolute !important';

  // Noボタンとそのラベルを作成
  const noButton = document.createElement('input');
  noButton.type = 'radio';
  noButton.name = `check_item_${index}`;
  noButton.value = 'NO';
  noButton.id = `check_box_no_${index}`;
  noButton.classList.add('radioBtn');

  const noLabel = document.createElement('label');
  noLabel.htmlFor = `check_box_no_${index}`;
  noLabel.textContent = 'NO';
  noLabel.classList.add('radioBtn_label');

  // ラジオボタンとラベルをcheckBoxに追加
  checkBox.appendChild(yesButton);
  checkBox.appendChild(yesLabel);
  checkBox.appendChild(noButton);
  checkBox.appendChild(noLabel);

  // itemFieldにcheckBoxを追加
  itemField.appendChild(checkBox);
}


      if (row.text_exist == 1) {
        const textBox = document.createElement('div');
        textBox.id = 'text_box';
        const textInput = document.createElement('input');
        textInput.type = 'text';
        textInput.name = `text_${index}`;
        textBox.appendChild(textInput);
        itemField.appendChild(textBox);
      }

      if (row.photo_exist == 1) {
        const photoBox = document.createElement('div');
        photoBox.id = 'photo_box';
        const photoInput = document.createElement('input');
        photoInput.type = 'file';
        photoInput.name = `photo_${index}`;
        photoBox.appendChild(photoInput);
        itemField.appendChild(photoBox);
      }

      if (row.temp_exist == 1) {
        const tempBox = document.createElement('div');
        tempBox.id = 'temp_box';
        const tempInput = document.createElement('input');
        tempInput.type = 'number';
        tempInput.name = `temp_${index}`;
        const tempLabel = document.createElement('label');
        tempLabel.htmlFor = `temp_${index}`;
        tempLabel.textContent = ' ℃';
        tempInput.style.width = '50px';
        tempInput.style.height = '20px';
        tempBox.appendChild(tempInput);
        itemField.appendChild(tempBox);
        tempBox.appendChild(tempLabel);
      }

      container.appendChild(itemField);
    });
  }

  document.getElementById('id_admin_or_emp').addEventListener('change', filterData);
  document.getElementById('id_work_in_or_out').addEventListener('change', filterData);

  window.onload = filterData;
</script>
</body>
</html>
