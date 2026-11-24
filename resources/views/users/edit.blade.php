@extends('layouts.panel')

@section('title', 'Edit Pengguna')
@section('heading', 'Edit Pengguna')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf @method('PUT')
                @include('users._form')
            </form>
        </div>
    </div>
@endsection