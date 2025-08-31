@php $editing = isset($biljka) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="opisBiljke"
            label="Opis Biljke"
            :value="old('opisBiljke', ($editing ? $biljka->opisBiljke : ''))"
            maxlength="255"
            placeholder="Opis Biljke"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="nazivBiljke"
            label="Naziv Biljke"
            :value="old('nazivBiljke', ($editing ? $biljka->nazivBiljke : ''))"
            maxlength="30"
            placeholder="Naziv Biljke"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="sezona"
            label="Sezona"
            :value="old('sezona', ($editing ? $biljka->sezona : ''))"
            maxlength="25"
            placeholder="Sezona"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
