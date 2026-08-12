@extends('layouts.app')

@section('title', 'Editar Atrativo — System-PITE')

@section('content')
{{-- Reutiliza o mesmo formulário do create, injetando $atrativo --}}
@include('admin.atrativos.create')
@overwrite
