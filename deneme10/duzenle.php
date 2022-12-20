<?php
include 'baglanti.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM urunler where id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $sonuc = $stmt->get_result();
  if ($sonuc->num_rows >= 1) {
    $row = $sonuc->fetch_assoc();
  } else {
    echo 'böyle bir kayıt yoktur ...';
  }
}

if ($_POST && isset($_POST['gunSubmit'])) {
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



  $stmt = $conn->prepare("update urunler set uisim=?,ufiyat=?,urenk=?,upaket=? where id=?");
  $stmt->bind_param('sdssi', $urunIsim, $urunFiyat, $urunRengi, $paket, $id);
  $stmt->execute();


  if ($conn->affected_rows >= 1) {
    echo '
    <div class="alert alert-success" role="alert">
    Ürün Başarılı bir şekilde güncellendi!
  </div>';
    header('location:urun.php');
  } else {
    header("refresh:3;url=http://localhost/deneme10/urun.php");
    echo '
    <div class="alert alert-danger" role="alert">
    Beklenmeyen Bir Hata Oluştu : ' . $conn->error . '
    
  </div>';
  }

  //$conn->close();

}


function degerDizideVarmi($deger, $tumce)
{
  $dizi = explode(',', $tumce);
  foreach ($dizi as $eleman) {
    if ($eleman == $deger) {
      echo 'checked';
      break;
    }
  }
}

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
      <h3>Ürün Güncelle</h3>
      <form action="" method="post">
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Ürün Adı</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="urunAdi" name="urunAdi" value="<?= $row['uisim'] ?>" placeholder="Email">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-2 col-form-label">Ürün Fiyatı</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="urunFiyat" name="urunFiyat" value="<?= $row['ufiyat'] ?>" placeholder="urunFiyat">
          </div>
        </div>
        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Ürün Rengi</legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="urunRengi" id="gridRadios1" value="mavi" <?php
                                                                                                            if ($row['urenk'] == "mavi") echo 'checked';
                                                                                                            ?>>
                <label class="form-check-label" for="gridRadios1">
                  Mavi
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="urunRengi" id="gridRadios2" value="siyah" <?php
                                                                                                              if ($row['urenk'] == "siyah") echo 'checked';
                                                                                                              ?>>
                <label class="form-check-label" for="gridRadios2">
                  Siyah
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="urunRengi" id="gridRadios3" value="gri" <?php
                                                                                                            if ($row['urenk'] == "gri") echo 'checked';
                                                                                                            ?>>
                <label class="form-check-label" for="gridRadios3">
                  Gri
                </label>
              </div>
            </div>
          </div>
        </fieldset>
        <div class="form-group row">
          <div class="col-sm-2">Ürün Paketi</div>
          <div class="col-sm-10">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck1" name="urunPaket[]" value="karton" <?php
                                                                                                                degerDizideVarmi("karton", $row['upaket']);
                                                                                                                ?>>
              <label class="form-check-label" for="gridCheck1">
                Karton
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck1" name="urunPaket[]" value="naylon" <?php
                                                                                                                if (in_array('naylon', explode(',', $row['upaket']))) echo 'checked';
                                                                                                                ?>>
              <label class="form-check-label" for="gridCheck1">
                Naylon
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck1" name="urunPaket[]" value="ahsap" <?php
                                                                                                                if (str_contains($row['upaket'], 'ahsap')) echo 'checked';
                                                                                                                ?>>
              <label class="form-check-label" for="gridCheck1">
                Ahşap
              </label>
            </div>

          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-primary btn-block" name="gunSubmit">Güncelle</button>
          </div>
        </div>
      </form>
    </div>
    <div style="background-color:white; height:5px;"></div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js">
  </script>

</body>

</html>