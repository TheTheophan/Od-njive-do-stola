@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card position-relative" id="login-success-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Obaveštenje') }}</span>
                    <button type="button" class="close" aria-label="Close" onclick="document.getElementById('login-success-card').style.display='none';" style="font-size:1.5rem; background:none; border:none;">&times;</button>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('Uspešno ste prijavljeni!') }}
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold my-6 d-flex align-items-center justify-content-center text-center" style="gap:0.5rem;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:2.2rem; margin-right:0.5rem; vertical-align:middle;">
            <span>
                <span style="color:#29A645;">Dobro</span><span style="color:#FF760F;">došli!</span>
            </span>
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:2.2rem; margin-left:0.5rem; vertical-align:middle;">
        </h1>
        <p class="mb-8">
            Trenutno ste na platformi "Od njive do stola". Ovde možete pronaći najbolje pakete pretplate na dostavu hrane koji vam obezbeđuju maksimalno sveže namirnice iz domaće proizvodnje. Postoji ponuda za svaku količinu namirnica koja vam može biti potrebna.
            <div></div>
                Ako želite da osetite ukus nostalgije i kvaliteta ne tretiranih biljaka, na pravom ste mestu. Mi vam pružamo uslugu dostave zdravih biljaka koja je ubrana maksimalno dva, ali uglavnom isti dan, sa domaćih imanja koja direktno sa gazdinstava dolaze tačno na vaša vrata. Uklanjamo otkupljivače, posrednike i velike markete koji nabavljaju proizvode iz inostranstva i prodaju ih po višim cenama, a sve to na štetu kvaliteta i svežine. Naša misija je da vam omogućimo pristup najkvalitetnijim namirnicama po pristupačnim cenama, direktno od proizvođača do vašeg stola.
        </p>

        <div class="row justify-content-center">
            @foreach (\App\Models\TipPaketa::all() as $paket)
                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="border-radius: 16px; overflow: hidden;">
                        <!-- Header with naziv -->
                        <div style="background: #29A645; color: #fff; padding: 0.75rem; text-align: center; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                            <h5 class="card-title m-0" style="font-weight: bold; font-size: 1.25rem;">{{ $paket->naziv }}</h5>
                        </div>
                        <div class="card-body d-flex flex-column" style="height:100%;">
                            <p class="card-text mb-3">{{ $paket->opis }}</p>
                            <div class="mt-auto">
                                <div class="d-flex align-items-stretch justify-content-center mb-2" style="gap:1.5rem;">
                                    <div class="d-flex flex-column align-items-center" style="flex:1;">
                                        <span class="fw-bold text-dark" style="font-size:1.15rem;">Mesečno</span>
                                        <span class="fw-bold text-primary" style="font-size:2.2rem; line-height:1;">{{ number_format($paket->cena_mesecne_pretplate, 0, ',', '.') }} RSD</span>
                                    </div>
                                    <div class="d-flex flex-column align-items-center justify-content-center" style="padding:0 1rem;">
                                        <span style="font-size:2.2rem; color:#FF760F; font-weight:bold;">/</span>
                                    </div>
                                    <div class="d-flex flex-column align-items-center" style="flex:1;">
                                        <span class="fw-bold text-dark" style="font-size:1.15rem;">Godišnje</span>
                                        <span class="fw-bold text-success" style="font-size:2.2rem; line-height:1;">{{ number_format($paket->cena_godisnje_pretplate, 0, ',', '.') }} RSD</span>
                                    </div>
                                </div>
                                @auth
                                    <!--<button class="btn w-100 py-2" style="background:#FF760F; color:#fff; font-weight:bold; border:none; font-size:1.15rem;">Pretplati se</button>-->

                                    <a href="{{ route('paket-korisnikas.create', ['tip_paketa_id' => $paket->id]) }}" class="btn w-100 py-2" style="background:#FF760F; color:#fff; font-weight:bold; border:none; font-size:1.15rem;">
                                        Pretplati se
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @guest
        <div class="text-center my-4">
            <h3>Da bi ste videli celu ponudu i pretplatili se na paket morate biti registrovani korisnik i da se ulogujete ako niste.</h3>
        </div>
        @endguest


    </div>

</div>
@endsection
