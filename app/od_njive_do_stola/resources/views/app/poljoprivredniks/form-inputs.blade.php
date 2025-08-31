@php $editing = isset($poljoprivrednik) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="adresa"
            label="Adresa"
            :value="old('adresa', ($editing ? $poljoprivrednik->adresa : ''))"
            maxlength="100"
            placeholder="Adresa"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="ime"
            label="Ime"
            :value="old('ime', ($editing ? $poljoprivrednik->ime : ''))"
            maxlength="59"
            placeholder="Ime"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="prezime"
            label="Prezime"
            :value="old('prezime', ($editing ? $poljoprivrednik->prezime : ''))"
            maxlength="60"
            placeholder="Prezime"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="gradID" label="Gradpoljoprivrednika" required>
            @php $selected = old('gradID', ($editing ? $poljoprivrednik->gradID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Grad</option>
            @foreach($grads as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="opisAdrese"
            label="Opis Adrese"
            :value="old('opisAdrese', ($editing ? $poljoprivrednik->opisAdrese : ''))"
            maxlength="255"
            placeholder="Opis Adrese"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="brojTelefona"
            label="Broj Telefona"
            :value="old('brojTelefona', ($editing ? $poljoprivrednik->brojTelefona : ''))"
            maxlength="18"
            placeholder="Broj Telefona"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="brojHektara"
            label="Broj Hektara"
            :value="old('brojHektara', ($editing ? $poljoprivrednik->brojHektara : '0.00'))"
            max="255"
            step="0.01"
            placeholder="Broj Hektara"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="brojGazdinstva"
            label="Broj Gazdinstva"
            :value="old('brojGazdinstva', ($editing ? $poljoprivrednik->brojGazdinstva : ''))"
            maxlength="12"
            placeholder="Broj Gazdinstva"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="plastenickaProizvodnja"
            label="Plastenicka Proizvodnja"
            :checked="old('plastenickaProizvodnja', ($editing ? $poljoprivrednik->plastenickaProizvodnja : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
