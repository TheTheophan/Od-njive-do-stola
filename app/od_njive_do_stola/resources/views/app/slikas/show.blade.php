@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('slikas.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.slikas.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.slikas.inputs.upotrebaSlike')</h5>
                    <span>{{ $slika->upotrebaSlike ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.slikas.inputs.nazivDatoteke')</h5>
                    <span>{{ $slika->nazivDatoteke ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.slikas.inputs.slika')</h5>
                    <span>{{ $slika->slika ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.slikas.inputs.poljoprivrednikID')</h5>
                    <span
                        >{{ optional($slika->poljoprivrednikSlika)->adresa ??
                        '-' }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('slikas.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Slika::class)
                <a href="{{ route('slikas.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
