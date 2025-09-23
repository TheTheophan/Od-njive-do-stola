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
        'index_title' => 'Fakturas List',
        'new_title' => 'New Faktura',
        'create_title' => 'Create Faktura',
        'edit_title' => 'Edit Faktura',
        'show_title' => 'Show Faktura',
        'inputs' => [
            'paket_korisnika_id' => 'Paket Korisnika',
            'cena' => 'Cena',
            'tekst' => 'Tekst',
            'placeno' => 'Placeno',
        ],
    ],

    'paket_korisnikas' => [
        'name' => 'Paket Korisnikas',
        'index_title' => 'PaketKorisnikas List',
        'new_title' => 'New Paket korisnika',
        'create_title' => 'Create PaketKorisnika',
        'edit_title' => 'Edit PaketKorisnika',
        'show_title' => 'Show PaketKorisnika',
        'inputs' => [
            'godisnja_pretplata' => 'Godisnja Pretplata',
            'tip_paketa_id' => 'Tip Paketa',
            'user_id' => 'User',
            'adresa' => 'Adresa',
            'uputstvo_za_dostavu' => 'Uputstvo Za Dostavu',
            'broj_telefona' => 'Broj Telefona',
            'postanski_broj' => 'Postanski Broj',
        ],
    ],

    'tip_paketas' => [
        'name' => 'Tip Paketas',
        'index_title' => 'TipPaketas List',
        'new_title' => 'New Tip paketa',
        'create_title' => 'Create TipPaketa',
        'edit_title' => 'Edit TipPaketa',
        'show_title' => 'Show TipPaketa',
        'inputs' => [
            'cena_godisnje_pretplate' => 'Cena Godisnje Pretplate',
            'cena_mesecne_pretplate' => 'Cena Mesecne Pretplate',
            'opis' => 'Opis',
            'naziv' => 'Naziv',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],
];
