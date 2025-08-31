@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('fakturas.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.fakturas.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.fakturas.inputs.paketKorisnikaID')</h5>
                    <span
                        >{{ optional($faktura->paketKorisnikaFaktura)->id ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fakturas.inputs.cena')</h5>
                    <span>{{ $faktura->cena ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fakturas.inputs.tekstFakture')</h5>
                    <span>{{ $faktura->tekstFakture ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fakturas.inputs.placeno')</h5>
                    <span>{{ $faktura->placeno ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fakturas.inputs.datumPlacanja')</h5>
                    <span>{{ $faktura->datumPlacanja ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('fakturas.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Faktura::class)
                <a href="{{ route('fakturas.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
