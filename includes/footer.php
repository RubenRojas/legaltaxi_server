<script>
		$(".close").click(function(){
			$("#nueva_carrera").removeClass("slideInRight");
			$("#nueva_carrera").addClass("slideOutRight");
			setTimeout(function(){
				$("#nueva_carrera").removeClass("active");
			}, 800);
			$("#detalle_carrera").removeClass("slideInLeft");
			$("#detalle_carrera").addClass("slideOutLeft");
			setTimeout(function(){
				$("#detalle_carrera").removeClass("active");
			}, 800);
			$("#overlay").removeClass("active");
		});
		$("#cerrar").click(function(){
			$("#nueva_carrera").removeClass("slideInRight");
			$("#nueva_carrera").addClass("slideOutRight");
			setTimeout(function(){
				$("#nueva_carrera").removeClass("active");
			}, 800);
			$("#detalle_carrera").removeClass("slideInLeft");
			$("#detalle_carrera").addClass("slideOutLeft");
			setTimeout(function(){
				$("#detalle_carrera").removeClass("active");
			}, 800);
			$("#overlay").removeClass("active");
		});
		function nueva_carrera(){
			$("html, body").animate({ scrollTop: 0 }, "slow");
			$("#nueva_carrera").removeClass("slideOutRight");
			$("#nueva_carrera").addClass("slideInRight");
			$("#nueva_carrera").addClass("active");
			$("#overlay").addClass("active");
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			var hh = today.getHours();
			var min = today.getMinutes();
			if(dd<10) {
			    dd='0'+dd
			} 
			if(mm<10) {
			    mm='0'+mm
			} 
			if(hh<10) {
			    hh='0'+hh
			} 
			if(min<10) {
			    min='0'+min
			} 
			var fecha =  yyyy+'-'+mm+'-'+dd;
			var hora = 	hh+":"+min+":00";
			console.log(fecha);
			console.log(hora);
			$("#fecha").val(fecha);
			$("#hora").val(hora);
			set_tiempo_atencion_central(<?=$usuario['central'] ?>);	
		}
		function setReserva(){
			$("#reserva").val("true");
		}
		function set_tiempo_atencion_central(id){
			console.info("set_tiempo_atencion_central");
			var url= baseDir+"get_tiempo_atencion.php?id="+id;
			var datos=crearXMLHttpRequest();
			datos.onreadystatechange = function(){
				if(datos.readyState==1){
				}
				else if(datos.readyState==4){
					if(datos.status==200){
						var data = $.parseJSON(datos.responseText);
						$("#tiempo_atencion_central").html(data['valor']);		
						if(data['id']==4){
							$("#boton_pedir_carrera").prop('disabled', 'disabled');
						}
						else{
							$("#boton_pedir_carrera").prop('disabled', false);
						}
						
					}
				}  
			};
			datos.open("GET", url, true);
			datos.send(null);
		}
		function continuar_espera(id_carrera){
			var url= baseDir+"carrera/continuar_espera.php?id_carrera="+id_carrera;
			var datos=crearXMLHttpRequest();
			datos.onreadystatechange = function(){
				if(datos.readyState==1){
				}
				else if(datos.readyState==4){
					if(datos.status==200){
					}
				}  
			};
			datos.open("GET", url, true);
			datos.send(null);
		}
		$(document).ready(function(){
			 $('.modal-trigger').leanModal();
			 Materialize.updateTextFields();
			 $('select').material_select();
		 	 $(".button-collapse").sideNav();
		 	 $('.star').raty();
		 	
		});
		<?php
		if($_SESSION['mensaje']!=""){
			?>
			Materialize.toast('<?=$_SESSION['mensaje']?>', 4000);
			<?php
			unset($_SESSION['mensaje']);
		}
		?>
	</script>
	</body>
</html>