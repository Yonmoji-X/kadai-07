<?php
// 0. SESSION開始！！
session_start();
if ($_SESSION["kanri_flg"] == "1") {
    $auth_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}
if ($_SESSION["kanri_flg"] == "0") {
    $gene_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $sql_gene = "SELECT * FROM H_share_table WHERE gene_id = :gene_id";
    $stmt_gene = $pdo->prepare($sql_gene);
    $stmt_gene->bindValue(':gene_id', $gene_id, PDO::PARAM_INT);
    $status_gene = $stmt_gene->execute();
    // var_dump($status_gene);

    $sql_user = "SELECT * FROM H_user_table";
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->execute();
    $genes = [];
    $auth_names = [];
    if ($genes === false) {
        sql_error($stmt_gene);
    } else {
        $genes = $stmt_gene->fetchAll(PDO::FETCH_ASSOC); // 全データ取得
        while ($row = $stmt_user->fetch(PDO::FETCH_ASSOC)) {
            foreach ($genes as $gene) {
                if ($row['id'] === $gene['auth_id']) {
                    $auth_names[] = [//select要素用
                        'a_id' => $row['id'],
                        'a_name' => $row['name']
                    ];
                }
            }
        }

    }
    $auth_id = $genes[0]['auth_id'];
    $auth_name = $auth_names[0]['a_name'];
    // var_dump($genes);
    // $auth_id = $genes[0]['auth_id'];
    // var_dump($genes);
    // var_dump($auth_names);
}
?>
