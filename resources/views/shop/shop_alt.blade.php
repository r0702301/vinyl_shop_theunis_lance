@extends('layouts.template')

@section('title', 'Record')

@section('main')
    <h1>Artist - Alternative listing</h1>

    @foreach($genres as $genre)
        <h2>{{ $genre->name }}</h2>
        <ul>
        @foreach ($genre->records as $record)

                <li><a href="shop/{{ $record->id }}">{{$record->artist}} - {{ $record->title }}</a> | Price: €{{ $record->price }} | Stock: {{ $record->stock }}</li>

        @endforeach
        </ul>

    @endforeach

@endsection
