@extends('ui.nav')

@section('contenido-admin')
@can('admin.users.index')
@livewire('admin.users-index')
@endcan
@endsection
