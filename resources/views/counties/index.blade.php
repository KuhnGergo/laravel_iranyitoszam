@extends('layouts.app')

@section('title', 'Megyék listája')

@section('content')
    <div class="container">
        <h1>Megyék</h1>

        @include('layouts.toolbar', [
            'isAuthenticated' => $isAuthenticated,
            'routes' => [
                'create' => route('counties.create'),
                'csv' => route('counties.export.csv'),
                'pdf' => route('counties.export.pdf'),
                'mail' => route('counties.mail'),
            ]
        ])
        {{-- Kereső form --}}
        @include('layouts.search-form', ['action' => route('counties.index')])

        {{-- Flash üzenetek --}}
        @include('layouts.flash')

        {{-- Megyék táblázata --}}
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Név</th>
                <th>Műveletek</th>
            </tr>
            </thead>
            <tbody>
            @forelse($entities as $county)
                <tr>
                    <td>{{ $county->id }}</td>
                    <td>{{ $county->name }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('counties.show', $county->id) }}" class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i>
                            </a>
                            @if($isAuthenticated)
                                <a href="{{ route('counties.edit', $county->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>

                                {{-- Törlés form --}}
                                <form action="{{ route('counties.destroy', $county->id) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash red"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Nincs megye a rendszerben.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection