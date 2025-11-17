@extends('layouts.app')

@section('title', 'Megye módosítása')

@section('content')
    <div class="container">
        <h1>Megye módosítása</h1>

        {{-- Flash üzenetek és hibák --}}
        @include('layouts.flash')

        <form action="{{ route('counties.update', $entity->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Megye neve</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ old('name', $entity->name) }}" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Mentés
                </button>
                <a href="{{ route('counties.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Mégse
                </a>
            </div>
        </form>
    </div>
@endsection