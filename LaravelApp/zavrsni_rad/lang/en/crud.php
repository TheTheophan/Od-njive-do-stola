<?php

return [
    'common' => [
        'actions' => 'Upravljanje',
        'create' => 'Kreiraj',
        'edit' => 'Izmeni',
        'update' => 'Ažuriraj',
        'new' => 'Novi',
        'cancel' => 'Otkaži',
        'attach' => 'Prikači',
        'detach' => 'Odvoji',
        'save' => 'Sačuvaj',
        'delete' => 'Obriši',
        'delete_selected' => 'Obriši odabrano',
        'search' => 'Pretraži...',
        'back' => 'Nazad',
        'are_you_sure' => 'Da li ste sigurni?',
        'no_items_found' => 'Nema pronađenih stavki',
        'created' => 'Uspešno kreirano',
        'saved' => 'Uspešno sačuvano',
        'removed' => 'Uspešno uklonjeno',
    ],

    'fakturas' => [
        'name' => 'Fakturas',
        'index_title' => 'Lista faktura',
        'new_title' => 'Nova faktura',
        'create_title' => 'Kreiraj fakturu',
        'edit_title' => 'Izmeni fakturu',
        'show_title' => 'Prikaži fakturu',
        'inputs' => [
            'paket_korisnika_id' => 'Paket korisnika',
            'cena' => 'Cena',
            'tekst' => 'Tekst',
            'placeno' => 'Placeno',
        ],
    ],

    'paket_korisnikas' => [
        'name' => 'Paket Korisnikas',
        'index_title' => 'Lista poručenih paketa',
        'new_title' => 'Novi paket korisnika',
        'create_title' => 'Kreiraj paket korisnika',
        'edit_title' => 'Izmeni paket korisnika',
        'show_title' => 'Prikaži paket korisnika',
        'inputs' => [
            'godisnja_pretplata' => 'Godišnja pretplata',
            'tip_paketa_id' => 'Tip Paketa',
            'user_id' => 'Korisnik',
            'adresa' => 'Adresa',
            'uputstvo_za_dostavu' => 'Uputstvo za dostavu',
            'broj_telefona' => 'Broj telefona',
            'postanski_broj' => 'Poštanski broj',
        ],
    ],

    'tip_paketas' => [
        'name' => 'Tip Paketas',
        'index_title' => 'Lista tipova paketa',
        'new_title' => 'Novi tip paketa',
        'create_title' => 'Kreiraj tip paketa',
        'edit_title' => 'Izmeni tip paketa',
        'show_title' => 'Prikaži tip paketa',
        'inputs' => [
            'cena_godisnje_pretplate' => 'Cena Godisnje Pretplate',
            'cena_mesecne_pretplate' => 'Cena Mesecne Pretplate',
            'opis' => 'Opis',
            'naziv' => 'Naziv',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Lista korisnika',
        'new_title' => 'Novi korisnik',
        'create_title' => 'Kreiraj korisnika',
        'edit_title' => 'Izmeni korisnika',
        'show_title' => 'Prikaži korisnika',
        'inputs' => [
            'name' => 'Ime',
            'email' => 'Email',
            'password' => 'Lozinka',
        ],
    ],
];
