@php $editing = isset($slika) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="upotrebaSlike"
            label="Upotreba Slike"
            :value="old('upotrebaSlike', ($editing ? $slika->upotrebaSlike : ''))"
            maxlength="100"
            placeholder="Upotreba Slike"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="nazivDatoteke"
            label="Naziv Datoteke"
            :value="old('nazivDatoteke', ($editing ? $slika->nazivDatoteke : ''))"
            maxlength="255"
            placeholder="Naziv Datoteke"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="slika"
            label="Slika"
            :value="old('slika', ($editing ? $slika->slika : ''))"
            maxlength="255"
            placeholder="Slika"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="poljoprivrednikID"
            label="Poljoprivrednik Slika"
            required
        >
            @php $selected = old('poljoprivrednikID', ($editing ? $slika->poljoprivrednikID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Poljoprivrednik</option>
            @foreach($poljoprivredniks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
