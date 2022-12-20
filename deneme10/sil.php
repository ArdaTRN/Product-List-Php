<?php
require_once('baglanti.php');
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "delete from urunler where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if ($conn->affected_rows == 1) {
        header('Location:urun.php');
    } else {
        header("refresh:3;url=http://localhost/deneme10/urun.php");
        echo "Ürün silinemedi bir hata oluştu";
    }
}

?>

<!-- <script>
    setTimeout(function() {
        alert("Beklenmeyen Bir Hata Oluştu");
        window.location.href = 'http://localhost/deneme10/urun.php';
    }, 2000);
</script> -->