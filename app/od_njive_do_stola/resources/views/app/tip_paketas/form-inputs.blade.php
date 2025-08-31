@php $editing = isset($tipPaketa) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="cenaGodisnjePretplate"
            label="Cena Godisnje Pretplate"
            :value="old('cenaGodisnjePretplate', ($editing ? $tipPaketa->cenaGodisnjePretplate : ''))"
            max="255"
            step="0.01"
            placeholder="Cena Godisnje Pretplate"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="cenaMesecnePretplate"
            label="Cena Mesecne Pretplate"
            :value="old('cenaMesecnePretplate', ($editing ? $tipPaketa->cenaMesecnePretplate : ''))"
            max="255"
            step="0.01"
            placeholder="Cena Mesecne Pretplate"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="opisPaketa"
            label="Opis Paketa"
            :value="old('opisPaketa', ($editing ? $tipPaketa->opisPaketa : ''))"
            maxlength="700"
            placeholder="Opis Paketa"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="nazivPaketa"
            label="Naziv Paketa"
            :value="old('nazivPaketa', ($editing ? $tipPaketa->nazivPaketa : ''))"
            maxlength="40"
            placeholder="Naziv Paketa"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="cenaRezervacije"
            label="Cena Rezervacije"
            :value="old('cenaRezervacije', ($editing ? $tipPaketa->cenaRezervacije : ''))"
            max="255"
            step="0.01"
            placeholder="Cena Rezervacije"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
