@extends('templates.master')

@section('view-content')
    <div id="app">
        <user :id="{{ $user }}"></user>
    </div>
@endsection
