@extends('admin.layout')

@section('content')


	<h1>Dashboard</h1>

	<p>Usuario Autenticado: {{ auth()->user()->name }}</p>
@stop