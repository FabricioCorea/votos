<?php
session_start(); // Iniciar la sesión

$varsesion = $_SESSION['usuario'];
    if($varsesion == null || $varsesion ==''){
        header("location: ../Formularios/login.php");
        die();
    }
?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Inicio</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="../css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="../css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="../css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'><link rel="stylesheet" href="./style.css">
      <link rel="stylesheet" href="../css/header.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
 
   </head>

   <!-- body -->
    <body class="main-layout inner_header service_page">
      <nav class="nav1">
         <div class="wrapper">
             <div class="logoIMG">
             <a href="<?php echo ($_SESSION['usuario']['id_rol'] == '1' || $_SESSION['usuario']['id_rol'] == '0') ? 'indexAdmin.php' : 'indexUsuario.php'; ?>">
               <img class="small-image" src="../images/logo-transparente.webp" alt="#" />
            </a>
             </div>
 
             <input type="radio" name="slider" id="menu-btn">
             <input type="radio" name="slider" id="close-btn">
             <ul class="nav-links1">
                 <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>

               
                 <li>
                         <a href="#" class="desktop-item">
                             <span class="icon-right"> 
                             <i class="fas fa-user"></i> 
                             </span>
                             <?php echo $_SESSION['usuario']['usuario']; ?>
                         </a>
                 </li>
                 <li><a href="logout.php"> <i title="Cerrar Sesión" class="fas fa-sign-out-alt"></i></a><span class="sr-only">Cerrar Sesión&gt;</span></a></li>
             </ul>
         </div>
     </nav>
      <!-- services -->
        <div  class="services">
            
            <div class="container mt-3">
               <div class="row mt-3">
                  </br>
                  </br>
                  </br>
                  </br>
                  </br>
                  </br>
                  <div class="col-md-10 offset-md-30 mt-3">
                     <div class="titlepage_menu">
                        <h2>Seleccione una opción...</h2>                        
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div id="servicio_voto" class="col-md-3">
                     <div id="serv_hover"  class="services_box">
                        <i><img src="../images/votacion (3) (4).png" alt="#"/></i>
                        <h3>Registrar Voto</h3>
                        <a class="right_irro" href="../Formularios/registrarVoto.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                     </div>
                  </div>
                  <div id="servicio_ver_voto" class="col-md-3">
                     <div id="serv_hover"  class="services_box">
                        <i><img src="../images/list_2285516 (1).png" alt="#"/></i>
                        <h3>Ver Votos</h3>
                        <a class="right_irro" href="../Formularios/listado_votos.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                     </div>
                  </div>
             
                  <div id="servicio_empresa" class="col-md-3">
                     <div id="serv_hover" class="services_box">
                        <i><img src="../images/empresa.png" alt="#"/></i>
                        <h3>Registrar Empresa</h3>
                        <a class="right_irro" href="../Formularios/empresas.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                     </div>
                  </div>
                  <div id="servicio_usuarios" class="col-md-3">
                     <div id="serv_hover" class="services_box">
                        <i><img src="../images/user_456283 (1) (1).png" alt="#"/></i>
                        <h3>Gestión de Usuario</h3>
                        <a class="right_irro" href="../Formularios/usuarios.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                     </div>
                  </div>               
               </div>  
           
            </div>
        </div>

               <!-- Javascript files-->
               <script src="../js/jquery.min.js"></script>
               <script src="../js/popper.min.js"></script>
               <script src="../js/bootstrap.bundle.min.js"></script>
               <script src="../js/jquery-3.0.0.min.js"></script>
               <!-- sidebar -->
               <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
               <script src="../js/custom.js"></script>
               <!-- Inactividad JavaScript -->
               <script src="../JS/inactividad.js"></script>
   </body>
</html>