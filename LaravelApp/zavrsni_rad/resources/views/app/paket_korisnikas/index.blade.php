@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.paket_korisnikas.index_title')
                </h4>
            </div>

            <div class="searchbar mt-4 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="input-group">
                                <input
                                    id="indexSearch"
                                    type="text"
                                    name="search"
                                    placeholder="{{ __('crud.common.search') }}"
                                    value="{{ $search ?? '' }}"
                                    class="form-control"
                                    autocomplete="off"
                                />
                                <div class="input-group-append">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        <i class="icon ion-md-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        @can('create', App\Models\PaketKorisnika::class)
                        <a
                            href="{{ route('paket-korisnikas.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.paket_korisnikas.inputs.godisnja_pretplata')
                            </th>
                            <th class="text-left">
                                @lang('crud.paket_korisnikas.inputs.tip_paketa_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.paket_korisnikas.inputs.user_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.paket_korisnikas.inputs.adresa')
                            </th>
                            <th class="text-left">
                                @lang('crud.paket_korisnikas.inputs.uputstvo_za_dostavu')
                            </th>
                            <th class="text-left">
                                @lang('crud.paket_korisnikas.inputs.broj_telefona')
                            </th>
                            <th class="text-left">
                                @lang('crud.paket_korisnikas.inputs.postanski_broj')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paketKorisnikas as $paketKorisnika)
                        <tr>
                            <td>
                                {{ $paketKorisnika->godisnja_pretplata ?? '-' }}
                            </td>
                            <td>
                                {{ optional($paketKorisnika->tipPaketa)->naziv
                                ?? '-' }}
                            </td>
                            <td>
                                {{ optional($paketKorisnika->user)->name ?? '-'
                                }}
                            </td>
                            <td>{{ $paketKorisnika->adresa ?? '-' }}</td>
                            <td>
                                {{ $paketKorisnika->uputstvo_za_dostavu ?? '-'
                                }}
                            </td>
                            <td>{{ $paketKorisnika->broj_telefona ?? '-' }}</td>
                            <td>
                                {{ $paketKorisnika->postanski_broj ?? '-' }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $paketKorisnika)
                                    <a
                                        href="{{ route('paket-korisnikas.edit', $paketKorisnika) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $paketKorisnika)
                                    <a
                                        href="{{ route('paket-korisnikas.show', $paketKorisnika) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $paketKorisnika)
                                    <form
                                        action="{{ route('paket-korisnikas.destroy', $paketKorisnika) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                {!! $paketKorisnikas->render() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
