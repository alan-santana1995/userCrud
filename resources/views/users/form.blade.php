@extends('templates.master')

@section('page-title', 'Formulário de usuários')

@section('view-content')
    <div id="app">
        <user-form :id="{{ $user ?? 0 }}"></user-form>
    </div>
@endsection
