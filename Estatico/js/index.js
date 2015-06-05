var menu=document.getElementById("menu");
var desplegable=document.getElementById("desplegable");
var contenido=document.getElementById("contenido");
var bandera=false;
var banderaClick=false;


function mostrarDesplegable(){
	desplegable.style.marginLeft="0";
	if(window.innerWidth>=1200){
		contenido.style.width="76%";
	}else if(window.innerWidth>=992 && window.innerWidth<1992){
		contenido.style.width="68%";
	}else if(window.innerWidth>=768 && window.innerWidth<992){
		contenido.style.width="60%";
	}
}

function ocultarDesplegable(){
	if(!banderaClick){

		if(window.innerWidth>=1200){
			contenido.style.width="94%";
			desplegable.style.marginLeft="-18%";
		}else if(window.innerWidth>=992 && window.innerWidth<1992){
			contenido.style.width="92%";
			desplegable.style.marginLeft="-24%";
		}else if(window.innerWidth>=768 && window.innerWidth<992){
			contenido.style.width="90%";
			desplegable.style.marginLeft="-30%";
		}
	}
}

function fijarDesplegable(){
	if(!bandera){
		bandera=true;
		mostrarDesplegable();
		banderaClick=true;
	}else{
		bandera=false;
		ocultarDesplegable();
		banderaClick=false;
	}
}

menu.addEventListener("mouseenter", mostrarDesplegable);
menu.addEventListener("mouseleave", ocultarDesplegable);
menu.addEventListener("click", fijarDesplegable);
