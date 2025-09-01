@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('paket-korisnikas.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.paket_korisnikas.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.paket_korisnikas.inputs.godisnja_pretplata')
                    </h5>
                    <span
                        >{{ $paketKorisnika->godisnja_pretplata ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.paket_korisnikas.inputs.tip_paketa_id')</h5>
                    <span
                        >{{ optional($paketKorisnika->tipPaketa)->naziv ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.paket_korisnikas.inputs.user_id')</h5>
                    <span
                        >{{ optional($paketKorisnika->user)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.paket_korisnikas.inputs.adresa')</h5>
                    <span>{{ $paketKorisnika->adresa ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.paket_korisnikas.inputs.uputstvo_za_dostavu')
                    </h5>
                    <span
                        >{{ $paketKorisnika->uputstvo_za_dostavu ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.paket_korisnikas.inputs.broj_telefona')</h5>
                    <span>{{ $paketKorisnika->broj_telefona ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.paket_korisnikas.inputs.postanski_broj')
                    </h5>
                    <span>{{ $paketKorisnika->postanski_broj ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('paket-korisnikas.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\PaketKorisnika::class)
                <a
                    href="{{ route('paket-korisnikas.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
