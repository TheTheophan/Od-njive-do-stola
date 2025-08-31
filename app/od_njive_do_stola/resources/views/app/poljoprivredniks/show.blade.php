@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('poljoprivredniks.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.poljoprivredniks.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.poljoprivredniks.inputs.adresa')</h5>
                    <span>{{ $poljoprivrednik->adresa ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.poljoprivredniks.inputs.ime')</h5>
                    <span>{{ $poljoprivrednik->ime ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.poljoprivredniks.inputs.prezime')</h5>
                    <span>{{ $poljoprivrednik->prezime ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.poljoprivredniks.inputs.gradID')</h5>
                    <span
                        >{{
                        optional($poljoprivrednik->gradpoljoprivrednika)->nazivGrada
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.poljoprivredniks.inputs.opisAdrese')</h5>
                    <span>{{ $poljoprivrednik->opisAdrese ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.poljoprivredniks.inputs.brojTelefona')</h5>
                    <span>{{ $poljoprivrednik->brojTelefona ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.poljoprivredniks.inputs.brojHektara')</h5>
                    <span>{{ $poljoprivrednik->brojHektara ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.poljoprivredniks.inputs.brojGazdinstva')
                    </h5>
                    <span>{{ $poljoprivrednik->brojGazdinstva ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.poljoprivredniks.inputs.plastenickaProizvodnja')
                    </h5>
                    <span
                        >{{ $poljoprivrednik->plastenickaProizvodnja ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('poljoprivredniks.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Poljoprivrednik::class)
                <a
                    href="{{ route('poljoprivredniks.create') }}"
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
