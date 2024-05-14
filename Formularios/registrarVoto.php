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
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- Site metas -->
    <title>Registro</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="../css/responsive.css">
    <!-- Favicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'><link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="../css/registrarVoto-style.css">
    <link rel="stylesheet" href="../css/header.css">
    <!-- Tweaks for older IEs -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
</head>
<body>
    <!-- partial:index.partial.html -->
    <nav class="nav1">
        <div class="wrapper">
            <div class="logoIMG">
                    <a href="<?php echo ($_SESSION['usuario']['id_rol'] == '1') ? 'indexAdmin.php' : 'indexUsuario.php'; ?>">
                        <img class="small-image" src="../images/logo-transparente.webp" alt="#" />
                    </a>
            </div>

            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links1">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="<?php echo ($_SESSION['usuario']['id_rol'] == '1') ? 'indexAdmin.php' : 'indexUsuario.php'; ?>">INICIO</a></li>
                <li><a href="listado_votos.php">VER VOTOS</a></li>
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

    <br><br><br><br><br><br>
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
                                            <input class="form-control border-light" style="padding: 10px 10px;" type="text" id="id_empresa" placeholder="Ingrese el ID de la empresa y selecciónela" autocomplete="off">
                                            <button type="button" id="clear_search" style="display: none;">X</button>
                                        </div>
                                    <div class="input-group">
                                        <div class="form-control border-light" style="padding: 3px 3px; height: 80px; overflow-y: auto;" id="resultado_empresa">
                                            <ul id="lista_resultados" class="lista-resultados"></ul>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="subject">
                                        <select class="form-control border-light" style="padding: 3px 3px; height: 50px; overflow-y: auto;" placeholder="Subject line" name="subject" id="subject_input" required>
                                            <option value="" disabled hidden selected>Seleccione condición del votante:</option>
                                            <option value="REPRESENTANTE">REPRESENTANTE</option>
                                            <option value="REPRESENTADO">REPRESENTADO</option>
                                        </select>
                                    </div>
                                    <div class="contenedor"></div>
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
        </div>
    </div>
   
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.0.0.min.js"></script>
    <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../js/custom.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="../JS/RegistrarVoto.js"></script>
     <!-- Inactividad JavaScript -->
     <script src="../JS/inactividad.js"></script>
</body>
</html>
