@php $editing = isset($paketKorisnika) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="godisnja_pretplata"
            label="Godisnja Pretplata"
            :checked="old('godisnja_pretplata', ($editing ? $paketKorisnika->godisnja_pretplata : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    @if(!isset($lockedTipPaketaId))
        <x-inputs.group class="col-sm-12">
            <x-inputs.select name="tip_paketa_id" label="Tip Paketa" required>
                @php $selected = old('tip_paketa_id', ($editing ? $paketKorisnika->tip_paketa_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tip Paketa</option>
                @foreach($tipPaketas as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>
    @endif

    @if(!isset($lockedUserId))
        <x-inputs.group class="col-sm-12">
            <x-inputs.select name="user_id" label="User" required>
                @php $selected = old('user_id', ($editing ? $paketKorisnika->user_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
                @foreach($users as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>
    @endif

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="adresa"
            label="Adresa"
            :value="old('adresa', ($editing ? $paketKorisnika->adresa : ''))"
            maxlength="254"
            placeholder="Adresa"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="uputstvo_za_dostavu"
            label="Uputstvo Za Dostavu"
            :value="old('uputstvo_za_dostavu', ($editing ? $paketKorisnika->uputstvo_za_dostavu : ''))"
            maxlength="254"
            placeholder="Uputstvo Za Dostavu"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="broj_telefona"
            label="Broj Telefona"
            :value="old('broj_telefona', ($editing ? $paketKorisnika->broj_telefona : ''))"
            maxlength="18"
            placeholder="Broj Telefona"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="postanski_broj"
            label="Postanski Broj"
            :value="old('postanski_broj', ($editing ? $paketKorisnika->postanski_broj : ''))"
            maxlength="20"
            placeholder="Postanski Broj"
        ></x-inputs.text>
    </x-inputs.group>
</div>
