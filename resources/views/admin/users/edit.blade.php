@extends('layouts.template')

@section('title', 'Update profile')

@section('main')
    <h1>Edit user: {{ $user->name }}</h1>
    @include('shared.alert')
    <form action="/admin/users/{{ $user->id }}" method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Your name"
                   value="{{ old('name', $user->name ) }}"
                   required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Your email"
                   value="{{ old('email', $user->email) }}"
                   required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
            <input type="checkbox" name="active" value="1" {{$user->active ? 'checked' : ''}}> Active
            <input type="checkbox" name="admin" value="1" {{$user->admin ? 'checked' : ''}}> admin<br>
        </div>
        <button type="submit" class="btn btn-success">Update Profile</button>
    </form>
@endsection
