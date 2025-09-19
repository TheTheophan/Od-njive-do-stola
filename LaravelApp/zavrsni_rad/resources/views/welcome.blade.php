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
                    <h1 class="text-3xl font-bold my-6">Dobrodošli! </h1>
                    <p class="mb-8">
                        Trenutno ste na platformi "Od njive do stola". Ovde možete pronaći najbolje pakete koji vam obezbeđuju dostavu svežih namirnica iz domaće proizvodnje. Postoji ponuda svaku količinu namirnica koja vam može zatrebati. Da bi ste se pretplatili registrujte se i uživajte u zdravim obrocima svake nedelje, bez sumnje o kvalitetu i poreklu namirnica jer vam mi garantujemo oba.
                    </p>

                    <div class="row justify-content-center">
                        @foreach (\App\Models\TipPaketa::take(6)->get() as $paket)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title ">{{ $paket->naziv }}</h5>
                                        <p class="card-text">{{ $paket->opis }}</p>
                                        <h6 class="card-subtitle mb-2 fw-bold text-dark" style="font-size:1.1rem; letter-spacing:0.5px;">Cena pretplate</h6>
                                        <ul class="list-unstyled mb-3">
                                            <li><strong>mesečna:</strong> {{ number_format($paket->cena_mesecne_pretplate, 0, ',', '.') }} RSD</li>
                                            <li><strong>godišnja:</strong> {{ number_format($paket->cena_godisnje_pretplate, 0, ',', '.') }} RSD</li>
                                        </ul>
                                        @auth
                                            <button class="btn btn-primary mt-auto">Pretplati se</button>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
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