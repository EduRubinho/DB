<?php require_once("layout/header.php")?>
<h1 class="text-center">EDITAR</h1>
<hr>
<form action="" method="get">
 <?php
 foreach($dato as $key => $value):
	foreach($value as $v):
	?>
	<label for="">TITULO</label> <br>
	<input type="text" value="<?php echo $v['titulo']?>" name="titulo"> <br>
	<label for="">DURACION (min)</label> <br>
	<input type="text" value="<?php echo $v['duracion_min']?>" name="duracion"> <br>
	<label for="">CLASIFICACION</label> <br>
	<input type="text" value="<?php echo $v['clasificacion']?>" name="clasificacion"> <br>
	<label for="">GENERO</label> <br>
	<input type="text" value="<?php echo $v['genero']?>" name="genero"> <br>
	<label for="">SINOPSIS</label> <br>
	<input type="text" value="<?php echo $v['sinopsis']?>" name="sinopsis"> <br>
	<label for="">DIRECTOR</label> <br>
	<input type="text" value="<?php echo $v['director']?>" name="director"> <br>
	<label for="">IDIOMA</label> <br>
	<input type="text" value="<?php echo $v['idioma']?>" name="idioma"> <br>
	<label for="">POSTER URL</label> <br>
	<input type="text" value="<?php echo $v['poster_url']?>" name="poster"> <br>
	<label for="">TRAILER URL</label> <br>
	<input type="text" value="<?php echo $v['trailer_url']?>" name="trailer"> <br>
	<label for="">FECHA DE ESTRENO</label> <br>
	<input type="text" value="<?php echo $v['fecha_estreno']?>" name="fechaestreno"> <br>
	<input type="hidden" value="<?php echo $v['id_pelicula']?>" name="id"> <br>
	<input type="submit" class="btn" name="btn" value="ACTUALIZAR"> 
	<input type="hidden" name="m" value="actualizar">
	<?php
	  endforeach;
	endforeach;
	?>
</form>
<?php require_once("layout/footer.php")?>