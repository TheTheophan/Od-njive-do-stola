@php $editing = isset($tipPaketa) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="cena_godisnje_pretplate"
            label="Cena godišnje pretplate"
            :value="old('cena_godisnje_pretplate', ($editing ? $tipPaketa->cena_godisnje_pretplate : ''))"
            max="99999999"
            step="0.01"
            placeholder="Cena godišnje pretplate"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="cena_mesecne_pretplate"
            label="Cena mesečne pretplate"
            :value="old('cena_mesecne_pretplate', ($editing ? $tipPaketa->cena_mesecne_pretplate : ''))"
            max="99999999"
            step="0.01"
            placeholder="Cena mesečne pretplate"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="opis" label="Opis" maxlength="9999"
            >{{ old('opis', ($editing ? $tipPaketa->opis : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="naziv"
            label="Naziv"
            :value="old('naziv', ($editing ? $tipPaketa->naziv : ''))"
            maxlength="64"
            placeholder="Naziv"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
