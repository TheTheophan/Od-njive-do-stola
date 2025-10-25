@php $editing = isset($faktura) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="paket_korisnika_id"
            label="Paket korisnika"
            required
        >
            @php $selected = old('paket_korisnika_id', ($editing ? $faktura->paket_korisnika_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Paket korisnika</option>
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
            max="99999999"
            step="0.01"
            placeholder="Cena"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="tekst"
            label="Tekst"
            :value="old('tekst', ($editing ? $faktura->tekst : ''))"
            maxlength="254"
            placeholder="Tekst"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="placeno"
            label="Placeno"
            :checked="old('placeno', ($editing ? $faktura->placeno : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
