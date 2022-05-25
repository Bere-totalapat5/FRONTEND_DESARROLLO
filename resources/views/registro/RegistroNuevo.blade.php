@extends('layouts.index')

@section('contenido-principal')

    <p>New</p>

@endsection

@section('seccion-estilos')
<style type="text/css">
    .opc-RegistroNuevo, 
    .opc-RegistroNuevo > span,
    .opc-RegistroNuevo > a{
        background-color: #e5ecf3 !important;
    }
</style>
@endsection

@section('seccion-scripts')
<script type="text/javascript">
    $(function(){
        $("#registro").trigger("click");
    });
</script>
@endsection

@section('seccion-modales')

@endsection