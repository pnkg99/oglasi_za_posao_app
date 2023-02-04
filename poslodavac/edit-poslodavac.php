<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if(empty($_SESSION['id_company'])) {
  header("Location: ../index.php");
  exit();
}

require_once("../db.php");
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
  <link rel="stylesheet" href="../css/AdminLTE.min.css">
  <link rel="stylesheet" href="../css/_all-skins.min.css">
  <!-- Custom -->
  <link rel="stylesheet" href="../css/custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
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
                   
        </ul>
      </div>
    </nav>
  </header>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px;">

    <section id="candidates" class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Dobrodošao <b><?php echo $_SESSION['name']; ?></b></h3>
              </div>
              <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                  <li><a href="index.php"><i class="fa fa-dashboard"></i> Kontrolna Tabla</a></li>
                  <li class="active"><a href="edit-poslodavac.php"><i class="fa fa-tv"></i> Moj Poslodavac</a></li>
                  <li><a href="napravi-oglas-za-posao.php"><i class="fa fa-file-o"></i> Napravite Oglas za Posao</a></li>
                  <li><a href="moji-poslovi.php"><i class="fa fa-file-o"></i> Moji Oglasi za Posao</a></li>
                  <li><a href="aplikacije-za-posao.php"><i class="fa fa-file-o"></i> Prijave za Posao</a></li>
                  <li><a href="sanduce.php"><i class="fa fa-envelope"></i> Postansko Sanduce</a></li>
                  <li><a href="podesavanja.php"><i class="fa fa-gear"></i> Podesavanja</a></li>
                  <li><a href="baza-cv.php"><i class="fa fa-user"></i> Baza CV-a</a></li>
                  <li><a href="../logout.php"><i class="fa fa-arrow-circle-o-right"></i> Odjavi se</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-9 bg-white padding-2">
            <h2><i>Moj Poslodavac</i></h2>
            <p>In this section you can change your poslodavac details</p>
            <div class="row">
              <form action="update-poslodavac.php" method="post" enctype="multipart/form-data">
                <?php
                $sql = "SELECT * FROM poslodavac WHERE id_company='$_SESSION[id_company]'";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-6 latest-job ">
                  <div class="form-group">
                     <label>Ime Poslodavca</label>
                    <input type="text" class="form-control input-lg" name="imefirme" value="<?php echo $row['imefirme']; ?>" required="">
                  </div>
                  <div class="form-group">
                     <label>Website</label>
                    <input type="text" class="form-control input-lg" name="website" value="<?php echo $row['website']; ?>" required="">
                  </div>
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control input-lg" id="email" placeholder="Email" value="<?php echo $row['email']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label>About Me</label>
                    <textarea class="form-control input-lg" rows="4" name="biografija"><?php echo $row['biografija']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-flat btn-success">Updejtuj Profil Poslodavca</button>
                  </div>
                </div>
                <div class="col-md-6 latest-job ">
                  <div class="form-group">
                    <label for="kontakt">Contact Number</label>
                    <input type="text" class="form-control input-lg" id="kontakt" name="kontakt" placeholder="Contact Number" value="<?php echo $row['kontakt']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="grad">Grad</label>
                    <input type="text" class="form-control input-lg" id="grad" name="grad" value="<?php echo $row['grad']; ?>" placeholder="grad">
                  </div>
                  <div class="form-group">
                    <label>Promeni logo Poslodavca</label>
                    <input type="file" name="image" class="btn btn-default">
                    <?php if($row['logo'] != "") { ?>
                    <img src="../uploads/logo/<?php echo $row['logo']; ?>" class="img-responsive" style="max-height: 200px; max-width: 200px;">
                    <?php } ?>
                  </div>
                </div>
                    <?php
                    }
                  }
                ?>  
              </form>
            </div>
            <?php if(isset($_SESSION['uploadError'])) { ?>
            <div class="row">
              <div class="col-md-12 text-center">
                <?php echo $_SESSION['uploadError']; ?>
              </div>
            </div>
            <?php unset($_SESSION['uploadError']); } ?>
            
          </div>
        </div>
      </div>
    </section>

    

  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left: 0px;">

  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>
</body>
</html>
