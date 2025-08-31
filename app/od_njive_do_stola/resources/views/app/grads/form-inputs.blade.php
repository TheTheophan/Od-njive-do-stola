@php $editing = isset($grad) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="nazivGrada"
            label="Naziv Grada"
            :value="old('nazivGrada', ($editing ? $grad->nazivGrada : ''))"
            maxlength="25"
            placeholder="Naziv Grada"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
