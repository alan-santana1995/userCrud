@extends('templates.master')

@section('page-title', 'Lista de usuários')

@section('view-content')
    <div id="app">
        <div id="user-creation-button-container">
            <a id="create-user-btn" href="{{ route('web.users.create') }}">
                Criar Novo Usuário
            </a>
        </div>
        <user-table></user-table>
    </div>
@endsection
