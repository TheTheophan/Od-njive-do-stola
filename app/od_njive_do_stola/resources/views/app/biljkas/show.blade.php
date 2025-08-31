@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('biljkas.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.biljkas.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.biljkas.inputs.opisBiljke')</h5>
                    <span>{{ $biljka->opisBiljke ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.biljkas.inputs.nazivBiljke')</h5>
                    <span>{{ $biljka->nazivBiljke ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.biljkas.inputs.sezona')</h5>
                    <span>{{ $biljka->sezona ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('biljkas.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Biljka::class)
                <a href="{{ route('biljkas.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
