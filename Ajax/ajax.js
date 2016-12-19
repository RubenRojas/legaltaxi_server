var baseDir = "/legaltaxi/Ajax/php/";
var loader = "Cargando ... ";
var preloader ='<div class="preloader-wrapper active">'+
    '<div class="spinner-layer spinner-red-only">'+
      '<div class="circle-clipper left">'+
        '<div class="circle"></div>'+
      '</div><div class="gap-patch">'+
        '<div class="circle"></div>'+
      '</div><div class="circle-clipper right">'+
        '<div class="circle"></div>'+
      '</div>'+
    '</div>'+
  '</div>';
//***************************************
// UPDATE
//***************************************
/*
function turno(id, accion){	
	console.info("function: turno");
	$.ajax({
	      type: 'POST',
	      url: baseDir+'/movil/update_turno.php?accion='+accion+'&id='+id,
	      data: $("#inicia_turno").serialize(),
	      dataType: "html",
	      success: function () {	
	      	console.info("function: ()");
	      	update_fila_tabla_moviles(id);
	      	//location.reload();
	      },
	      error: function(){
	      }
	});
}
*/

function detalle_carrera(id){
	var url= baseDir+"carrera/detalleCarrera.php?id="+id;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
			$("#contenido_carrera").html('<div class="detalle_carrera"><div class="row">'+preloader+'</div></div>');
			$("#overlay").addClass("active");
			$("#detalle_carrera").removeClass("slideOutLeft");
			$("#detalle_carrera").addClass("slideInLeft");
			$("#detalle_carrera").addClass("active");
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				$("#contenido_carrera").html(datos.responseText);		
			}
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}
function crear_nueva_carrera(){
	
	
	$("#loader_carrera").css("display", "inline");
	$.ajax({
	      type: 'POST',
	      url: baseDir+'carrera/crear_carrera.php',
	      data: $("#nueva_carrera_form").serialize(),
	      dataType: "html",
	      success: function (data) {
	      	location.replace("enRuta.php");
	      },
	      error: function(){
	      }
	});
}

function actualizar_carrera(){
	console.log("Actualizar Carrera");
	$("#loader_carrera").css("display", "inline");
	$.ajax({
	      type: 'POST',
	      url: baseDir+'carrera/update_carrera.php',
	      data: $("#actualizar_carrera").serialize(),
	      dataType: "html",
	      success: function (data) {
	      	location.replace("enRuta.php");
	      },
	      error: function(){
	      }
	});
}
//***************************************
//Funciones para DASH
//***************************************
function update_central(ciudad){
	$("#central").prop('disabled', 'disabled');
	var url= baseDir+"get.php?tipo=centrales&ciudad="+ciudad;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
			
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				$("#central").html(datos.responseText);		
				$("#central").prop('disabled', false);
			}
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}
function a_bordo(id_carrera){
	$("#loader_carrera").css("display", "inline");
	var url= baseDir+"carrera/a_bordo.php?id_carrera="+id_carrera;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
			
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				location.replace("califica.php");
			}
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}
function termina_carrera(chofer,taxi,tiempos,general,id_carrera){
	$("#loader_carrera").css("display", "inline");
	var url= baseDir+"carrera/califica_carrera.php?id_carrera="+id_carrera+"&chofer="+chofer+"&taxi="+taxi+"&tiempos="+tiempos+"&general="+general;
	var datos=crearXMLHttpRequest();
	datos.onreadystatechange = function(){
		if(datos.readyState==1){
			
		}
		else if(datos.readyState==4){
			if(datos.status==200){
				location.replace("dash.php");
			}
		}  
	};
	datos.open("GET", url, true);
	datos.send(null);
}
//***************************************
//Funciones para LOGIN
//***************************************
function inicia_sesion(){
	$.ajax({
	      type: 'POST',
	      url: baseDir+'/login/guarda_usuario.php',
	      data: $("#login_form").serialize(),
	      dataType: "html",
	      success: function (data) {	
	      	console.log(data);
	      	if(data == 1){
	      		location.replace("completaDatos.php");	
	      	}
	      	else{
	      		location.replace("dash.php");
	      	}
	      	
	      },
	      error: function(){
	      }
	});
}
//***************************************
//Funciones comunes a todos los problemas
//***************************************
function crearXMLHttpRequest(){	
  var xmlHttp=null;
  if (window.ActiveXObject){
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  else{ 
    if (window.XMLHttpRequest){
      xmlHttp = new XMLHttpRequest();
    }
  }
  return xmlHttp;
  console.info("function: crearXMLHttpRequest");
}