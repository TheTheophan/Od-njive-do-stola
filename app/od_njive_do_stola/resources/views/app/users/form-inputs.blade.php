@php $editing = isset($user) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Ime i prezime"
            :value="old('name', ($editing ? $user->name : ''))"
            maxlength="255"
            placeholder="Ime i prezime"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.email
            name="email"
            label="Email"
            :value="old('email', ($editing ? $user->email : ''))"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.password
            name="password"
            label="Password"
            maxlength="255"
            placeholder="Password"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="adresaDostave"
            label="Adresa Dostave"
            :value="old('adresaDostave', ($editing ? $user->adresaDostave : ''))"
            maxlength="100"
            placeholder="Adresa Dostave"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="uputstvoZaDostavu"
            label="Uputstvo Za Dostavu"
            :value="old('uputstvoZaDostavu', ($editing ? $user->uputstvoZaDostavu : ''))"
            maxlength="255"
            placeholder="Uputstvo Za Dostavu"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="brojTelefona"
            label="Broj Telefona"
            :value="old('brojTelefona', ($editing ? $user->brojTelefona : ''))"
            maxlength="18"
            placeholder="Broj Telefona"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="postanskiBroj"
            label="Postanski Broj"
            :value="old('postanskiBroj', ($editing ? $user->postanskiBroj : ''))"
            maxlength="20"
            placeholder="Postanski Broj"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="gradID" label="Grad korisnika" required>
            @php $selected = old('gradID', ($editing ? $user->gradID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Odaberite grad</option>
            @foreach($grads as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="is_admin"
            label="Is Admin"
            :checked="old('is_admin', ($editing ? $user->is_admin : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="poljoprivrednikID"
            label="Poljoprivrednik Korisnika"
            required
        >
            @php $selected = old('poljoprivrednikID', ($editing ? $user->poljoprivrednikID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Poljoprivrednik</option>
            @foreach($poljoprivredniks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
