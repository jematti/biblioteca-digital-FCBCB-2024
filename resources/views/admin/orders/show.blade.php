@extends('ui.nav')

@section('contenido-admin')
    @livewire('status-order', ['order' => $order])
@endsection
