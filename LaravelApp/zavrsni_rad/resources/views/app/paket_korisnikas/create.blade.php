@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @php
            // Find the selected packet object for the card
            $tipPaketaObj = null;
            if(isset($lockedTipPaketaId)) {
                $tipPaketaObj = \App\Models\TipPaketa::find($lockedTipPaketaId);
            }
        @endphp
        @if($tipPaketaObj)
        <div class="col-md-5 mb-4">
            <!-- Packet Info Card (copied from home.blade.php) -->
            <div class="card h-38" style="border-radius: 16px; overflow: hidden;">
                <div style="background: #29A645; color: #fff; padding: 0.75rem; text-align: center; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                    <h5 class="card-title m-0" style="font-weight: bold; font-size: 1.25rem;">{{ $tipPaketaObj->naziv }}</h5>
                </div>
                <div class="card-body d-flex flex-column" style="height:100%;">
                    <p class="card-text mb-3">{{ $tipPaketaObj->opis }}</p>
                    <div class="mt-auto">
                        <div class="d-flex align-items-stretch justify-content-center mb-2" style="gap:1.5rem;">
                            <div class="d-flex flex-column align-items-center" style="flex:1;">
                                <span class="fw-bold text-dark" style="font-size:1.15rem;">Mesečna</span>
                                <span class="fw-bold text-primary" style="font-size:2.2rem; line-height:1;">{{ number_format($tipPaketaObj->cena_mesecne_pretplate, 0, ',', '.') }} RSD</span>
                            </div>
                            <div class="d-flex flex-column align-items-center justify-content-center" style="padding:0 1rem;">
                                <span style="font-size:2.2rem; color:#FF760F; font-weight:bold;">/</span>
                            </div>
                            <div class="d-flex flex-column align-items-center" style="flex:1;">
                                <span class="fw-bold text-dark" style="font-size:1.15rem;">Godišnja</span>
                                <span class="fw-bold text-success" style="font-size:2.2rem; line-height:1;">{{ number_format($tipPaketaObj->cena_godisnje_pretplate, 0, ',', '.') }} RSD</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info paragraph below the packet card -->
            <div class="mt-3">
                <div class="alert alert-info" style="border-radius: 12px;">
                    <p class="mb-1">
                        Dostava paketa se vrši jednom nedeljno. Dan dostave je <strong>subota</strong> osim ako nije vanredna situacija kada se može desiti da je dostava nedelja medjutim u tom slučaju ćete biti blagovremeno obavešteni. Uz mesečni plan pretplate dobijate 4 dostave tokom meseca, dok godišnji plan obuhvata 10 meseci dostava (ukupno 40 dostava godišnje). U toku januara i februara nije moguća pretplata. U slučaju praznika ili vanrednih situacija, moguća je promena vremena ili datuma dostave, o čemu ćete biti blagovremeno obavešteni putem elektronske pošte. Pretplata na mesečni plan se ne obnavlja automatski, kada istekne morate se ponovo pretplatiti na paket.
                    </p>
                </div>
            </div>

        </div>
        @endif
        <div class="col-md-7 mb-4">
            <div class="card" style="border-radius: 16px; min-width:320px; max-width:100%;">
                <div class="card-body" style="padding:1.5rem 1.2rem;">
                    <h4 class="card-title d-flex align-items-center" style="margin-bottom:1.2rem;">
                        <a href="{{ route('paket-korisnikas.index') }}" class="mr-4">
                            <i class="icon ion-md-arrow-back"></i>
                        </a>
                        <div class="flex-grow-1 text-center">
                            <h1 class="mb-0" style="font-size:1.5rem;">Unesite podatke</h1>
                        </div>
                    </h4>
                    <x-form
                        method="POST"
                        action="{{ route('paket-korisnikas.store') }}"
                        class="mt-2"
                    >
                        @php
                            $lockedTipPaketa = isset($lockedTipPaketaId) ? $tipPaketas[$lockedTipPaketaId] ?? null : null;
                            $lockedUser = isset($lockedUserId) ? $users[$lockedUserId] ?? null : null;
                        @endphp

                        @if($lockedTipPaketa)
                            <div class="form-group">
                                <label>Tip Paketa</label>
                                <input type="text" class="form-control" value="{{ $lockedTipPaketa }}" readonly>
                                <input type="hidden" name="tip_paketa_id" value="{{ $lockedTipPaketaId }}">
                            </div>
                        @endif
                        @if($lockedUser)
                            <div class="form-group">
                                <label>Korisnik</label>
                                <input type="text" class="form-control" value="{{ $lockedUser }}" readonly>
                                <input type="hidden" name="user_id" value="{{ $lockedUserId }}">
                            </div>
                        @endif

                        @include('app.paket_korisnikas.form-inputs')

                        <div class="mt-4">
                            <a
                                href="{{ route('paket-korisnikas.index') }}"
                                class="btn btn-light"
                            >
                                <i class="icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a>

                            <button type="submit" class="btn btn-primary float-right">
                                <i class="icon ion-md-save"></i>
                                @lang('crud.common.create')
                            </button>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
