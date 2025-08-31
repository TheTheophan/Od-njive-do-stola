@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.biljka_poljoprivrednikas.index_title')
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
                        @can('create', App\Models\BiljkaPoljoprivrednika::class)
                        <a
                            href="{{ route('biljka-poljoprivrednikas.create') }}"
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
                                @lang('crud.biljka_poljoprivrednikas.inputs.biljkaID')
                            </th>
                            <th class="text-left">
                                @lang('crud.biljka_poljoprivrednikas.inputs.poljoprivrednikID')
                            </th>
                            <th class="text-right">
                                @lang('crud.biljka_poljoprivrednikas.inputs.minNedeljniPrinos')
                            </th>
                            <th class="text-left">
                                @lang('crud.biljka_poljoprivrednikas.inputs.stanjeBiljke')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($biljkaPoljoprivrednikas as
                        $biljkaPoljoprivrednika)
                        <tr>
                            <td>
                                {{
                                optional($biljkaPoljoprivrednika->biljkaBiljkaPoljoprivrednika)->opisBiljke
                                ?? '-' }}
                            </td>
                            <td>
                                {{
                                optional($biljkaPoljoprivrednika->poljoprivrednikBiljkaPoljoprivrednika)->adresa
                                ?? '-' }}
                            </td>
                            <td>
                                {{ $biljkaPoljoprivrednika->minNedeljniPrinos ??
                                '-' }}
                            </td>
                            <td>
                                {{ $biljkaPoljoprivrednika->stanjeBiljke ?? '-'
                                }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $biljkaPoljoprivrednika)
                                    <a
                                        href="{{ route('biljka-poljoprivrednikas.edit', $biljkaPoljoprivrednika) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view',
                                    $biljkaPoljoprivrednika)
                                    <a
                                        href="{{ route('biljka-poljoprivrednikas.show', $biljkaPoljoprivrednika) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete',
                                    $biljkaPoljoprivrednika)
                                    <form
                                        action="{{ route('biljka-poljoprivrednikas.destroy', $biljkaPoljoprivrednika) }}"
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
                            <td colspan="5">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                {!! $biljkaPoljoprivrednikas->render() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
