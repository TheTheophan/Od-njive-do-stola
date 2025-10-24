@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('paket-korisnikas.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @php
                    $isAdmin = auth()->user() && auth()->user()->email === 'admin@admin.com';
                @endphp
                @if($isAdmin)
                    @lang('crud.paket_korisnikas.edit_title')
                @else
                    Pregled porucenog paketa
                @endif

            </h4>

            @php
                $isAdmin = auth()->user() && auth()->user()->email === 'admin@admin.com';
            @endphp

            @if($isAdmin)
                {{-- Admin: keep original single-column layout with editable form --}}
                <x-form
                    method="PUT"
                    action="{{ route('paket-korisnikas.update', $paketKorisnika) }}"
                    class="mt-4"
                >
                    @include('app.paket_korisnikas.form-inputs', ['readOnly' => false])

                    <div class="mt-4">
                        <a
                            href="{{ route('paket-korisnikas.index') }}"
                            class="btn btn-light"
                        >
                            <i class="icon ion-md-return-left text-primary"></i>
                            @lang('crud.common.back')
                        </a>

                        <a
                            href="{{ route('paket-korisnikas.create') }}"
                            class="btn btn-light"
                        >
                            <i class="icon ion-md-add text-primary"></i>
                            @lang('crud.common.create')
                        </a>

                        <button type="submit" class="btn btn-primary float-right">
                            <i class="icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>
                    </div>
                </x-form>
            @else
                {{-- Regular user: show read-only form on the left and receipt preview on the right --}}
                <div class="row">
                    <div class="col-md-7">
                        <div class="card" style="border-radius:16px">
                            <div class="card-body">
                                <x-form method="PUT" action="#" class="mt-0">
                                    @include('app.paket_korisnikas.form-inputs', ['readOnly' => true])
                                </x-form>

                                <div class="mt-4">
                                    <a
                                        href="{{ route('paket-korisnikas.index') }}"
                                        class="btn btn-light"
                                    >
                                        <i class="icon ion-md-return-left text-primary"></i>
                                        @lang('crud.common.back')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        {{-- Receipt / Faktura preview --}}
                        <div class="card" style="border-radius:16px;">
                            <div style="background:#29A645; color:#fff; padding:0.75rem; text-align:center; border-top-left-radius:16px; border-top-right-radius:16px;">
                                <h5 class="m-0" style="font-weight:bold;">Faktura</h5>
                            </div>
                            <div class="card-body">
                                @php $fakturas = $paketKorisnika->fakturas; @endphp

                                @if($fakturas->isEmpty())
                                    <p class="text-muted">Nema izdanih faktura za ovaj paket.</p>
                                @else
                                    @foreach($fakturas as $faktura)
                                        <div class="border rounded p-3 mb-3" style="background:#f8f9fa">
                                            <div class="d-flex justify-content-between mb-2">
                                                <strong>Broj fakture</strong>
                                                <span>#{{ $faktura->id }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <small class="text-muted">Datum</small>
                                                <div>{{ $faktura->created_at->format('d.m.Y H:i') }}</div>
                                            </div>
                                            <div class="mb-1">
                                                <small class="text-muted">Iznos</small>
                                                <div class="fw-bold">{{ number_format($faktura->cena, 2, ',', '.') }} RSD</div>
                                            </div>
                                            @if($faktura->tekst)
                                                <div class="mb-1">
                                                    <small class="text-muted">Opis</small>
                                                    <div>{{ $faktura->tekst }}</div>
                                                </div>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Plaćeno</small>
                                                @if($faktura->placeno)
                                                    <span class="badge bg-success">Da</span>
                                                @else
                                                    <span class="badge bg-danger">Ne</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
