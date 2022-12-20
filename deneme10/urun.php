<?php
include 'baglanti.php';

if ($_POST) {
  $urunIsim = $_POST["urunAdi"];
  $urunFiyat = $_POST["urunFiyat"];
  $urunRengi = $_POST["urunRengi"];
  $urunPaket = $_POST["urunPaket"];

  //echo $urunIsim."<br>". $urunFiyat."<br>".$urunRengi."<br>";

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
    echo '
    <div class="alert alert-success" role="alert">
    Ürün Başarılı bir şekilde eklendi!
    
  </div>';
  } else {
    echo '
    <div class="alert alert-danger" role="alert">
    Beklenmeyen Bir Hata Oluştu : ' . $conn->error . '
    
  </div>';
  }

  //$conn->close();


}
$sql = "SELECT * FROM urunler order by id desc";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
    }
  </style>
</head>

<body>
  <div class="container">

    <div class="p-3 border border-secondary">
      <h3>Ürün Ekle</h3>
      <form action="" id="urunEkle">
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Ürün Adı :</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="urunAdi" name="urunAdi" placeholder="Ürün adı giriniz">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-2 col-form-label">Ürün Fiyatı :</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="urunFiyat" name="urunFiyat" placeholder="Ürün fiyatı giriniz">
          </div>
        </div>
        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Ürün Rengi :</legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="urunRengi" id="gridRadios1" value="mavi" checked>
                <label class="form-check-label" for="gridRadios1">
                  Mavi
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="urunRengi" id="gridRadios2" value="siyah">
                <label class="form-check-label" for="gridRadios2">
                  Siyah
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="urunRengi" id="gridRadios3" value="gri">
                <label class="form-check-label" for="gridRadios3">
                  Gri
                </label>
              </div>
            </div>
          </div>
        </fieldset>
        <div class="form-group row">
          <div class="col-sm-2">Ürün Paketi :</div>
          <div class="col-sm-10">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck1" name="urunPaket[]" value="karton" checked>
              <label class="form-check-label" for="gridCheck1">
                Karton
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck1" name="urunPaket[]" value="naylon">
              <label class="form-check-label" for="gridCheck1">
                Naylon
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck1" name="urunPaket[]" value="ahsap">
              <label class="form-check-label" for="gridCheck1">
                Ahşap
              </label>
            </div>

          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btnEkle btn btn-primary btn-block">ÜRÜN KAYDET</button>
          </div>
        </div>
      </form>
    </div>
    <div style="background-color:white; height:5px;"></div>
    <div class="row mt-3">




      <table class="table">
        <thead>
          <tr>

            <th scope="col">Ürün İsim</th>
            <th scope="col">Ürün Fiyat</th>
            <th scope="col">Ürün Renk</th>
            <th scope="col">Ürün Paket</th>
            <th scope="col">Kayıt Tarihi</th>
            <th scope="col">Güncelle</th>
            <th scope="col">Sil</th>
          </tr>
        </thead>
        <tbody class="table-group-divider" id="tabloici">

          <?php

          if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) { ?>
              <tr>
                <td><?= $row["uisim"]; ?> </td>
                <td><?= $row["ufiyat"]; ?> </td>
                <td><?= $row["urenk"]; ?> </td>
                <td><?= $row["upaket"]; ?> </td>
                <td><?= $row["utarih"]; ?> </td>
                <td><a href="duzenle.php?id=<?= $row["id"] ?>" class="btn btn-success">SEÇ</a> </td>
                <td><button id="sil_<?= $row['id']; ?>" class="btn btn-danger" onclick="urunSil(<?= $row['id']; ?>)" data-id="<?= $row['id'] ?>">Sil</a></td>
              </tr>
          <?php }
          } ?>


        </tbody>
      </table>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
  </script>

  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.js"> </script>

  <script>
    $(function() {
      $('.btnEkle').click(function(event) {
        event.preventDefault();
        $.ajax({
          url: 'ekle.php',
          type: 'post',
          data: $('#urunEkle').serialize(),
          success: function(sonuc) {
            $('#tabloici').html(sonuc);


          }
        });
      });
    });

    function urunSil(id) {
      var satir = document.getElementById('sil_' + id);

      bootbox.confirm("Silmek istediğinizden emin misiniz ...", function(sonuc) {
        if (sonuc) {
          $.ajax({
            url: 'sil2.php',
            type: 'post',
            data: {
              "id": id
            },
            success: function(sonuc) {
              if (sonuc == 1) {
                $(satir).closest('tr').css('background-color', 'tomato');
                $(satir).closest('tr').fadeOut(800, function() {
                  $(this).remove();
                });
              }
            }
          });
        }
      });
    }
  </script>

</body>

</html>