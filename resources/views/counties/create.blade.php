@extends('layouts.app')

@section('title', 'Új megye létrehozása')

@section('content')
    <div class="container">
        <h1>Új megye</h1>

        {{-- Flash üzenetek és hibák --}}
        @include('layouts.flash')

        <form action="{{ route('counties.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Megye neve</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Mentés
                </button>
                <a href="{{ route('counties.index') }}" class="btn btn-secondary">
                    <i class="fa fa-cancel"></i> Mégse
                </a>
            </div>
        </form>
    </div>
@endsection