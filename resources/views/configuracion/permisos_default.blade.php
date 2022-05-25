@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Permisos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Permisos del Menú</li>
  </ol>
  <h6 class="slim-pagetitle">Permisos del Menú</h6>
@endsection

@section('contenido-principal')


hola


@endsection


@section('seccion-modales')
@endsection