@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.poljoprivredniks.index_title')
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
                        @can('create', App\Models\Poljoprivrednik::class)
                        <a
                            href="{{ route('poljoprivredniks.create') }}"
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
                                @lang('crud.poljoprivredniks.inputs.adresa')
                            </th>
                            <th class="text-left">
                                @lang('crud.poljoprivredniks.inputs.ime')
                            </th>
                            <th class="text-left">
                                @lang('crud.poljoprivredniks.inputs.prezime')
                            </th>
                            <th class="text-left">
                                @lang('crud.poljoprivredniks.inputs.gradID')
                            </th>
                            <th class="text-left">
                                @lang('crud.poljoprivredniks.inputs.opisAdrese')
                            </th>
                            <th class="text-left">
                                @lang('crud.poljoprivredniks.inputs.brojTelefona')
                            </th>
                            <th class="text-right">
                                @lang('crud.poljoprivredniks.inputs.brojHektara')
                            </th>
                            <th class="text-left">
                                @lang('crud.poljoprivredniks.inputs.brojGazdinstva')
                            </th>
                            <th class="text-left">
                                @lang('crud.poljoprivredniks.inputs.plastenickaProizvodnja')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($poljoprivredniks as $poljoprivrednik)
                        <tr>
                            <td>{{ $poljoprivrednik->adresa ?? '-' }}</td>
                            <td>{{ $poljoprivrednik->ime ?? '-' }}</td>
                            <td>{{ $poljoprivrednik->prezime ?? '-' }}</td>
                            <td>
                                {{
                                optional($poljoprivrednik->gradpoljoprivrednika)->nazivGrada
                                ?? '-' }}
                            </td>
                            <td>{{ $poljoprivrednik->opisAdrese ?? '-' }}</td>
                            <td>{{ $poljoprivrednik->brojTelefona ?? '-' }}</td>
                            <td>{{ $poljoprivrednik->brojHektara ?? '-' }}</td>
                            <td>
                                {{ $poljoprivrednik->brojGazdinstva ?? '-' }}
                            </td>
                            <td>
                                {{ $poljoprivrednik->plastenickaProizvodnja ??
                                '-' }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $poljoprivrednik)
                                    <a
                                        href="{{ route('poljoprivredniks.edit', $poljoprivrednik) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $poljoprivrednik)
                                    <a
                                        href="{{ route('poljoprivredniks.show', $poljoprivrednik) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $poljoprivrednik)
                                    <form
                                        action="{{ route('poljoprivredniks.destroy', $poljoprivrednik) }}"
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
                            <td colspan="10">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {!! $poljoprivredniks->render() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
