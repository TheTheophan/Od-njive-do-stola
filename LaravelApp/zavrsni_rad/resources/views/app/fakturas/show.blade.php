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
                    <h5>@lang('crud.fakturas.inputs.paket_korisnika_id')</h5>
                    @php $owner = optional($faktura->paketKorisnika)->user; @endphp
                    <span>
                        {{ $owner->name ?? '-' }}
                        @if($owner && $owner->email)
                            <small class="text-muted">({{ $owner->email }})</small>
                        @endif
                    </span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fakturas.inputs.cena')</h5>
                    <span>{{ $faktura->cena ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fakturas.inputs.tekst')</h5>
                    <span>{{ $faktura->tekst ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.fakturas.inputs.placeno')</h5>
                    <span>{{ $faktura->placeno ?? '-' }}</span>
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
