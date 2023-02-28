<?php
/*
  Sistema: Sistema de subida de imágenes por el usuario, permitiendo el acceso a ellas, por un link único.
  info: Este código, permitirá al usuario subir imágenes a un servidor privado, luego podrá acceder a ellas
  mediante un URL, personalizado para esa imagen, que solo poseerá el usuario(UniqID)
  Versión: 1.9
  Código By: Jhon Corella
  
*/
if(isset($_FILES['imagen'])){
    $file_name = $_FILES['imagen']['name'];
    $file_size =$_FILES['imagen']['size'];
    $file_tmp =$_FILES['imagen']['tmp_name'];
    $file_type=$_FILES['imagen']['type'];   
    $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    /*Estos son los formatos de imagen permitidos*/
    $extensions= array("jpeg","jpg","png");      
    if(in_array($extension,$extensions)=== false){
        echo "Solo se permiten imágenes JPEG, JPG y PNG.";
        exit();
    }
    /*Este es el límite, de peso por imagen, en este caso es 30Mb puedes cambiarlo*/
    if($file_size > 30*1024*1024){
        echo 'El archivo debe ser menor de 30MB';
        exit();
    }     
    $random_name = substr(md5(uniqid(mt_rand(), true)), 0, 20);
    $new_file_name = $random_name.'.'.$extension;
    $upload_dir = "./files/";
    /*Acá debes colocar la URL de tú página, ten presente que en el host debes tener el directorio(files)*/
    $url = "http://localhost/MegaImages/files/".$new_file_name;
    if(move_uploaded_file($file_tmp, $upload_dir.$new_file_name)){
        echo "El archivo ".$file_name." ha sido subido exitosamente. <br>";
        echo "Puede acceder a la imagen a través de este enlace: <a href='$url'>$url</a>";
    }else{
        echo "Error al subir el archivo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Subir imagen</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
			padding: 20px;
		}

		h1 {
			text-align: center;
			margin-bottom: 40px;
		}

		#form-container {
			background-color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
			max-width: 600px;
			margin: 0 auto;
		}

		form {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		label {
			font-size: 18px;
			margin-bottom: 10px;
		}

		input[type="file"] {
			border: 2px solid #ccc;
			padding: 10px;
			border-radius: 5px;
			width: 100%;
			max-width: 400px;
			margin-bottom: 20px;
		}

		input[type="submit"] {
			background-color: #4CAF50;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			font-size: 18px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		input[type="submit"]:hover {
			background-color: #3e8e41;
		}
        /*Esto es para un sistema de notificaciones que nunca termine*/
		#notification {
			display: none;
			position: fixed;
			top: 20px;
			right: 20px;
			background-color: #4CAF50;
			color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
			z-index: 1;
			animation: fadein 0.5s, fadeout 0.5s 2.5s;
		}

		@keyframes fadein {
			from {top: 0; opacity: 0;}
			to {top: 20px; opacity: 1;}
		}

		@keyframes fadeout {
			from {top: 20px; opacity: 1;}
			to {top: 0; opacity: 0;}
		}

		#file-link {
			display: none;
			position: fixed;
			bottom: 0;
			left: 0;
			background-color: #4CAF50;
			color: #fff;
			padding: 20px;
			border-radius: 5px 0 0 0;
			box-shadow: 0px -5px 20px rgba(0, 0, 0, 0.2);
			z-index: 1;
			width: 100%;
			transition: bottom 0.3s ease;
			box-sizing: border-box;
			font-size: 16px;
		}

		#file-link input[type="text"] {
			background-color: transparent;
			color: #fff;
			border: none;
			font-size: 16px;
			width: 80%;
			padding:
		5px;
		box-sizing: border-box;
		margin-right: 10px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	#file-link button {
		background-color: transparent;
		border: none;
		color: #fff;
		font-size: 16px;
		cursor: pointer;
		transition: color 0.3s ease;
	}

	#file-link button:hover {
		color: #ccc;
	}

	#file-link.show {
		bottom: -70px;
	}

	@media (max-width: 768px) {
		#file-link input[type="text"] {
			width: 60%;
		}
	}

	@media (max-width: 480px) {
		#file-link input[type="text"] {
			width: 50%;
		}
	}
</style>
</head>
<body>
	<h1>Subir imagen</h1>
	<div id="form-container">
		<form action="" method="POST" enctype="multipart/form-data">
			<label for="file-input">Selecciona una imagen (no mayor de 30 MB):</label>
			<input type="file" id="file-input" name="imagen" accept="image/*" required>
			<input type="submit" value="Subir imagen">
		</form>
	</div>

</body>
</html>
