@php $editing = isset($biljkaPoljoprivrednika) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="biljkaID"
            label="Biljka Biljka Poljoprivrednika"
            required
        >
            @php $selected = old('biljkaID', ($editing ? $biljkaPoljoprivrednika->biljkaID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Biljka</option>
            @foreach($biljkas as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="poljoprivrednikID"
            label="Poljoprivrednik Biljka Poljoprivrednika"
            required
        >
            @php $selected = old('poljoprivrednikID', ($editing ? $biljkaPoljoprivrednika->poljoprivrednikID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Poljoprivrednik</option>
            @foreach($poljoprivredniks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="minNedeljniPrinos"
            label="Min Nedeljni Prinos"
            :value="old('minNedeljniPrinos', ($editing ? $biljkaPoljoprivrednika->minNedeljniPrinos : ''))"
            max="255"
            step="0.01"
            placeholder="Min Nedeljni Prinos"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="stanjeBiljke"
            label="Stanje Biljke"
            :value="old('stanjeBiljke', ($editing ? $biljkaPoljoprivrednika->stanjeBiljke : ''))"
            maxlength="255"
            placeholder="Stanje Biljke"
        ></x-inputs.text>
    </x-inputs.group>
</div>
