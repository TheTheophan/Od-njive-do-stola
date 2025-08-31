@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a
                    href="{{ route('biljka-poljoprivrednikas.index') }}"
                    class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.biljka_poljoprivrednikas.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.biljka_poljoprivrednikas.inputs.biljkaID')
                    </h5>
                    <span
                        >{{
                        optional($biljkaPoljoprivrednika->biljkaBiljkaPoljoprivrednika)->opisBiljke
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.biljka_poljoprivrednikas.inputs.poljoprivrednikID')
                    </h5>
                    <span
                        >{{
                        optional($biljkaPoljoprivrednika->poljoprivrednikBiljkaPoljoprivrednika)->adresa
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.biljka_poljoprivrednikas.inputs.minNedeljniPrinos')
                    </h5>
                    <span
                        >{{ $biljkaPoljoprivrednika->minNedeljniPrinos ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.biljka_poljoprivrednikas.inputs.stanjeBiljke')
                    </h5>
                    <span
                        >{{ $biljkaPoljoprivrednika->stanjeBiljke ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('biljka-poljoprivrednikas.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\BiljkaPoljoprivrednika::class)
                <a
                    href="{{ route('biljka-poljoprivrednikas.create') }}"
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
