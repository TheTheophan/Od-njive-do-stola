<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Od njive do stola</title>
        
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        
        <!-- Icons -->
        <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
        
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        
        @livewireStyles
    </head>
    
    <body>
        <div id="app">
            @include('layouts.nav')
        
            <main class="py-4">
                @yield('content')



                <div class="container mx-auto px-4">
                    <h1 class="text-3xl font-bold my-6 d-flex align-items-center justify-content-center text-center" style="gap:0.5rem;">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:2.2rem; margin-right:0.5rem; vertical-align:middle;">
                        <span>
                            <span style="color:#29A645;">Dobro</span><span style="color:#FF760F;">došli!</span>
                        </span>
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:2.2rem; margin-left:0.5rem; vertical-align:middle;">
                    </h1>
                    <p class="mb-8">
                        Trenutno ste na platformi "Od njive do stola". Ovde možete pronaći najbolje pakete pretplata na dostavu hrane koji vam obezbeđuju maksimalno sveže namirnice iz domaće proizvodnje. Postoji ponuda za svaku količinu namirnica koja vam može biti potrebna. Sva hrana dolazi od poljoprivrednika iz centralne Srbije sa poljoprivrednog gazdinstva "Popović" sa brojem gazdinstva 123456789. Otvoreni smo i za organizovanu šetnju i druženje uz obilazak naše okoline, bašti i domaćinstva kako bi stekli bolji međusobni odnos i vaše poverenje u nas i kvalitet naših proizvoda.                        
                        <div></div>
                         Ako želite da osetite ukus nostalgije i kvaliteta ne tretiranih biljaka, na pravom ste mestu. Mi vam pružamo uslugu dostave zdravih biljaka koja je ubrana maksimalno dva, ali uglavnom isti dan, sa domaćih imanja koja direktno sa gazdinstava dolaze tačno na vaša vrata. Uklanjamo potrebu za otkupljivače, posrednike i odlazak u velike markete koji nabavljaju proizvode iz inostranstva i prodaju ih po višim cenama, i još sve to na štetu kvaliteta i svežine. Naša misija je da vam omogućimo pristup najkvalitetnijim namirnicama po pristupačnim cenama, direktno od proizvođača do vašeg stola.
                    </p>

                    <div class="row justify-content-center">
                        @foreach (\App\Models\TipPaketa::take(3)->get() as $paket)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100" style="border-radius: 16px; overflow: hidden;">
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
                                                <button class="btn w-100 py-2" style="background:#FF760F; color:#fff; font-weight:bold; border:none; font-size:1.15rem;">Pretplati se</button>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center my-4">
                        <h3>Da bi ste videli celu ponudu i pretplatili se na paket morate biti registrovani korisnik i da se ulogujete ako niste.</h3>
                    </div>


                </div>

            </main>
        </div>

        @stack('modals')
        
        @livewireScripts
        
        @stack('scripts')
        
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        
        @if (session()->has('success')) 
        <script>
            var notyf = new Notyf({dismissible: true})
            notyf.success('{{ session('success') }}')
        </script> 
        @endif
        
        <script>
            /* Simple Alpine Image Viewer */
            document.addEventListener('alpine:init', () => {
                Alpine.data('imageViewer', (src = '') => {
                    return {
                        imageUrl: src,
        
                        refreshUrl() {
                            this.imageUrl = this.$el.getAttribute("image-url")
                        },
        
                        fileChosen(event) {
                            this.fileToDataUrl(event, src => this.imageUrl = src)
                        },
        
                        fileToDataUrl(event, callback) {
                            if (! event.target.files.length) return
        
                            let file = event.target.files[0],
                                reader = new FileReader()
        
                            reader.readAsDataURL(file)
                            reader.onload = e => callback(e.target.result)
                        },
                    }
                })
            })
        </script>
    </body>
</html>