<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
   
   <style>   
    
    
body {
	color: #202e42;
     background-repeat: no-repeat;
	 background-size: cover;
     display: flex;
     justify-content: center;
	font-family: 'Varela Round', sans-serif;
	font-size: 13px;
}
.table-responsive {
    margin: 10px 0;
}
.table-wrapper {
	background: #FFFFFF;
	padding: 20px 15px;
	border-radius: 3px;
	min-width: 1280px;
	box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {        
	padding-bottom: 15px;
	background: #34495E;
	color: #FFFFFF;
	padding: 16px 30px;
	min-width: 100%;
	margin: -2px -2px 10px;
	border-radius: 3px 3px 0 0;
}
.table-title h2 {
	margin: 5px 0 0;
	font-size: 24px;
}
/*Botones editar y eliminar */
.btn-icon {
    background: none;
    border: none;
    padding: 0;
}

.btn-edit {
    color: #007bff; 
}

.btn-delete {
    color: #dc3545; 
}

.btn-edit:hover,
.btn-delete:hover {
    background-color:  #ffc107;
}

.table-striped thead {
    background: #34495E;
    color: #FFFFFF; 
}

.scrollable-cell {
    max-width: 45px; 
    overflow-x: auto; 
}
.busqueda_input{
    margin-bottom: 20px;
}

</style>

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
