@php $editing = isset($paketKorisnika) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        @php $isDisabled = isset($readOnly) && $readOnly; @endphp
        <x-inputs.checkbox
            name="godisnja_pretplata"
            label="Godišnja pretplata"
            :checked="old('godisnja_pretplata', ($editing ? $paketKorisnika->godisnja_pretplata : 0))"
            :disabled="$isDisabled"
        ></x-inputs.checkbox>
    </x-inputs.group>

    @if(!isset($lockedTipPaketaId))
        <x-inputs.group class="col-sm-12">
            @php $isDisabled = isset($readOnly) && $readOnly; @endphp
            <x-inputs.select name="tip_paketa_id" label="Tip Paketa" required :disabled="$isDisabled">
                @php $selected = old('tip_paketa_id', ($editing ? $paketKorisnika->tip_paketa_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Odaberite tip paketa</option>
                @foreach($tipPaketas as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>
    @endif

    @if(!isset($lockedUserId))
        <x-inputs.group class="col-sm-12">
            @php $isDisabled = isset($readOnly) && $readOnly; @endphp
            <x-inputs.select name="user_id" label="Korisnik" required :disabled="$isDisabled">
                @php $selected = old('user_id', ($editing ? $paketKorisnika->user_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Odaberite korisnika</option>
                @foreach($users as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>
    @endif

    <x-inputs.group class="col-sm-12">
        @php $isReadOnly = isset($readOnly) && $readOnly; @endphp
        <x-inputs.text
            name="adresa"
            label="Adresa"
            :value="old('adresa', ($editing ? $paketKorisnika->adresa : ''))"
            maxlength="254"
            placeholder="Adresa"
            required
            :readonly="$isReadOnly"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        @php $isReadOnly = isset($readOnly) && $readOnly; @endphp
        <x-inputs.text
            name="uputstvo_za_dostavu"
            label="Uputstvo za dostavu"
            :value="old('uputstvo_za_dostavu', ($editing ? $paketKorisnika->uputstvo_za_dostavu : ''))"
            maxlength="254"
            placeholder="Uputstvo za dostavu"
            :readonly="$isReadOnly"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        @php $isReadOnly = isset($readOnly) && $readOnly; @endphp
        <x-inputs.text
            name="broj_telefona"
            label="Broj telefona"
            :value="old('broj_telefona', ($editing ? $paketKorisnika->broj_telefona : ''))"
            maxlength="18"
            placeholder="Broj telefona"
            :readonly="$isReadOnly"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        @php $isReadOnly = isset($readOnly) && $readOnly; @endphp
        <x-inputs.text
            name="postanski_broj"
            label="Poštanski broj"
            :value="old('postanski_broj', ($editing ? $paketKorisnika->postanski_broj : ''))"
            maxlength="20"
            placeholder="Poštanski broj"
            :readonly="$isReadOnly"
        ></x-inputs.text>
    </x-inputs.group>
</div>
