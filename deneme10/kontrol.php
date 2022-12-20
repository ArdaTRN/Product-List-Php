<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "urunlerdb2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM urunler";
$result = $conn->query($sql);



if($_POST){
    $urunIsim = $_POST["urunAdi"];
    $urunFiyat = $_POST["urunFiyat"];
    $urunRengi = $_POST["urunRengi"];
    $urunPaket = $_POST["urunPaket"];

    echo $urunIsim."<br>". $urunFiyat."<br>".$urunRengi."<br>";

    $diziBuyuklugu = count($urunPaket);
    $paket="";

    for($i=0 ; $i<$diziBuyuklugu; $i++){
        if($i <$diziBuyuklugu-1)
        $paket .=$urunPaket[$i]. ",";
        else
            $paket .=$urunPaket[$i];
    }

    


$sql = "INSERT INTO urunler (uisim, ufiyat, urenk, upaket)
VALUES ('$urunIsim', '$urunFiyat', '$urunRengi', '$paket')";

if ($conn->query($sql) === TRUE) {
  echo "ürün başarı ile eklendi";
} else {
  echo "Hata : " . $sql . "<br>" . $conn->error;
}

//$conn->close();


}
?>