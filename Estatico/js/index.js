    /**
    * .............................................
    * UNIVERSIDAD  FRANCISCO  DE  PAULA  SANTANDER
    *    PROGRAMA  DE  INGENIERIA   DE   SISTEMAS
    *      LAUNDRYSOFT - LAVA RAPID JEANS S.A.S
    *             SAN JOSE DE CUCUTA-2015
     * ............................................
    */

    /**
    * @author Angie Melissa Delgado León 1150990
    * @author Juan Daniel Vega Santos 1150958
    * @author Edgar Yesid Garcia Ortiz 1150967
    * @author Fernando Antonio Peñaranda Torres 1150684
    */

/**
*	Genera alertas modales
*/
function alerta () {
	var content = "";
	if(arguments.length >= 2){

		content = "<h3>"+arguments[0]+"</h3><p>"+arguments[1]+"</p>";
	}else{
		content= "<p>"+arguments[0]+"</p>";
	}

	var div = document.createElement("div");
	var claseDiv = "alerta";
	div.setAttribute("class", claseDiv);
	div.innerHTML = content;
	document.body.appendChild(div);
	setTimeout(function() {
		div.style.opacity = "0";
	}, arguments[2] || 10000);
	setTimeout(function() {
		document.body.removeChild(div);
	}, arguments[2]+1000 ||  11000);
}



$('.eliminarCliente').on("click", function eliminarOperario(){
    $(this).children().submit();
});

$('.editarCliente').on("click", function eliminarOperario(){
    $(this).children().submit();
});

$('.eliminarOperario').on("click", function eliminarOperario(){
    $(this).children().submit();
});

$('.editarOperario').on("click", function eliminarOperario(){
    $(this).children().submit();
});

$('.editarSolicitudOperario').on("click", function eliminarOperario(){
    $(this).children().submit();
});

$('.editarSolicitudCliente').on("click", function eliminarOperario(){
    $(this).children().submit();
});

function resize(){

}

$(document).ready(function() {
    /*$('#pedido').DataTable( {
        scrollY:        '50vh',
        scrollCollapse: true,
        paging:         false
    } );*/

if ( $.fn.dataTable.isDataTable( '#pedido' ) ) {
    table = $('#pedido').DataTable({
        paging: false
    });
}
else {
    table = $('#pedido').DataTable( {
        paging: false
    } );
}

if ( $.fn.dataTable.isDataTable( '#usuario' ) ) {
    table = $('#usuario').DataTable({
        paging: false
    });
}
else {
    table = $('#usuario').DataTable({
        paging: false
    });
}

if ( $.fn.dataTable.isDataTable( '#cotizacion' ) ) {
    table = $('#cotizacion').DataTable({
        paging: false
    });
}
else {
    table = $('#cotizacion').DataTable({
        paging: false
    });
}


} );

