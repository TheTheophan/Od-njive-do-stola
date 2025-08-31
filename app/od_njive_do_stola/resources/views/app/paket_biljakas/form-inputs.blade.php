@php $editing = isset($paketBiljaka) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="paketKorisnikaID"
            label="Paket Korisnika Paket Biljaka"
            required
        >
            @php $selected = old('paketKorisnikaID', ($editing ? $paketBiljaka->paketKorisnikaID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Paket Korisnika</option>
            @foreach($paketKorisnikas as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="biljkaPoljoprivrednikaID"
            label="Biljka Poljoprivrednika Paket Biljaka"
            required
        >
            @php $selected = old('biljkaPoljoprivrednikaID', ($editing ? $paketBiljaka->biljkaPoljoprivrednikaID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Biljka Poljoprivrednika</option>
            @foreach($biljkaPoljoprivrednikas as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="kilaza"
            label="Kilaza"
            :value="old('kilaza', ($editing ? $paketBiljaka->kilaza : ''))"
            max="255"
            step="0.01"
            placeholder="Kilaza"
        ></x-inputs.number>
    </x-inputs.group>
</div>
