$('.input-number').on('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});
$("#siguiente").click(function() {
    index = $("#index").val();
    $(".error").remove();
    switch (index) {
        case "0":
            valid = 1;
            $(".paquete").each(function() {
                if ($(this).val() == "" || $(this).val() == null) {
                    $(this).addClass("is-invalid");
                    $(this).parent().append("<label style='color:red' class='error'>Este campo es obligatorio</label>")
                    valid = 0;
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            if (valid == 1) {
                $("#modal").modal();
            } else {
                $("#btn-comprobante").addClass("disabled");
                $("#btn-pago").addClass("disabled");
            }
            $("#aceptar").click(function() {
                $("#paquete").removeClass("d-block").addClass("d-none");
                $("#comprobante").removeClass("d-none").addClass("d-block");
                $("#btn-paquete").removeClass("btn-primary").addClass("btn-purple");
                $("#btn-comprobante").removeClass("disabled btn-secondary btn-purple").addClass("btn-primary");
                $("#anterior").removeClass("disabled");
                $("#index").val(1);
            });
            break;
        case "1":
            valid = 1;
            if ($("#tipo-comprobante").val() == "factura") {
                $(".comprobante").each(function() {
                    if ($(this).val() == "" || $(this).val() == null) {
                        $(this).addClass("is-invalid");
                        $(this).parent().append("<label style='color:red' class='error'>Este campo es obligatorio</label>")
                        valid = 0;
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });
            }
            if ($("#tipo-comprobante").val() == "" || $("#tipo-comprobante").val() == null) {
                $("#tipo-comprobante").parent().append("<label style='color:red' class='error'>Este campo es obligatorio</label>");
                valid = 0;
            }
            if (valid == 1) {
                $.ajax({
                    method: "POST",
                    url: "api/guardaPaquete",
                    data: {
                        id_paquete: $("#id_paquete").val(),
                        periodos: $("#periodos").val(),
                        adicionales: $("#adicionales").val(),
                        tipo_pago: $("#tipo-pago").val(),
                        comprobante: $("#tipo-comprobante").val(),
                        rfc: $("#rfc").val(),
                        nombre: $("#nombre_razon").val(),
                        calle: $("#calle").val(),
                        numero_exterior: $("#num_ext").val(),
                        numero_interior: $("#numero_int").val(),
                        codigo_postal: $("#cp").val(),
                        colonia: $("#colonia").val(),
                        localidad: $("#localidad").val(),
                        referencia: $("#referencia").val(),
                        municipio: $("#alcaldia").val(),
                        estado: $("#estado").val(),
                    },
                    success: function(reponse) {
                        console.log(reponse);
                    }
                });
                $("#btn-comprobante").removeClass("btn-primary").addClass("btn-purple");
                $("#btn-pago").removeClass("disabled btn-secondary btn-purple").addClass("btn-primary");
                $("#comprobante").removeClass("d-block").addClass("d-none");
                $("#pago").removeClass("d-none").addClass("d-block");
                $("#index").val(2);
                $("#siguiente").addClass("d-none");
                $("#registrar").removeClass("d-none");
            } else {
                $("#btn-cuenta").addClass("disabled");
            }
            break;
    }
});
$("#anterior").click(function() {
    var index = $("#index").val();
    switch (index) {
        case "1":
            $("#btn-paquete").removeClass("btn-purple").addClass("btn-primary");
            $("#btn-comprobante").removeClass("btn-primary").addClass("btn-purple");
            $("#anterior").addClass("disabled");
            $("#paquete").removeClass("d-none").addClass("d-block");
            $("#comprobante").removeClass("d-block").addClass("d-none");
            $("#index").val(0);
            break;
        case "2":
            $("#btn-pago").removeClass("btn-primary").addClass("btn-purple");
            $("#btn-comprobante").removeClass("btn-purple").addClass("btn-primary");
            $("#comprobante").removeClass("d-none").addClass("d-block");
            $("#pago").removeClass("d-block").addClass("d-none");
            $("#siguiente").removeClass("d-none");
            $("#registrar").addClass("d-none");
            $("#index").val(1);
            break;
    }
});
$("#btn-paquete").click(function() {
    var index = $("#index").val();
    switch (index) {
        case "0":
            break;
        case "1":
            $("#paquete").removeClass("d-none").addClass("d-block");
            $("#comprobante").removeClass("d-block").addClass("d-none");
            $("#btn-paquete").removeClass("btn-purple").addClass("btn-primary");
            $("#btn-comprobante").removeClass("btn-primary").addClass("btn-purple");
            break;
        case "2":
            $("#paquete").removeClass("d-none").addClass("d-block");
            $("#pago").removeClass("d-block").addClass("d-none");
            $("#btn-paquete").removeClass("btn-purple").addClass("btn-primary");
            $("#btn-pago").removeClass("btn-primary").addClass("btn-purple");
            $("#siguiente").removeClass("d-none");
            $("#registrar").addClass("d-none");
            break;
    }
    $("#index").val(0);
});
$("#btn-comprobante").click(function() {
    $(".error").remove();
    var index = $("#index").val();
    switch (index) {
        case "0":
            valid = 1;
            $(".paquete").each(function() {
                if ($(this).val() == "" || $(this).val() == null) {
                    $(this).addClass("is-invalid");
                    $(this).parent().append("<label style='color:red' class='error'>Este campo es obligatorio</label>")
                    valid = 0;
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            if (valid == 1) {
                $("#modal").modal();
            } else {
                $("#btn-comprobante").addClass("disabled");
                $("#btn-pago").addClass("disabled");
            }
            $("#aceptar").click(function() {
                $("#paquete").removeClass("d-block").addClass("d-none");
                $("#comprobante").removeClass("d-none").addClass("d-block");
                $("#btn-paquete").removeClass("btn-primary").addClass("btn-purple");
                $("#btn-comprobante").removeClass("disabled btn-secondary btn-purple").addClass("btn-primary");
                $("#anterior").removeClass("disabled");
                $("#index").val(1);
            });
            break;
        case "1":
            break;
        case "2":
            $("#comprobante").removeClass("d-none").addClass("d-block");
            $("#pago").removeClass("d-block").addClass("d-none");
            $("#btn-comprobante").removeClass("btn-purple").addClass("btn-primary");
            $("#btn-pago").removeClass("btn-primary").addClass("btn-purple");
            $("#siguiente").removeClass("d-none");
            $("#registrar").addClass("d-none");
            $("#index").val(1);
            break;
    }
});
$("#btn-pago").click(function() {
    $(".error").remove();
    var index = $("#index").val();
    switch (index) {
        case "0":
            valid = 1;
            valid2 = 0;
            $(".paquete").each(function() {
                if ($(this).val() == "" || $(this).val() == null) {
                    $(this).addClass("is-invalid");
                    $(this).parent().append("<label style='color:red' class='error'>Este campo es obligatorio</label>")
                    valid = 0;
                } else {
                    $(this).removeClass("is-invalid");
                }
            });
            if (valid == 1) {
                $("#modal").modal();
            } else {
                $("#btn-comprobante").addClass("disabled");
                $("#btn-pago").addClass("disabled");
            }
            $("#aceptar").click(function() {
                $("#paquete").removeClass("d-block").addClass("d-none");
                $("#comprobante").removeClass("d-none").addClass("d-block");
                $("#btn-paquete").removeClass("btn-primary").addClass("btn-purple");
                $("#btn-comprobante").removeClass("disabled btn-secondary btn-purple").addClass("btn-primary");
                $("#anterior").removeClass("disabled");
                // $("#index").val(1);
                // valid2=1;
            });
            break;
        case "1":
            valid = 1;
            if ($("#tipo-comprobante").val() == "factura") {
                $(".comprobante").each(function() {
                    if ($(this).val() == "" || $(this).val() == null) {
                        $(this).addClass("is-invalid");
                        $(this).parent().append("<label style='color:red' class='error'>Este campo es obligatorio</label>")
                        valid = 0;
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });
            }
            if ($("#tipo-comprobante").val() == "" || $("#tipo-comprobante").val() == null) {
                $("#tipo-comprobante").parent().append("<label style='color:red' class='error'>Este campo es obligatorio</label>");
                valid = 0;
            }
            if (valid == 1) {
                $.ajax({
                    method: "POST",
                    url: "api/guardaPaquete",
                    data: {
                        id_paquete: $("#id_paquete").val(),
                        periodos: $("#periodos").val(),
                        adicionales: $("#adicionales").val(),
                        tipo_pago: $("#tipo-pago").val(),
                        comprobante: $("#tipo-comprobante").val(),
                        rfc: $("#rfc").val(),
                        nombre: $("#nombre_razon").val(),
                        calle: $("#calle").val(),
                        numero_exterior: $("#num_ext").val(),
                        numero_interior: $("#numero_int").val(),
                        codigo_postal: $("#cp").val(),
                        colonia: $("#colonia").val(),
                        localidad: $("#localidad").val(),
                        referencia: $("#referencia").val(),
                        municipio: $("#alcaldia").val(),
                        estado: $("#estado").val(),
                    },
                    success: function(reponse) {
                        console.log(reponse);
                    }
                });
                $("#btn-comprobante").removeClass("btn-primary").addClass("btn-purple");
                $("#btn-pago").removeClass("disabled btn-secondary btn-purple").addClass("btn-primary");
                $("#comprobante").removeClass("d-block").addClass("d-none");
                $("#pago").removeClass("d-none").addClass("d-block");
                $("#index").val(2);
                $("#siguiente").addClass("d-none");
                $("#registrar").removeClass("d-none");
            } else {
                $("#btn-cuenta").addClass("disabled");
            }
            break;
    }
});

$("#registrar").click(function() {
    $(".error").remove();
    var index = $("#index").val();
    valid = 1;
    $(".cuenta").each(function() {
        if ($(this).val() == "" || $(this).val() == null) {
            $(this).addClass("is-invalid");
            $(this).parent().append("<label style='color:red' class='error'>Este campo es obligatorio</label>")
            valid = 0;
        } else {
            $(this).removeClass("is-invalid");
        }
    });
    if ($("#contrasenia").val() != $("#confir_contrasenia").val()) {
        $("#confir_contrasenia").addClass("is-invalid");
        $(".div-confir_contrasenia").append("<label style='color:red' class='error'>Las contraseñas no coinciden</label>")
        valid = 0;
    } else {
        $("#confir_contrasenia").removeClass("is-invalid");
    }
    if ($("#contrasenia").val() != "" && $("#contrasenia").val() != null) {
        contrasenia = $("#contrasenia").val();
        if (contrasenia.length < 8) {
            $("#contrasenia").addClass("is-invalid").parent().append("<label style='color:red' class='error'>La contraseña debe contener al menos 8 caractéres</label>");
            valid = 0;
        } else if (!(/[a-z]/.test(contrasenia))) {
            $("#contrasenia").addClass("is-invalid").parent().append("<label style='color:red' class='error'>La nueva contraseña debe contener al menos una letra minúscula</label>");
            valid = 0;
        } else if (!(/[A-Z]/.test(contrasenia))) {
            $("#contrasenia").addClass("is-invalid").parent().append("<label style='color:red' class='error'>La nueva contraseña debe contener al menos una letra mayúscula</label>");
            valid = 0;
        }
    }
    if (valid == 1) {
        $.ajax({
            method: "POST",
            url: "api/registrar",
            data: {
                cadena: $("#cadena").val(),
                nombre: $("#nombre").val(),
                paterno: $("#paterno").val(),
                materno: $("#materno").val(),
                nacimiento: $("#nacimiento").val(),
                telefono: $("#telefono").val(),
                celular: $("#celular").val(),
                cedula: $("#cedula").val(),
                clave_cedulas: $("#clave_cedulas").val(),
                profesion: $("#profesion").val(),
                despacho: $("#despacho").val(),
                tipo_iden: $("#tipo_iden").val(),
                num_iden: $("#num_iden").val(),
                calle: $("#calle").val(),
                num_ext: $("#num_ext").val(),
                num_int: $("#num_int").val(),
                colonia: $("#colonia").val(),
                alcaldia: $("#alcaldia").val(),
                cp: $("#cp").val(),
                usuario: $("#usuario").val(),
                contrasenia: $("#contrasenia").val(),
            },
            success: function(response) {
                alert(response);
            }
        });
    }
});

precios_adicionales=0;
adicionales=0;
precio_paquete=0;
precio_adicional=0;
permitidos=0;
paquete_usuario_id=0;
seguimientos_paquete=0

$('#adicionales').on('input',function(){
	$('.error').remove();	
	if (Math.abs($('#adicionales').val())>permitidos && permitidos!=-1) {
		$('#adicionales').parent().append('<label class="tx-danger error">El máximo de adicionales es de '+permitidos+'</label>');
		$('#adicionales').val(permitidos);	
	}
	adicionales=Math.abs($('#adicionales').val());
	precioAdicionales();
    
});

$('#id_paquete').change(function(){
	$('#loading').modal('show');
	adicionales=0;
	$('#adicionales').val(adicionales);
	obtenerPrecios($('#id_paquete').val());
	
	precioTotal();
});

$('#periodos').change(function(){
	precioPaquete();
	precioTotal();
});

function obtenerPrecios(id_paquete){
	$('.error').remove();	
	$.ajax({
		url:"api/getPrecios",
		method:"POST",
		data:{
			id_paquete:id_paquete
		},
		success:function(response){
			precio_paquete=response.precio_paquete[0].paquete_precio;

			precioPaquete();

			$('#incluidos').val(response.precio_paquete[0].paquete_incluidos);

			$('#loading').modal('hide');

			if (response.precio_paquete[0].paquete_adicionales_permitidos==-1) {
					precios_adicionales=[];

					$.each(response.precios_adicionales, function(index, precio){
						adicional=new Object();
						adicional['minino']=precio.paquete_adicional_min_adicionales;
						adicional['maximo']=precio.paquete_adicional_max_adicionales;
						adicional['precio']=precio.adicional_precio;
						precios_adicionales.push(adicional);
					})

				}else{
					precios_adicionales=response.precios_adicionales[0].adicional_precio;
				}
				permitidos=response.precio_paquete[0].paquete_adicionales_permitidos;
				precioAdicionales();
			// console.log(typeof precios_adicionales);
		}
	});
}

function precioPaquete(){
	
	precio_periodos_paquete=precio_paquete * $('#periodos').val();
 	
 	$('#precio').val('$ '+ parseFloat(precio_periodos_paquete).toFixed(2));

 	// precioTotal();
}

function precioAdicionales(){

	if (typeof precios_adicionales == "object") {
		$.each(precios_adicionales, function(index, precio){
			
			if (precio.minino <= adicionales && (precio.maximo >= adicionales || precio.maximo==-1)) {
				precio_adicional=precio.precio;
				return false;
			}
		});

	}else{
		precio_adicional=precios_adicionales ;
	}
	precioTotal();
}

function precioTotal(){
	precio_total=(parseFloat(precio_paquete) + (parseFloat(precio_adicional) * adicionales)) * $('#periodos').val();
	$('#precio-total').val('$ '+ parseFloat(precio_total).toFixed(2));
	$('#total-expedientes').val(parseInt($('#incluidos').val()) + parseInt(adicionales))
}

$("#tipo-comprobante").change(function() {
    if ($("#tipo-comprobante").val() == "recibo") {
        $(".fac").addClass("d-none").removeClass("d-inline");
    } else {
        $(".fac").addClass("d-inline").removeClass("d-none");
    }
});