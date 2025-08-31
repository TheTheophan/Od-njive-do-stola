@php $editing = isset($faktura) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="paketKorisnikaID"
            label="Paket Korisnika Faktura"
            required
        >
            @php $selected = old('paketKorisnikaID', ($editing ? $faktura->paketKorisnikaID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Paket Korisnika</option>
            @foreach($paketKorisnikas as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="cena"
            label="Cena"
            :value="old('cena', ($editing ? $faktura->cena : ''))"
            max="255"
            step="0.01"
            placeholder="Cena"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="tekstFakture"
            label="Tekst Fakture"
            :value="old('tekstFakture', ($editing ? $faktura->tekstFakture : ''))"
            maxlength="255"
            placeholder="Tekst Fakture"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="placeno"
            label="Placeno"
            :checked="old('placeno', ($editing ? $faktura->placeno : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="datumPlacanja"
            label="Datum Placanja"
            value="{{ old('datumPlacanja', ($editing ? optional($faktura->datumPlacanja)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group>
</div>
