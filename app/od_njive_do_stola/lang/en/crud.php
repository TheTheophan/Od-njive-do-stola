<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'grads' => [
        'name' => 'Grads',
        'index_title' => 'Grads List',
        'new_title' => 'New Grad',
        'create_title' => 'Create Grad',
        'edit_title' => 'Edit Grad',
        'show_title' => 'Show Grad',
        'inputs' => [
            'nazivGrada' => 'Naziv Grada',
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
            'name' => 'Ime i prezime',
            'email' => 'Email',
            'password' => 'Password',
            'adresaDostave' => 'Adresa Dostave',
            'uputstvoZaDostavu' => 'Uputstvo Za Dostavu',
            'brojTelefona' => 'Broj Telefona',
            'postanskiBroj' => 'Postanski Broj',
            'gradID' => 'Grad korisnika',
            'is_admin' => 'Is Admin',
            'poljoprivrednikID' => 'Poljoprivrednik Korisnika',
        ],
    ],

    'poljoprivredniks' => [
        'name' => 'Poljoprivredniks',
        'index_title' => 'Poljoprivredniks List',
        'new_title' => 'New Poljoprivrednik',
        'create_title' => 'Create Poljoprivrednik',
        'edit_title' => 'Edit Poljoprivrednik',
        'show_title' => 'Show Poljoprivrednik',
        'inputs' => [
            'adresa' => 'Adresa',
            'ime' => 'Ime',
            'prezime' => 'Prezime',
            'gradID' => 'Gradpoljoprivrednika',
            'opisAdrese' => 'Opis Adrese',
            'brojTelefona' => 'Broj Telefona',
            'brojHektara' => 'Broj Hektara',
            'brojGazdinstva' => 'Broj Gazdinstva',
            'plastenickaProizvodnja' => 'Plastenicka Proizvodnja',
        ],
    ],

    'biljkas' => [
        'name' => 'Biljkas',
        'index_title' => 'Biljkas List',
        'new_title' => 'New Biljka',
        'create_title' => 'Create Biljka',
        'edit_title' => 'Edit Biljka',
        'show_title' => 'Show Biljka',
        'inputs' => [
            'opisBiljke' => 'Opis Biljke',
            'nazivBiljke' => 'Naziv Biljke',
            'sezona' => 'Sezona',
        ],
    ],

    'biljka_poljoprivrednikas' => [
        'name' => 'Biljka Poljoprivrednikas',
        'index_title' => 'BiljkaPoljoprivrednikas List',
        'new_title' => 'New Biljka poljoprivrednika',
        'create_title' => 'Create BiljkaPoljoprivrednika',
        'edit_title' => 'Edit BiljkaPoljoprivrednika',
        'show_title' => 'Show BiljkaPoljoprivrednika',
        'inputs' => [
            'biljkaID' => 'Biljka Biljka Poljoprivrednika',
            'poljoprivrednikID' => 'Poljoprivrednik Biljka Poljoprivrednika',
            'minNedeljniPrinos' => 'Min Nedeljni Prinos',
            'stanjeBiljke' => 'Stanje Biljke',
        ],
    ],

    'fakturas' => [
        'name' => 'Fakturas',
        'index_title' => 'Fakturas List',
        'new_title' => 'New Faktura',
        'create_title' => 'Create Faktura',
        'edit_title' => 'Edit Faktura',
        'show_title' => 'Show Faktura',
        'inputs' => [
            'paketKorisnikaID' => 'Paket Korisnika Faktura',
            'cena' => 'Cena',
            'tekstFakture' => 'Tekst Fakture',
            'placeno' => 'Placeno',
            'datumPlacanja' => 'Datum Placanja',
        ],
    ],

    'paket_biljakas' => [
        'name' => 'Paket Biljakas',
        'index_title' => 'PaketBiljakas List',
        'new_title' => 'New Paket biljaka',
        'create_title' => 'Create PaketBiljaka',
        'edit_title' => 'Edit PaketBiljaka',
        'show_title' => 'Show PaketBiljaka',
        'inputs' => [
            'paketKorisnikaID' => 'Paket Korisnika Paket Biljaka',
            'biljkaPoljoprivrednikaID' =>
                'Biljka Poljoprivrednika Paket Biljaka',
            'kilaza' => 'Kilaza',
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
            'godisnjaPretplata' => 'Godisnja Pretplata',
            'tipPaketaID' => 'Tip Paketa Paket Korisnika',
            'userID' => 'User Paket Korisnika',
        ],
    ],

    'slikas' => [
        'name' => 'Slikas',
        'index_title' => 'Slikas List',
        'new_title' => 'New Slika',
        'create_title' => 'Create Slika',
        'edit_title' => 'Edit Slika',
        'show_title' => 'Show Slika',
        'inputs' => [
            'upotrebaSlike' => 'Upotreba Slike',
            'nazivDatoteke' => 'Naziv Datoteke',
            'slika' => 'Slika',
            'poljoprivrednikID' => 'Poljoprivrednik Slika',
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
            'cenaGodisnjePretplate' => 'Cena Godisnje Pretplate',
            'cenaMesecnePretplate' => 'Cena Mesecne Pretplate',
            'opisPaketa' => 'Opis Paketa',
            'nazivPaketa' => 'Naziv Paketa',
            'cenaRezervacije' => 'Cena Rezervacije',
        ],
    ],
];
