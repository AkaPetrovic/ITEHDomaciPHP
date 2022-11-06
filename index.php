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
      echo "Nema proizvodjaca u bazi podataka";
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
        <button id="kreirajNovi" class="button" onclick="promeniVidljivost([document.getElementsByClassName('modal')[0], document.getElementsByClassName('backdrop')[0]])"><i class="fa-solid fa-plus"></i></button>
        <button id="izbrisiRed" class="button"><i class="fa-solid fa-trash"></i></button>
        <select name="izabraniRed" id="izabraniRed">
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

    <p class="message-success hidden">Automobil je dodat</p>

    <div class="backdrop hidden"></div>

    <div class="modal hidden">
      <h2>Kreiranje novog automobila</h2>
      <form id="formKreiranje" method="POST">

        <select name="proizvodjaci" id="proizvodjaci">
          <?php
            foreach($proizvodjaci as $proizvodjac){
          ?>
            <option value="<?php echo "$proizvodjac[id]"?>"><?php echo "$proizvodjac[id] $proizvodjac[naziv]"?></option>
          <?php
            }
          ?>
        </select>
        
        <input type="hidden" name="id" id="id" value="<?php $noviID = sizeof($automobili) + 1; echo $noviID;?>">

        <label for="model">Model</label>
        <input type="text" name="model" id="model">

        <label for="godiste">Godiste</label>
        <input type="number" name="godiste" id="godiste">

        <button type="button" id="proba">Proba</button>
        <button type="submit" id="dodajButton" onclick="promeniVidljivost([this.parentNode.parentNode, document.getElementsByClassName('backdrop')[0]])">Dodaj</button>
        <button type="button" id="modalButton" onclick="promeniVidljivost([this.parentNode.parentNode, document.getElementsByClassName('backdrop')[0]])">Izadji</button>
      </form>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
            crossorigin="anonymous">
    </script>
    <script src="js/script.js"></script>
  </body>
</html>
