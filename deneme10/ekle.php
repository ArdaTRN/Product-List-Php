<?php
include 'baglanti.php';

if (!empty($_POST['urunAdi']) && !empty($_POST['urunFiyat'])) {
    $urunIsim = $_POST["urunAdi"];
    $urunFiyat = $_POST["urunFiyat"];
    $urunRengi = $_POST["urunRengi"];
    $urunPaket = $_POST["urunPaket"];

    $diziBuyuklugu = count($urunPaket);
    $paket = "";

    for ($i = 0; $i < $diziBuyuklugu; $i++) {
        if ($i < $diziBuyuklugu - 1)
            $paket .= $urunPaket[$i] . ",";
        else
            $paket .= $urunPaket[$i];
    }




    $sql = "INSERT INTO urunler (uisim, ufiyat, urenk, upaket)
  VALUES ('$urunIsim', '$urunFiyat', '$urunRengi', '$paket')";

    if ($conn->query($sql) === TRUE) {
        $stmt = $conn->prepare("select * from urunler order by id desc");
        $stmt->execute();
        $sonuc = $stmt->get_result();
        $mesaj = "";
        while ($row = $sonuc->fetch_assoc()) {
            $mesaj .= "<tr>
            <td>" . $row["uisim"] . " </td>
            <td>" . $row["ufiyat"] . " </td>
            <td>" . $row["urenk"] . " </td>
            <td>" . $row["upaket"] . " </td>
            <td>" . $row["utarih"] . " </td>
            <td> <a href='duzenle.php?id= " . $row["id"] . "' class=\"btn btn-success\">SEÇ</a> </td>
            <td><button id='sil_" . $row['id'] . "' class=\"btn btn-danger\" onclick='urunSil(" . $row['id'] . ") data-id='" . $row['id'] . "'>Sil</button>
            </td>
          </tr>";
        }
        echo $mesaj;
        $conn->close();
    } else {
        echo 2;
    }

    //$conn->close();


}
