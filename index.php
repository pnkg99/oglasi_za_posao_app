<?php

//To Handle Session Variables on This Page
session_start();


//Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Oglasi Za Posao</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <link rel="stylesheet" href="css/_all-skins.min.css">
  <!-- Custom -->
  <link rel="stylesheet" href="css/custom.css">
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo logo-bg">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>J</b>P</span>

      <span class="logo-lg"><b>Posao</b> Oglasi</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <a href="poslovi.php">Poslovi</a>
          </li>
          <li>
            <a href="#candidates">Kandidati</a>
          </li>
          <li>
            <a href="#poslodavac">Poslodavci</a>
          </li>
          <li>
            <a href="#about">O nama</a>
          </li>
          <?php if(empty($_SESSION['id_user']) && empty($_SESSION['id_company'])) { ?>
          <li>
            <a href="login.php">Prijavi se</a>
          </li>
          <li>
            <a href="sign-up.php">Registruj se</a>
          </li>  
          <?php } else { 

            if(isset($_SESSION['id_user'])) { 
          ?>        
          <li>
            <a href="kandidat/index.php">Kontrolna Tabla</a>
          </li>
          <?php
          } else if(isset($_SESSION['id_company'])) { 
          ?>        
          <li>
            <a href="poslodavac/index.php">Kontrolna Tabla</a>
          </li>
          <?php } ?>
          <li>
            <a href="logout.php">Odjavi se</a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px;">

    <section class="content-header bg-main">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center index-head">
            <h1>Svi <strong>Poslovi</strong> Na Jednom Mestu</h1>
            <p>Pretrazite poslove po Srbiji</p>
            <p><a class="btn btn-success btn-lg" href="poslovi.php" role="button">Pretraži Poslove</a></p>
          </div>
        </div>
      </div>
    </section>

    <section class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 latest-job margin-bottom-20">
            <h1 class="text-center">Najnoviji Poslovi</h1>            
            <?php 
              $sql = "SELECT * FROM oglasi_za_posao Order By createdat Limit 10";
              $result = $conn->query($sql);
              if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) 
                {
                  $sql1 = "SELECT * FROM poslodavac WHERE id_company='$row[id_company]'";
                  $result1 = $conn->query($sql1);
                  if($result1->num_rows > 0) {
                    while($row1 = $result1->fetch_assoc()) 
                    {     
             ?>
            <div class="attachment-block clearfix">
              <img class="attachment-img"  src="uploads/logo/<?php echo $row1['logo']; ?>" alt="Attachment Image">
              <div class="attachment-pushed">
                <h4 class="attachment-text">Poslodavac : <?php echo $row1["name"]  ?></h4> 
                <h4 class="attachment-heading"><a href="pogledaj-poslove.php?id=<?php echo $row['id_jobpost']; ?>"><?php echo $row['jobtitle']; ?></a> <span class="attachment-heading pull-right"><?php echo $row['maximumsalary']; ?> RSD/ Mesecno</span></h4>
                <div class="attachment-text">
                    <div><strong><?php echo $row1['imefirme']; ?> | <?php echo $row1['grad']; ?> | Radno Iskustvo <?php echo $row['experience']; ?>   
                    <?php if ($row['experience'] == 1 || $row['experience'] == 5) {
                      echo "Godina";
                    } else if ($row['experience'] > 1) {
                      echo "Godine";
                    } ?></strong></div>
                </div>
              </div>
            </div>
          <?php
              }
            }
            }
          }
          ?>

          </div>
        </div>
      </div>
    </section>

    <section id="candidates" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center latest-job margin-bottom-20">
            <h1>Kandidati</h1>
            <p>Pronalaženje posla je postalo lakše. Kreirajte profil i prijavite se za posao jednim klikom miša.</p>            
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail candidate-img">
              <img src="img/browse.jpg" alt="Pretrazi Poslove">
              <div class="caption">
                <h3 class="text-center">Pretraži Poslove</h3>
              </div>
            </div>
          </div>
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail candidate-img">
              <img src="img/interviewed.jpeg" alt="Prijavi se za Intervju">
              <div class="caption">
                <h3 class="text-center">Prijavi se za Intervju</h3>
              </div>
            </div>
          </div>
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail candidate-img">
              <img src="img/career.jpg" alt="Start A Career">
              <div class="caption">
                <h3 class="text-center">Započni karijeru</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="poslodavac" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center latest-job margin-bottom-20">
            <h1>Poslodavci</h1>
            <p>Trebaju vam radnici? registrujte se kao poslodavac i kacite oglase za posao</p>            
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail poslodavac-img">
              <img src="img/postjob.png" alt="Pretrazi Poslove">
              <div class="caption">
                <h3 class="text-center">Napravite oglas</h3>
              </div>
            </div>
          </div>
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail poslodavac-img">
              <img src="img/manage.jpg" alt="Prijavi se za Intervju">
              <div class="caption">
                <h3 class="text-center">Upravljanje i praćenje</h3>
              </div>
            </div>
          </div>
          <div class="col-sm-4 col-md-4">
            <div class="thumbnail poslodavac-img">
              <img src="img/hire.png" alt="Start A Career">
              <div class="caption">
                <h3 class="text-center">Zaposlenje</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="statistics" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center latest-job margin-bottom-20">
            <h1>Statiskika Sajta</h1>
          </div>
        </div>
        <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
             <?php
                      $sql = "SELECT * FROM oglasi_za_posao";
                      $result = $conn->query($sql);
                      if($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                    ?>
              <h3><?php echo $totalno; ?></h3>

              <p>Poslovne Ponude</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paper"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
                  <?php
                      $sql = "SELECT * FROM poslodavac WHERE active='1'";
                      $result = $conn->query($sql);
                      if($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                    ?>
              <h3><?php echo $totalno; ?></h3>

              <p>Registrovani Poslodavci</p>
            </div>
            <div class="icon">
                <i class="ion ion-briefcase"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
             <?php
                      $sql = "SELECT * FROM kandidati WHERE rezime!=''";
                      $result = $conn->query($sql);
                      if($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                    ?>
              <h3><?php echo $totalno; ?></h3>

              <p>CV / Rezime</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-list"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
               <?php
                      $sql = "SELECT * FROM kandidati";
                      $result = $conn->query($sql);
                      if($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                    ?>
              <h3><?php echo $totalno; ?></h3>

              <p>Registorvani Kandidati</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      </div>
    </section>

    <section id="about" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center latest-job margin-bottom-20">
            <h1>O nama</h1>                      
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <img src="img/onama.png" class="img-responsive">
          </div>
          <div class="col-md-6 about-text margin-bottom-20">
            <p> <p>Aplikacija <strong>oglasi za posao</strong> napravljena za projekat iz Programiranje Interenet Aplikacija, zamišljena je da omogućava kandidatima koji traže posao i poslodavcima da se povežu. Aplikacija pruža mogućnost kandidatima koji traže posao da kreiraju svoje naloge, uploaduju svoj profil i CV, traže poslove, apliciraju za posao, pregledaju različita slobodna radna mesta. Aplikacija pruža mogućnost poslodavcima da kreiraju svoje naloge, traže kandidate, kreiraju oglase za posao i pregledaju prijave kandidata.
            </p>
            <p>Tehnologija koricena za izradu ove web aplikacija za Backend - PHP Vanila, Baza - MySQL phpmyadmin, Front - HTML/CSS, JS, JQuery i Bootstrap, koristili smo Boostrapov Template AdminLTE za CSS, JS i JQuery .        
            </p>
            <p> Aplikaciju su radili studenti Fakulteta Inzenjerskih Nauka, <strong>Petar Novakovic i Nikola Mirovic </strong>, smer RTSI kao zavrsni projekat predmeta PIA za februarski rok
            </p>
          </div>
        </div>
      </div>
    </section>

  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left: 0px;">
  <div class="text-center">
      <strong>Petar Novakovic & Nikola Mirovic &copy; 2023 <a href="https://github.com/pnkg99/oglasi_za_posao_app">Oglasi za posao</a>.</strong>
    </div>
  </footer>

  <div class="control-sidebar-bg"></div>

</div>
<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>
</html>
