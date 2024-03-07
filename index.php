<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Formulario de Registro</title>
	<link rel="stylesheet" type="text/css" href="./CSS/forma.css">
</head>
<body>
		<form action="registro.php"  method="POST">
			<div id="container">
				  <h1> Cámara de Comercio e Industria de Tegucigalpa </h1>
				  <div class="underline">
				  </div>
				  <div class="icon_wrapper">
				   <center><img    src="https://static.wixstatic.com/media/454fda_680644deb4cd4fbeb1e8e6b5bf3b79a5~mv2.png/v1/fill/w_205,h_89,al_c,q_80,usm_0.66_1.00_0.01/454fda_680644deb4cd4fbeb1e8e6b5bf3b79a5~mv2.webp">
				     </center>
				  </div>
				  <form action="#" method="post" id="contact_form">
					    <div class="name">
					      <label for="name"></label>
					      <input type="text" placeholder="Código Cliente" name="id" id="id_input" required>
					    </div>
					    <!--<div class="email">
					      <label for="email"></label>
					      <input type="email" placeholder="Empresa" name="empresa" id="empresa_input" required>
					    </div>
					    <div class="identidad">
					      <label for="identidad"></label>
					      <input type="text" placeholder="N° Identidad" name="identidad" id="identidad_input" required>
					    </div>
					    <div class="telephone">
					      <label for="telephone"></label>
					      <input type="text" placeholder="telefono" name="telephone" id="telephone_input" required>
					    </div>
					    <div class="empresa">
					      <label for="empresa"></label>
					      <input type="text" placeholder="empresa" name="empresa" id="empresa_input" required>
					    </div>-->
						
					    <!--<div class="subject">
					      <label for="subject"></label>
					      <select placeholder="Subject line" name="subject" id="subject_input" required>
					        <option disabled hidden selected>Presente:</option>
					        <option>REPRESENTANTE</option>
					        <option>REPRESENTADO</option>
					      </select>
					    </div>-->

						<!--SELECT COMO CAMPO OBLIGATORIO-->
						<div class="subject">
							<select placeholder="Subject line" name="subject" id="subject_input" required>
								<option value="" disabled hidden selected>Presente:</option>
								<option value="REPRESENTANTE">REPRESENTANTE</option>
								<option value="REPRESENTADO">REPRESENTADO</option>
							</select>
						</div>

					    <form>
						
							<center>
						    	<div class="submit">
						      		<input type="submit" value="Registrar Voto" id="form_button" />
						    	</div>
					    	</center>
				  		</form>
					  </form>
				    </form><!-- // End form -->

			</div><!-- // End #container -->

		</form>
	</form>
</body>
</html>