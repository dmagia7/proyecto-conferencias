<?php include_once 'includes/templates/header.php'; ?>

	  </section><!--Seccion-->

	  <section class="seccion contenedor">
	  	<h2>Calendario de eventos</h2>
	  	<?php
	  		try{
	  			require_once('includes/funciones/bd_conexion.php');
	  			$sql = " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado ";
	  			$sql .= " FROM eventos ";
	  			$sql .= " INNER JOIN categoria_evento ";
	  			$sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
	  			$sql .= " INNER JOIN invitados ";
	  			$sql .= " ON eventos.id_inv = invitados.invitado_id ";
	  			$sql .= " ORDER BY evento_id ";
	  			$resultado = $conn->query($sql);
	  		} catch(\exception $e){
	  			echo $e->getMessage();
	  		} 
	  	?>

	  	<div class="calendario ">
			<?php
				$calendario =array();
				while($eventos = $resultado->fetch_assoc() ) {

					//=btiene la fecha del Evento
					$fecha = $eventos['fecha_evento'];
					$categoria = $eventos['cat_evento'];
					 $evento = array(
					 	'titulo' => $eventos['nombre_evento'],
					 	'fecha' => $eventos['fecha_evento'],
					 	'hora' => $eventos['hora_evento'],
					 	'categoria' => $eventos['cat_evento'],
					 	'icono' => $eventos['icono'],
					 	'invitado' => $eventos['nombre_invitado'] . " " . $eventos['apellido_invitado']
					 	);

				$calendario[$fecha][]=$evento;
			?>
			<?php } ?>
			<div class="dia-evento">
				<?php  
				//imprime todos los Eventos
					foreach ($calendario as $dia => $lista_eventos) {?>
					<h3>
						<i class="fa fa-calendar-alt"></i>
						<?php  
							setlocale(LC_TIME, 'spanish');
							echo strftime("%A, %d de %B del %Y", strtotime($dia)); 
						?>
					</h3>
			</div>
			<div class="eventos-dia">
					<?php foreach ($lista_eventos as $evento) { ?>
						<div class="dia-calendario">
							<p class="titulo"><?php echo $evento['titulo']; ?></p>
							<p class="hora">
								<i class="far fa-clock" aria-hidden="true"></i>
								<?php echo $evento['hora']  ; ?>
							</p>
							<p >
								<i class="<?php echo $evento['icono']; ?>" aria-hidden="true"></i>
								<?php echo $evento['categoria']; ?>
							</p>
							<p class="invitado">
								<i class="fa fa-user" aria-hidden="true"></i>
								<?php echo $evento['invitado']?>
							</p>
						</div>
	  		
					<?php } //Fin forEach de eventos?>
				<?php }	//fin for Ecah de dias?>
			</div>
	  	</div>
	  	<?php 
	  		$conn->close(); 
	  	?>

	  </section>

<?php include_once 'includes/templates/footer.php'; ?>