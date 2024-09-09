@extends('templates.master')

@section('page-title', 'Visualizando usuário')

@section('view-content')
    <div id="app">
        <user :id="{{ $user }}"></user>
    </div>
@endsection
