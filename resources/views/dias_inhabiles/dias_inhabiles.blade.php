@extends("layouts.index") 
<link rel="stylesheet" href="/lib/datatables/css/jquery.dataTables.css">
@section('head-title') 
DIAS INHABILES
@endsection
@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Dias Inhabiles</li>
    </ol>
    <h6 class="slim-pagetitle">Administracion de Dias Inhabiles</h6>
@endsection 
@section("contenido-principal")

    <div class="section-wrapper" style="max-width: 1200px;">   
        <div class="form-layout">
            <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                        Crear dia inhabil
                        </a>
                    </div><!-- card-header -->
                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                            
                            <div class="row mg-b-25">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Solo el día: </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker valid" placeholder="AAAA/MM/DD" id="crear_dia" autocomplete="off">
                                        </div>
                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Desde el día: </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker valid" placeholder="AAAA/MM/DD" id="crear_desde" autocomplete="off" class="required-if">
                                        </div>
                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Hasta el día:</label>
                                        <div class="input-group ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker valid" placeholder="AAAA/MM/DD" id="crear_hasta" autocomplete="off" class="required-if">
                                        </div>
                                    </div>
                                </div><!-- col-4 -->  
                            </div>

                            <div class="form-layout-footer">
                                <button class="btn btn-primary bd-0 btn-block" onclick="nuevo();">Crear</button>
                            </div><!-- form-layout-footer -->

                        </div>
                    </div>
                </div>
            </div><!-- accordion -->

            <div id="accordion-busqueda" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion-busqueda" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="tx-gray-800 transition collapsed">
                        Consultar dias no laborales
                        </a>
                    </div><!-- card-header -->
                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="card-body">
                            <div class="row mg-b-25"><!-- row -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Año:</label>
                                        <select class="form-control select2 " id="anio" name="anio">
                                            <option selected="true" value="-">Todos</option> 
                                            @foreach( $anios as $anio )
                                             <option value="{{$anio}}">{{$anio}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Desde: </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker" placeholder="AAAA/MM/DD" id="desde" autocomplete="off">
                                        </div>
                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Hasta:</label>
                                        <div class="input-group ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker" placeholder="AAAA/MM/DD" id="hasta" autocomplete="off">
                                        </div>
                                    </div>
                                </div><!-- col-4 -->  
                            </div><!-- End row -->
                            
                            <div class="form-layout-footer">
                                <button class="btn btn-primary bd-0 btn-block" onclick="buscar();">Buscar</button>
                            </div><!-- form-layout-footer -->

                            <div class="mg-t-25" id="div-table" style="display: none"><!-- div table --> 
                                <table id="table-dias" class="tx-center" width="100%">
                                    <thead>
                                        <tr>
                                            <th> Accion </th>
                                            <th> Dia </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> Sin datos </td>
                                            <td> Sin datos </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> <!--End div table --> 

                        </div>
                    </div>
                </div>
            </div><!-- accordion -->
        </div> <!-- form-layout -->
    </div>


<div id="modal_loading" class="modal fade" data-backdrop="static" data-keyboard="false" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body">
                <div class="d-flex ht-200 pos-relative align-items-center">
                    <div class="sk-three-bounce">
                        <div class="sk-child sk-bounce1 bg-gray-800"></div>
                        <div class="sk-child sk-bounce2 bg-gray-800"></div>
                        <div class="sk-child sk-bounce3 bg-gray-800"></div>
                    </div>
                </div><!-- d-flex -->
            </div><!-- modal-body -->
            <div class="container">
                <h5><strong class="tx-inverse">Espere un momento por favor ... </strong></h5><br>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div>


<div id="modal-error" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-md">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-error tx-semibold mg-b-20">OPS! <br> Ocurrió algo</h4>
          <p class="mg-b-20 mg-x-20 tx-semibold">Mesaje de error:</p>
          <p class="mg-b-20 mg-x-20 tx-semibold" id="modal-error-message">Error</p>
          <p class="mg-b-20 mg-x-20">Intenta mas tarde por favor</p>
          <button type="button" class="btn btn-info pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div id="modal_info" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">ATENCIÓN</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20" id="message">
                <i class="icon icon ion-ios-success-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                <p class="mg-b-20 mg-x-20" id="modal-info-message">Success</p>
                <p class="mg-b-20 mg-x-20">Por favor espera...</p>
            </div>
            <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-info pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button> 
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->


<style>
    div.dataTables_length ,div.dataTables_filter{
        display: none;
    }
    div#lista_usuarios p{
        margin-bottom: 0;
        color: #000;
    }

    li.adicionales span {
        padding: 0;
    }

    button.title {
        margin-right: 10px;
    }

    .number {
        display: inline-block;
        justify-content: center;
        align-items: center;
        width: 25px;
        height: 25px;
        border: 1px solid #adb5bd;
        border-radius: 50px;
    }

    span.title {
        margin-left: 10px;
        margin-top: 0;
        display: inline-block;
    }

    @media only screen and (max-width: 991px) {
        span.title {
            display: none;
        }
    }


    #pdf {
        width: 850px;
        display: block;
    }

    #pdf-m {
        display: none;
    }

    @media only screen and (min-width:577px) and (max-width: 991px) {
        #pdf {
            width: 550px;
            display: block;
        }

        #pdf-m {
            display: none;
        }
    }

    @media only screen and (max-width: 576px) {
        #pdf {
            display: none;
        }

        #pdf-m {
            display: block;
        }
    }

    table{
        min-height: 125px;
        background-color: #f8f9fa;
    }

    ul#portafolios-agregados {
        width: 100%;
        padding: 0;
    }

    tr.items-agregados:nth-child(2n) {
        background-color: #fff;
    }

    tr.items-agregados:nth-child(2n-1) {
        background-color: #f8f9fa;
    }

    tr.items-agregados p{
        margin-bottom: 5px !important;
    }

    span.quitar {
        cursor: pointer;
    }

    a.tx-warning{
        color:#F49917;
    }
    
    .usuario{
        width: 120px;
    }

    .tipo_usuario{
        width: 109px;
    }

    .juzgado {
        width: 65px;
    }
    .nombre{
        width: 265px;
    }
    .estatus{
        width: 66px;
    }
    .ponencia{
        width: 55px;
    }
    .acciones{
        width: 120px;
    }
    td nav.nav a.nav-link{
        width: 100%;
        border-bottom: 1px solid rgba(0, 0, 0, 0.15);
        border-left: 1px solid rgba(0, 0, 0, 0.15);
        border-right: 1px solid rgba(0, 0, 0, 0.15);
    }
    td nav.nav:first-child{
        border-top: 1px solid rgba(0, 0, 0, 0.15);
    }
    td nav.nav a.nav-link:hover{
        background-color: rgba(0, 0, 0, 0.15);
    }

    #permisos hr{
        display: none;
    }

