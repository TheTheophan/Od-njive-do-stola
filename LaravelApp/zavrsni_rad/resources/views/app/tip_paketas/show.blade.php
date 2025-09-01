@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('tip-paketas.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.tip_paketas.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.tip_paketas.inputs.cena_godisnje_pretplate')
                    </h5>
                    <span
                        >{{ $tipPaketa->cena_godisnje_pretplate ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.tip_paketas.inputs.cena_mesecne_pretplate')
                    </h5>
                    <span>{{ $tipPaketa->cena_mesecne_pretplate ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tip_paketas.inputs.opis')</h5>
                    <span>{{ $tipPaketa->opis ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tip_paketas.inputs.naziv')</h5>
                    <span>{{ $tipPaketa->naziv ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('tip-paketas.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\TipPaketa::class)
                <a
                    href="{{ route('tip-paketas.create') }}"
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
