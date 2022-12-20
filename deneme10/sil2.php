<?php
require_once('baglanti.php');
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "delete from urunler where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if ($conn->affected_rows == 1) {
        echo 1;
    } else {
        echo 2;
    }
}