</style>
@endsection
@section("scripts-functions")
<script src="{{ asset('/lib/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{ asset('/lib/datatables-responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{ asset('/js/slim.js')}}"></script>
<script src="{{ asset('/lib/jquery-ui/js/jquery-ui.js')}}"></script>

<script>
    $('.fc-datepicker').datepicker({
        showOtherMonths: true, 
        selectOtherMonths: true,
        format: 'dd/mm/yyyy',
        container:'#form-editar',   
    });

    var data_table = $('#table-dias').DataTable({
        'responsive': true,
        'paging':   true,
        //iDisplayLength: 5
        'pageLength' :10, 
    });


    //auto_buscar();

    function buscar(){
        loading('show');

        let table = '';
        let filtro = new Object();

        filtro['anio']= $('#anio').val();
        // filtro['fecha_desde']= !$('#desde').val() ? "-" : $('#desde').val();
        // filtro['fecha_hasta']= !$('#hasta').val() ? "-" : $('#hasta').val();
            
        console.log(filtro);
        $("#div-table").hide();
        $("#table-dias tbody tr").remove();
 
        $.ajax({
            method:"POST",
            url:'public/consultar_dias_inhabiles',
            data:{
                filtro:filtro,
            },
            
            success:function(response){
                console.log(response);
                
                if (response.status==100) {
                    $("#table-dias tbody tr").remove();
                    //data_table.destroy();
                    $.each(response.response, function(index, dia) {
                        row =`<tr> 
                                <td> <a href="javascript:void(0);" onclick="estatus(${dia.id},0);" ><i class="icon ion-trash-a"></i></a></td>
                                <td> ${dia.fecha} </td>
                            </tr>`;
                            // <td> ${dia.dia_no_laboral_tipo.replace("_"," ")} </td>
                            // <td> ${dia.dia_no_laboral_estatus_activo==1? "Activo" : "Inactivo"} </td> 
                            // <td> <a href="javascript:void(0);" onclick="estatus(${dia.id},${dia.dia_no_laboral_estatus_activo==1?0:1});" > ${dia.dia_no_laboral_estatus_activo==1? "Inactivar" : "Activar"} </a></td>
                        $("#table-dias tbody").append( row );
                    });
                    
                    //data_table = $('#table-dias').DataTable({ responsive: true });
                    $("#div-table").show();

                }else{
                    show_error(response.message);
                }
                loading('hide');
            }
        });
    }

    function estatus(id_dia, nuevo_estatus){

        loading('show');

        let datos = new Object();

        datos['id']= id_dia;
        datos['estatus']= nuevo_estatus;
            
        console.log(datos);

        $.ajax({
            method:"POST",
            url:'public/estatus_dia_inhabil',
            data:{
                datos:datos,
            },
            
            success:function(response){
                console.log(response);
                $("#table-dias tbody tr").remove();
                if (response.status == 100) {
                    buscar();
                }else{
                    show_error(response.message);
                }

                loading('hide');
            }
        });
    }

    function nuevo(){

        let datos = new Object();

        if( !($("#crear_dia").val()).length ){
            if ( !($("#crear_desde").val()).length && !($("#crear_hasta").val()).length  ) {
                $("#crear_dia").parent().parent().append("<label class='error tx-danger'>Este campo es obligatorio</label>");

            }else if ( !($("#crear_desde").val()).length ) {
                $("#crear_desde").parent().parent().append("<label class='error tx-danger'>Este campo es obligatorio</label>");
            }else{
                if ( ($("#crear_desde").val()).length && !($("#crear_hasta").val()).length ) {
                    $("#crear_hasta").parent().parent().append("<label class='error tx-danger'>Este campo es obligatorio</label>");
                }                
            }
        }

        datos['dia']= ($("#crear_dia").val()).length ? $("#crear_dia").val() : "-" ;;
        datos['desde']= ($("#crear_desde").val()).length ? $("#crear_desde").val() : "-" ;
        datos['hasta']= ($("#crear_hasta").val()).length ? $("#crear_hasta").val() : "-" ;
            
        console.log(datos);

        $.ajax({
            method:"POST",
            url:'public/nuevo_dia_inhabil',
            data:{
                datos:datos,
            },
            
            success:function(response){
                console.log(response);
                if (response.status == 100) {
                    auto_buscar();
                }else{
                    show_error(response.message);
                }
            }
        });
    }

    function auto_buscar(){
        $('#anio option[value="{{date("Y")}}"]').prop('selected', true);
        buscar();
        despliega_busqueda();
    }

    function despliega_busqueda(){
        $('#collapseTwo').collapse({
          toggle: true
        })
    }

    function loading(accion){
        if (accion=="show") {
            $("#modal_loading").modal("show");
        }
        if (accion=="hide") {
            setTimeout(function(){
                $("#modal_loading").modal("hide");
            },500);
        }
        
    }


    function show_error(message){
        $("#modal-error-message").text(message);
        $("#modal-error").modal("show");
    }

</script>
@endsection

