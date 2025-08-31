@php $editing = isset($paketKorisnika) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="godisnjaPretplata"
            label="Godisnja Pretplata"
            :checked="old('godisnjaPretplata', ($editing ? $paketKorisnika->godisnjaPretplata : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="tipPaketaID"
            label="Tip Paketa Paket Korisnika"
            required
        >
            @php $selected = old('tipPaketaID', ($editing ? $paketKorisnika->tipPaketaID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tip Paketa</option>
            @foreach($tipPaketas as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="userID" label="User Paket Korisnika" required>
            @php $selected = old('userID', ($editing ? $paketKorisnika->userID : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
