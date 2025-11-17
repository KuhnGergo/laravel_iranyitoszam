 
@extends('layouts.app')

@section('content')
    <h1>{{ $entity->name }} megye</h1>
    <a href="{{ route('counties.index') }}" title="Vissza"> Vissza</a>
@endsection