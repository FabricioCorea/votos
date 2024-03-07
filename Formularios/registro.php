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
 <title>Registro</title>
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
 <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
 <!-- Tweaks for older IEs-->
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>
<!-- body -->
<body class="main-layout">



      <!-- end loader -->

      <!-- header -->

      <header>

         <!-- header inner -->

         <div class="header">

            <div class="container">

               <div class="row">

                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">

                     <div class="full">

                        <div class="center-desk">

                           <div class="logo">

                              <a href="index.html"><img src="../images/logo-transparente.webp" alt="#" /></a>

                           </div>

                        </div>

                     </div>

                  </div>

                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">

                     <nav class="navigation navbar navbar-expand-md navbar-dark ">

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">

                        <span class="navbar-toggler-icon"></span>

                        </button>

                        

                        <div class="collapse navbar-collapse" id="navbarsExample04">

                           <ul class="navbar-nav mr-auto">

                              <li class="nav-item active">

                                 <a class="nav-link" href="../index.html">Inicio</a>

                              </li>

                           </ul>

                        </div>

                     </nav>

                  </div>

               </div>

            </div>

         </div>

      </header>

      <!-- end header inner -->

      <!-- end header -->

      <!-- banner -->

      <section class="banner_main">
         <div id="banner1" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <div class="carousel-caption">
                        <div class="row d_flex">
                           <div class="col-md-6">
                              <div class="text-bg">
                                 <h1>Asamblea General</h1>
                                 <div class="input-group">
                                    <input class="form-control border-light" style="padding: 10px 10px;" type="text" id="id_empresa" placeholder="Ingrese el ID de la empresa" autocomplete="off">
                                 </div>
                                 <div class="input-group">
                                    <!-- Elemento donde se mostrarán los resultados -->
                                    <div class="form-control border-light" style="padding: 3px 3px; height: 60px; overflow-y: auto;" id="resultado_empresa">
                                       <ul id="lista_resultados" class="lista-resultados">
                                          <!-- Aquí se mostrarán los resultados -->
                                       </ul>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="subject">
                                    <select class="form-control border-light" style="padding: 3px 3px; height: 50px; overflow-y: auto;" placeholder="Subject line" name="subject" id="subject_input" required>
                                       <option value="" disabled hidden selected>Presente:</option>
                                       <option value="REPRESENTANTE">REPRESENTANTE</option>
                                       <option value="REPRESENTADO">REPRESENTADO</option>
                                    </select>
                                 </div>
                                 <div class="contenedor">
                                 </div>
                                 <br> 
                                 <a href="#" id="registrar_voto_btn" name="registrar_voto">Registrar voto</a>

                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="text_img">
                                 <figure>
                                    <img src="../images/4005929_14930-removebg-preview.png" alt="#">
                                 </figure>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <a class="carousel-control-prev" href="#banner1" role="button" data-slide="prev">
                  <i class="fa fa-chevron-left" aria-hidden="true"></i>
               </a>
               <a class="carousel-control-next" href="#banner1" role="button" data-slide="next">
                  <i class="fa fa-chevron-right" aria-hidden="true"></i>
               </a>
            </div>
         </div>
      </section>

      <!-- end banner -->
    
      <!-- Javascript files-->

      <script src="../js/jquery.min.js"></script>

      <script src="../js/popper.min.js"></script>

      <script src="../js/bootstrap.bundle.min.js"></script>

      <script src="../js/jquery-3.0.0.min.js"></script>

      <!-- sidebar -->

      <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>

      <script src="../js/custom.js"></script>

   





   </body>
<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<script src="../JS/Votos.js"></script>
<!-- Sweet alerts-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
</html>