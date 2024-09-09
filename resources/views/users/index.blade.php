@extends('templates.master')

@section('page-title', 'Lista de usuários')

@section('view-content')
    <div id="app">
        <div class="container">
            <div id="user-table-buttons">
                <a id="export-user-btn" class="btn" href="{{ route('users.export.csv') }}" title="Exportar Usuários para CSV">
                    CSV
                </a>
                <a id="create-user-btn" class="btn" href="{{ route('web.users.create') }}" title="Criar Novo Usuário">
                    +
                </a>
            </div>
            <user-table></user-table>
        </div>
    </div>
@endsection
