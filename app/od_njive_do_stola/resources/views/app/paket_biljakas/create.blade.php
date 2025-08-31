@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('paket-biljakas.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.paket_biljakas.create_title')
            </h4>

            <x-form
                method="POST"
                action="{{ route('paket-biljakas.store') }}"
                class="mt-4"
            >
                @include('app.paket_biljakas.form-inputs')

                <div class="mt-4">
                    <a
                        href="{{ route('paket-biljakas.index') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.create')
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
