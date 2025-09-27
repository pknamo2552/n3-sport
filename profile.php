<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>N3 Sport</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="4e.png" rel="icon">
  <link href="4e.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Wallpoet&display=swap" rel="stylesheet">
<style>
  #con0 {
    font-family: 'Wallpoet', sans-serif;
    font-size: 16px;
    font-weight: 400;
    font-style: normal;
  }
   #con1 {
    font-family: 'Wallpoet', sans-serif;
    font-size: 18px;
    font-weight: 400;
    font-style: normal;
  }
  #con2 {
    font-family: 'Wallpoet', sans-serif;
    font-size: 20px;
    font-weight: 400;
    font-style: normal;
  } 
  #con3 {
    font-family: 'Wallpoet', sans-serif;
    font-size: 24px;
    font-weight: 400;
    font-style: normal;
  }
  #con4 {
    font-family: 'Wallpoet', sans-serif;
    font-size: 26px;
    font-weight: 700;
    font-style: normal;
  }
  </style>
</head>

<body>


   <!-- ======= Header ======= -->
    <header id="header"  class="header fixed-top d-flex align-items-right">
     
      <img src="logo2.png"  alt="">
  <ul class="nav nav-underline" >
  <ul class="nav nav-pills nav-pills" style="padding-right: 0.1cm;"></ul>
  <li class="nav-item" style="padding-top: 0.07cm;">
    <a class="nav-link" href="profile.php"  id="con4">Profile</a>
  </li>
  <ul class="nav nav-pills nav-pills" style="padding-right: 0.1cm;"></ul>
  <li class="nav-item" style="padding-top: 0.07cm;">
    <a class="nav-link" href="#"  id="con4">Register</a>
  </li>
    <ul class="nav nav-pills nav-pills" style="padding-right: 0.1cm;"></ul>
  <li class="nav-item" style="padding-top: 0.07cm;">
    <a class="nav-link" href="equipment.php"  id="con4">Equipment</a>
  </li>
  <ul class="nav nav-pills nav-pills" style="padding-right: 0.1cm;"></ul>
  <li class="nav-item" style="padding-top: 0.07cm;">
    <a class="nav-link" href="login.php"  id="con4">Login</a>
  </li>
  <ul class="nav nav-pills nav-pills" style="padding-right: 0.1cm;"></ul>
  <li class="nav-item" style="padding-top: 0.07cm;">
    <a class="nav-link" href="#"  id="con4">Logout</a>
  </li>
  
</ul>
  </header><!-- End Header -->

  <!-- End Dashboard Nav -->




      <!-- End F.A.Q Page Nav -->

    

        <!-- Left side columns -->
         <div class="col-lg-12 mt-10 pt-5 d-flex justify-content-between">
      <div class="card mb-5" style="width: 2000px;">
        <div class="row g-0">
    <div class="col-md-4">
  <img src="https://images.seeklogo.com/logo-png/28/1/premier-league-new-logo-png_seeklogo-286461.png" class="img-fluid rounded-start" alt="..." >
  </div>
    <div class="col-md-8">
  <div class="card-body">
    <h5 class="card-title" id="con4">Profile | ข้อมูลส่วนตัว</h5>
<ul class="list-group list-group-flush"> 
  <li class="list-group-item" id="con1">Name: <?php echo $_SESSION["name"]?></li>
  <li class="list-group-item" id="con1">Username: <?php echo $_SESSION["username"]?></li>
  <li class="list-group-item" id="con1">Password: <?php echo $_SESSION["password"]?></li>
  <li class="list-group-item" id="con1">Phone: <?php echo $_SESSION["phone"]?></li>
  <li class="list-group-item" id="con1">E-mail: <?php echo $_SESSION["email"]?></li>
  <li class="list-group-item" id="con1">Status: <?php echo $_SESSION["status"]?></li>
</ul>
    <a href="#" class="btn btn-primary">Edit information</a>
  </div>
</div>

        </div><!-- End Left side columns -->
 </div>
        <!-- Right side columns -->
         

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  
    
    </div>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>