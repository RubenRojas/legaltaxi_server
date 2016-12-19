function mueveReloj(){ 
    momentoActual = new Date();
    hora = momentoActual.getHours();
    minuto = momentoActual.getMinutes();
    segundo = momentoActual.getSeconds();

    hora<10 ? hora = "0"+hora : hora = hora;
    minuto<10 ? minuto = "0"+minuto : minuto = minuto;
    segundo<10 ? segundo = "0"+segundo : segundo = segundo;
    
    horaImprimible = hora + " : " + minuto + " : " + segundo 
    $("#reloj").html(horaImprimible);
    setTimeout("mueveReloj()",1000) 
}   
function menu(){
  $(document).find("li.has-drop > a").each(function(index,element){   
    var icono = "<i class=\"fa fa-angle-down\"></i>";
    $(element).append(icono);
    $(element).click(function(){
        if($(element).parent().hasClass('activo')){
            $(element).parent().removeClass('activo');
        }
        else{
            $(element).parent().addClass('activo');
        }
        
    });
  });
}