@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4">
                    <h1 class="display-4 text-danger">Greška 403</h1>
                    <h3 class="mb-3">Nemate dozvolu za pristup ovoj stranici.</h2>
                    {{-- 
                    <p class="lead text-muted">
                        {!! nl2br(e($exception->getMessage() ?: 'Nemate dozvolu za pristup ovoj stranici.')) !!}
                    </p>
                    --}}

                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg mr-2">Početna</a>
                        {{--
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">Nazad</a>
                        --}}

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
