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

function editarOperario(){
    var x="ocultar0";
    var input=document.getElementById(x);
    var x="formulario0";
    var form=document.getElementById(x);

    input.value="editarOperario";
    form.submit();
}

function eliminarOperario(){
    
    var x="formulario0";
    var form=document.getElementById(x);
    form.submit();
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


document.getElementById("arrow-next").addEventListener("click", siguiente);
document.getElementById("arrow-prev").addEventListener("click", anterior);


