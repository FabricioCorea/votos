<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>

<body>
<div class="table-responsive">
    <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Gestión de <b>Empresas</b></h2>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <div class="agregar-container" style="float: right;">
                            <div class="AgregarVoto">
                                <div class="input-group">
                                    <button class="btn btn-success" style="background-color: #26a042; color: white; margin-left: 15px;" data-bs-toggle="modal" data-bs-target="#addVotoModal">
                                        <i class="material-icons" style="color: white;">&#xE147;</i> <span>Agregar</span>
                                    </button>
                                </div>
                           </div>
                        </div>
                    </div>
                    </div>
                </div>
      

    <form action="../controller/index.php" method="get">
        <input type="text" name="busqueda" class="busqueda_input" placeholder="Buscar..." value="<?php echo isset($_GET['busqueda']) ? $_GET['busqueda'] : '' ?>">
        <button type="submit">Buscar</button>
    </form>
    <table class="table table-striped" border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Representante</th>
            
            <!-- Agregar más campos según tu estructura de datos -->
        </tr>
             </thead>
      
        <?php if (isset($registros) && is_array($registros)): ?>
    <?php foreach ($registros as $registro): ?>
        <tr>
            <td><?php echo $registro['id']; ?></td>
            <td><?php echo $registro['empresa']; ?></td>
            <td><?php echo $registro['representante']; ?></td>
            <!-- Mostrar más campos según tu estructura de datos -->
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="3">No se encontraron registros.</td>
    </tr> 
           
    </table>  
    </div> 
</div> 
<?php endif; ?>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
