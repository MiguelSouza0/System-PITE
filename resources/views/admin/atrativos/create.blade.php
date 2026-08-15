@extends('layouts.app')

@section('title', isset($atrativo) ? 'Editar Atrativo — System-PITE' : 'Novo Atrativo — System-PITE')

@section('content')
@include('admin.atrativos._form')
@endsection
