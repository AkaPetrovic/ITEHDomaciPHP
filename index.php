<?php
  require "dbBroker.php";
  require "model/automobil.php";
  require "model/proizvodjac.php";

  $proizvodjaci = array();
  $automobili = array();

  $resultPr = Proizvodjac::getAll($conn);

  if(!$resultPr){
    echo "Nastala je greska prilikom izvrsavanja upita";
    exit();
  }else{
    if ($resultPr->num_rows > 0) {
      while($row = $resultPr->fetch_array()) {
        $proizvodjaci[] = $row;
      }
    } else {
      echo "Proizvodjaca u bazi podataka";
    }
  }

  $resultA = Automobil::getAll($conn);
  if(!$resultA){
    echo "Nastala je greska prilikom izvrsavanja upita";
    exit();
  }else{
    if($resultA->num_rows > 0){
      while($row = $resultA->fetch_assoc()) {
        foreach($proizvodjaci as $proizvodjac){
          if($proizvodjac["id"] == $row["proizvodjac_id"]){
            $row["nazivProizvodjaca"] = $proizvodjac["naziv"];
          }
        }
        $automobili[] = $row;
      }
    }
  }

  // foreach($automobili as $automobil){
  //     echo "$automobil[id] $automobil[nazivProizvodjaca] $automobil[model] $automobil[godiste] <br>";
  // }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Automobili</title>
    <!-- Google fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter&display=swap"
      rel="stylesheet"
    />
    <!-- css files -->
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <script src="https://kit.fontawesome.com/ab4d6c9c7b.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="wrapper">
      <h1 class="heading">Tabela automobila</h1>
      <?php
        if($resultA->num_rows > 0):
      ?>
        <button id="kreirajNovi"><i class="fa-solid fa-plus"></i></button>
        <button id="izbrisiRed"><i class="fa-solid fa-trash"></i></button>
        <select name="izabraniRed" id="izabraniRed">
          <option value="izaberi">Izaberite red u tabeli...</option>
          <?php
            foreach($automobili as $automobil){
          ?>
            <option value="<?php echo "$automobil[id]"?>"><?php echo "$automobil[id] $automobil[nazivProizvodjaca]"?></option>
          <?php
            }
          ?>
        </select>
        <table>
          <thead>
            <tr>
              <th>Redni broj</th>
              <th>Proizvodjac</th>
              <th>Model</th>
              <th>Godina proizvodnje</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($automobili as $automobil){
            ?>
              <tr>
                <td><?php echo $automobil["id"] ?></td>
                <td><?php echo $automobil["nazivProizvodjaca"] ?></td>
                <td><?php echo $automobil["model"] ?></td>
                <td><?php echo $automobil["godiste"] ?></td>
              </tr>
            <?php
              }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3">Ukupno rezultata:</th>
              <th><?php echo $resultA->num_rows ?></th>
            </tr>
          </tfoot>
        </table>
      <?php
        else:
      ?>
        <p class="no-results-message">Nema automobila u bazi podataka</p>
      <?php
        endif;
      ?>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
            crossorigin="anonymous">
    </script>
  </body>
</html>
