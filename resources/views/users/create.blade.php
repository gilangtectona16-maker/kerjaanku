@extends('layouts.panel')

@section('title', 'Tambah Pengguna')
@section('heading', 'Tambah Pengguna')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                @include('users._form')
            </form>
        </div>
    </div>
@endsection