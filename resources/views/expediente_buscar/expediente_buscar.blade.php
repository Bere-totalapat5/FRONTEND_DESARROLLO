@extends('layouts.index')

@section('contenido-pageheader-usuario')
{{$sesion['usuario_nombre']}}
@endsection

@section('contenido-pageheader-organo')
{{$sesion['juzgado_nombre_largo']}}
@endsection

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Buscar Expedientes</li>
    </ol>
    <h6 class="slim-pagetitle">Buscar Expedientes/Tocas</h6>
@endsection


@section('contenido-principal')

<div class="section-wrapper" >
    <label class="section-title">Formulario para buscar Expedinentes/Tocas</label>
    <p class="mg-b-20 mg-sm-b-40">Favor de llenar los siguietnes campos para realizar la búsqueda.</p>

    <div class="row">
        

        <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-2">
                <div class="form-group">
                  <h4>Toca:</h4>
                </div>
              </div><!-- col-2 -->
              <div class="col-lg-6">
                <div class="form-group">
                    <table>
                        <tr>
                            <td><input class="form-control" type="text" name="lastname" value="" placeholder="Numero"></td>
                            <td>/</td>
                            <td>
                                <select class="form-control select2" data-placeholder="Selecciona un año">
                                    <option value="0" selected>Todos</option>
                                    @for($i=request()->entorno['variables_entorno']['ANIO_FIN']; $i>=request()->entorno['variables_entorno']['ANIO_INICIO']; $i--)
                                      <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                  </select>

                            </td>
                            <td>/</td>
                            <td><input class="form-control" type="text" name="lastname" value="" placeholder="Asunto"></td>
                        </tr>
                    </table>
                  
                </div>
              </div><!-- col-6 -->
              
              <div class="col-lg-4">
                <div class="form-group">
                    <label class="ckbox">
                        <input type="checkbox"><span>Tocas por turnar</span>
                      </label>
                </div>
              </div><!-- col-4 -->



              <div class="col-lg-2">
                <div class="form-group">
                  <h4>Expediente:</h4>
                </div>
              </div><!-- col-2 -->
              <div class="col-lg-10">
                <div class="form-group">
                    <table>
                        <tr>
                            <td><input class="form-control" type="text" name="lastname" value="" placeholder="Numero"></td>
                            <td>/</td>
                            <td>
                                <select class="form-control select2" data-placeholder="Selecciona un año">
                                    <option value="0" selected>Todos</option>
                                    @for($i=request()->entorno['variables_entorno']['ANIO_FIN']; $i>=request()->entorno['variables_entorno']['ANIO_INICIO']; $i--)
                                      <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                  </select>

                            </td>
                        </tr>
                    </table>
                  
                </div>
              </div><!-- col-6 -->
              

              <div class="col-lg-2">
                <div class="form-group">
                  <h4>Involucrado:</h4>
                </div>
              </div><!-- col-2 -->
              <div class="col-lg-10">
                <div class="form-group">
                    <input class="form-control" type="text" name="lastname" value="" placeholder="">
                </div>
              </div><!-- col-6 -->


              <div class="col-lg-2">
                <div class="form-group">
                  <h4>Registro:</h4>
                </div>
              </div><!-- col-2 -->
              <div class="col-lg-10">
                <div class="form-group">
                    <table>
                        <tr>
                            <td>Desde </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY">
                                  </div>
                                </td>
                            <td> &nbsp; &nbsp; &nbsp;</td>
                            <td>Hasta </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY">
                                  </div>

                            </td>
                        </tr>
                    </table>
                  
                </div>
              </div><!-- col-6 -->



              
            </div><!-- row -->

            <div class="form-layout-footer">
              <button class="btn btn-primary bd-0">Buscar</button>
              <button class="btn btn-secondary bd-0">Limpiar</button>
            </div><!-- form-layout-footer -->
          </div><!-- form-layout -->

          
        
    </div><!-- row -->

    </div><!-- section-wrapper -->



    <div class="section-wrapper" >
        <div class="table-wrapper" >
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
            <tr>
                <th class="wd-15p">Toca</th>
                <th class="wd-15p">Fecha ingreso</th>
                <th class="wd-20p">Ponencia</th>
                <th class="wd-15p">Involucrados</th>
                <th class="wd-10p">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Tiger</td>
                <td>Nixon</td>
                <td>System Architect</td>
                <td>2011/04/25</td>
                <td><a href="javascript:void(0);" onclick="alert('Representantes');">Representantes</a><br><a href="javascript:void(0);" onclick="alert('Resoluciones');">Resoluciones</a><br><a href="javascript:void(0);" onclick="alert('Turnar');">Turnar</a><br><a href="javascript:void(0);" onclick="alert('Ver Toca');">Ver Toca</a><br></td>
            </tr>
            <tr>
                <td>Garrett</td>
                <td>Winters</td>
                <td>Accountant</td>
                <td>2011/07/25</td>
                <td><a href="javascript:void(0);" onclick="alert('Representantes');">Representantes</a><br><a href="javascript:void(0);" onclick="alert('Resoluciones');">Resoluciones</a><br><a href="javascript:void(0);" onclick="alert('Turnar');">Turnar</a><br><a href="javascript:void(0);" onclick="alert('Ver Toca');">Ver Toca</a><br></td>
            </tr>
            <tr>
                <td>Ashton</td>
                <td>Cox</td>
                <td>Junior Technical Author</td>
                <td>2009/01/12</td>
                <td><a href="javascript:void(0);" onclick="alert('Representantes');">Representantes</a><br><a href="javascript:void(0);" onclick="alert('Resoluciones');">Resoluciones</a><br><a href="javascript:void(0);" onclick="alert('Turnar');">Turnar</a><br><a href="javascript:void(0);" onclick="alert('Ver Toca');">Ver Toca</a><br></td>
            </tr>
            <tr>
                <td>Cedric</td>
                <td>Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>2012/03/29</td>
                <td><a href="javascript:void(0);" onclick="alert('Representantes');">Representantes</a><br><a href="javascript:void(0);" onclick="alert('Resoluciones');">Resoluciones</a><br><a href="javascript:void(0);" onclick="alert('Turnar');">Turnar</a><br><a href="javascript:void(0);" onclick="alert('Ver Toca');">Ver Toca</a><br></td>
            </tr>
            <tr>
                <td>Airi</td>
                <td>Satou</td>
                <td>Accountant</td>
                <td>2008/11/28</td>
                <td><a href="javascript:void(0);" onclick="alert('Representantes');">Representantes</a><br><a href="javascript:void(0);" onclick="alert('Resoluciones');">Resoluciones</a><br><a href="javascript:void(0);" onclick="alert('Turnar');">Turnar</a><br><a href="javascript:void(0);" onclick="alert('Ver Toca');">Ver Toca</a><br></td>
            </tr>
            <tr>
                <td>Brielle</td>
                <td>Williamson</td>
                <td>Integration Specialist</td>
                <td>2012/12/02</td>
                <td><a href="javascript:void(0);" onclick="alert('Representantes');">Representantes</a><br><a href="javascript:void(0);" onclick="alert('Resoluciones');">Resoluciones</a><br><a href="javascript:void(0);" onclick="alert('Turnar');">Turnar</a><br><a href="javascript:void(0);" onclick="alert('Ver Toca');">Ver Toca</a><br></td>
            </tr>
            <tr>
                <td>Tiger</td>
                <td>Nixon</td>
                <td>System Architect</td>
                <td>2011/04/25</td>
                <td><a href="javascript:void(0);" onclick="alert('Representantes');">Representantes</a><br><a href="javascript:void(0);" onclick="alert('Resoluciones');">Resoluciones</a><br><a href="javascript:void(0);" onclick="alert('Turnar');">Turnar</a><br><a href="javascript:void(0);" onclick="alert('Ver Toca');">Ver Toca</a><br></td>
            </tr>
            <tr>
                <td>Garrett</td>
                <td>Winters</td>
                <td>Accountant</td>
                <td>2011/07/25</td>
                <td><a href="javascript:void(0);" onclick="alert('Representantes');">Representantes</a><br><a href="javascript:void(0);" onclick="alert('Resoluciones');">Resoluciones</a><br><a href="javascript:void(0);" onclick="alert('Turnar');">Turnar</a><br><a href="javascript:void(0);" onclick="alert('Ver Toca');">Ver Toca</a><br></td>
            </tr>
            <tr>
                <td>Ashton</td>
                <td>Cox</td>
                <td>Junior Technical Author</td>
                <td>2009/01/12</td>
                <td><a href="javascript:void(0);" onclick="alert('Representantes');">Representantes</a><br><a href="javascript:void(0);" onclick="alert('Resoluciones');">Resoluciones</a><br><a href="javascript:void(0);" onclick="alert('Turnar');">Turnar</a><br><a href="javascript:void(0);" onclick="alert('Ver Toca');">Ver Toca</a><br></td>
            </tr>
            </tbody>
        </table>
        </div><!-- table-wrapper -->
    </div><!-- section-wrapper -->

@endsection

@section('seccion-estilos')
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">

@endsection

@section('seccion-scripts-libs')
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
@endsection

@section('seccion-scripts-functions')
    <script>
        $(function(){
            'use strict';

            $('#datatable1').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Filtrar...',
                    sSearch: '',
                    lengthMenu: '_MENU_ registros',
                }
            });

            // Select2
            $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

            $('.form-layout .form-control').on('focusin', function(){
                $(this).closest('.form-group').addClass('form-group-active');
            });

            $('.form-layout .form-control').on('focusout', function(){
                $(this).closest('.form-group').removeClass('form-group-active');
            });

            // Select2
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });

            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true
            });
            $( ".fc-datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        });
    </script>

@endsection

@section('seccion-modales')

@endsection