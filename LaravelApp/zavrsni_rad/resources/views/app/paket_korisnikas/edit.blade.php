@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('paket-korisnikas.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @php
                    $isAdmin = auth()->user() && auth()->user()->email === 'admin@admin.com';
                @endphp
                @if($isAdmin)
                    @lang('crud.paket_korisnikas.edit_title')
                @else
                    Pregled porucenog paketa
                @endif

            </h4>

            @php
                $isAdmin = auth()->user() && auth()->user()->email === 'admin@admin.com';
            @endphp
            <x-form
                method="PUT"
                action="{{ route('paket-korisnikas.update', $paketKorisnika) }}"
                class="mt-4"
            >
                @include('app.paket_korisnikas.form-inputs', ['readOnly' => !$isAdmin])

                <div class="mt-4">
                    <a
                        href="{{ route('paket-korisnikas.index') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    @if($isAdmin)
                        <a
                            href="{{ route('paket-korisnikas.create') }}"
                            class="btn btn-light"
                        >
                            <i class="icon ion-md-add text-primary"></i>
                            @lang('crud.common.create')
                        </a>

                        <button type="submit" class="btn btn-primary float-right">
                            <i class="icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>
                    @endif
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
