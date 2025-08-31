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
                        @lang('crud.paket_korisnikas.inputs.godisnjaPretplata')
                    </h5>
                    <span>{{ $paketKorisnika->godisnjaPretplata ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.paket_korisnikas.inputs.tipPaketaID')</h5>
                    <span
                        >{{
                        optional($paketKorisnika->tipPaketaPaketKorisnika)->opisPaketa
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.paket_korisnikas.inputs.userID')</h5>
                    <span
                        >{{ optional($paketKorisnika->userPaketKorisnika)->name
                        ?? '-' }}</span
                    >
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
