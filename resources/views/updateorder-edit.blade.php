@extends('layouts.app')


@section('contenido')

    @livewire('edit-order',['order' => $order])

@endsection
