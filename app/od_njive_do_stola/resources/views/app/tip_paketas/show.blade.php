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
                        @lang('crud.tip_paketas.inputs.cenaGodisnjePretplate')
                    </h5>
                    <span>{{ $tipPaketa->cenaGodisnjePretplate ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.tip_paketas.inputs.cenaMesecnePretplate')
                    </h5>
                    <span>{{ $tipPaketa->cenaMesecnePretplate ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tip_paketas.inputs.opisPaketa')</h5>
                    <span>{{ $tipPaketa->opisPaketa ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tip_paketas.inputs.nazivPaketa')</h5>
                    <span>{{ $tipPaketa->nazivPaketa ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tip_paketas.inputs.cenaRezervacije')</h5>
                    <span>{{ $tipPaketa->cenaRezervacije ?? '-' }}</span>
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
