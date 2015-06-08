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

/**Carousel*/
function siguiente(){
    var currentSlide = $('.active-slide');
    var nextSlide = currentSlide.next();

    var currentDot = $('.active-dot');
    var nextDot = currentDot.next();

    if(nextSlide.length === 0) {
      nextSlide = $('.slide').first();
      nextDot = $('.dot').first();
    }
    
    currentSlide.fadeOut(600).removeClass('active-slide');
    nextSlide.fadeIn(600).addClass('active-slide');

    currentDot.removeClass('active-dot');
    nextDot.addClass('active-dot');
}

function anterior(){
	var currentSlide = $('.active-slide');
    var prevSlide = currentSlide.prev();

    var currentDot = $('.active-dot');
    var prevDot = currentDot.prev();

    if(prevSlide.length === 0) {
      prevSlide = $('.slide').last();
      prevDot = $('.dot').last();
    }
    
    currentSlide.fadeOut(600).removeClass('active-slide');
    prevSlide.fadeIn(600).addClass('active-slide');

    currentDot.removeClass('active-dot');
    prevDot.addClass('active-dot');
}

function editarCliente0(){
    editarCliente(0);
}
function editarCliente1(){
    editarCliente(1);
}
function editarCliente2(){
    editarCliente(2);
}
function editarCliente3(){
    editarCliente(3);
}
function editarCliente4(){
    editarCliente(4);
}
function editarCliente5(){
    editarCliente(5);
}
function editarCliente6(){
    editarCliente(6);
}
function editarCliente7(){
    editarCliente(7);
}

function eliminarCliente0(){
    eliminarCliente(0);
}
function eliminarCliente1(){
    eliminarCliente(1);
}
function eliminarCliente2(){
    eliminarCliente(2);
}
function eliminarCliente3(){
    eliminarCliente(3);
}
function eliminarCliente4(){
    eliminarCliente(4);
}
function eliminarCliente5(){
    eliminarCliente(5);
}
function eliminarCliente6(){
    eliminarCliente(6);
}
function eliminarCliente7(){
    eliminarCliente(7);
}

function editarCliente(num){
    var x="ocultar"+num;
    var input=document.getElementById(x);
    var x="formulario"+num;
    var form=document.getElementById(x);

    input.value="editarCliente";
    form.submit();
}

function eliminarCliente(num){
    var x="ocultar"+num;
    var input=document.getElementById(x);
    var x="formulario"+num;
    console.log(x);
    var form=document.getElementById(x);

    input.value="eliminarCliente";
    form.submit();
}



document.getElementById("arrow-next").addEventListener("click", siguiente);
document.getElementById("arrow-prev").addEventListener("click", anterior);
document.getElementById("0editarCliente").addEventListener("click", editarCliente0);
document.getElementById("0eliminarCliente").addEventListener("click", eliminarCliente0);
document.getElementById("1editarCliente").addEventListener("click", editarCliente1);
document.getElementById("1eliminarCliente").addEventListener("click", eliminarCliente1);
document.getElementById("2editarCliente").addEventListener("click", editarCliente2);
document.getElementById("2eliminarCliente").addEventListener("click", eliminarCliente2);
document.getElementById("3editarCliente").addEventListener("click", editarCliente3);
document.getElementById("3eliminarCliente").addEventListener("click", eliminarCliente3);
document.getElementById("4editarCliente").addEventListener("click", editarCliente4);
document.getElementById("4eliminarCliente").addEventListener("click", eliminarCliente4);
document.getElementById("5editarCliente").addEventListener("click", editarCliente5);
document.getElementById("5eliminarCliente").addEventListener("click", eliminarCliente5);
document.getElementById("6editarCliente").addEventListener("click", editarCliente6);
document.getElementById("6eliminarCliente").addEventListener("click", eliminarCliente6);
document.getElementById("7editarCliente").addEventListener("click", editarCliente7);
document.getElementById("7eliminarCliente").addEventListener("click", eliminarCliente7);

