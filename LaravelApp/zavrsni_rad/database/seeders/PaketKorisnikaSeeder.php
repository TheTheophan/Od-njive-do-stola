<?php

namespace Database\Seeders;

use App\Models\PaketKorisnika;
use Illuminate\Database\Seeder;

class PaketKorisnikaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            'Bulevar Kralja Aleksandra 120', 'Kneza Miloša 45', 'Gandijeva 17', 'Vojvode Stepe 210', 'Jurija Gagarina 14',
            'Cara Dušana 56', 'Omladinskih brigada 88', 'Takovska 23', 'Bulevar Zorana Đinđića 101', 'Mije Kovačevića 9',
            'Vojvode Vuka 33', 'Bulevar oslobođenja 50', 'Gospodara Vučića 99', 'Cvijićeva 130', 'Bulevar Evrope 12',
            'Bulevar Arsenija Čarnojevića 75', 'Bulevar Mihajla Pupina 165', 'Bulevar Nikole Tesle 1', 'Zmaj Jovina 22', 'Kraljice Natalije 27',
            'Resavska 18', 'Palmotićeva 60', 'Bulevar Despota Stefana 80', 'Kralja Petra 10', 'Bulevar Vojvode Mišića 29',
            'Bulevar JNA 5', 'Bulevar Patrijarha Pavla 21', 'Bulevar Svetog Cara Konstantina 44', 'Bulevar Milutina Milankovića 134', 'Bulevar Kralja Aleksandra 200',
            'Bulevar Zorana Đinđića 55', 'Bulevar Mihajla Pupina 10', 'Bulevar Evrope 20', 'Bulevar Arsenija Čarnojevića 100', 'Bulevar Nikole Tesle 5',
            'Gandijeva 30', 'Jurija Gagarina 50', 'Takovska 40', 'Kneza Miloša 100', 'Vojvode Stepe 300'
        ];

        $instructions = [
            '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
            'Zgrada ima visoko prizemlje pa prvi sprat.',
            'Vrata stana su desno kad se izadje iz lifta i desno do kraja hodnika.',
            'Zvono ne radi, kucajte na vrata rucno.',
            'Stan je na trećem spratu, levo od lifta.',
            'Ulaz je sa dvorišne strane.',
            'Pozvonite dva puta, pas je miran.',
            'Stan se nalazi na kraju hodnika, vrata su crvena.',
            'Lift ne radi, koristite stepenice.',
            'Stan je pored prodavnice, vrata sa brojem 5.',
            'Stan ima interfon, pozvati broj 12.'
        ];

        $phones = [
            '+381641234567', '0641234567', '+381601234567', '0601234567', '+381651234567', '0651234567', '+381661234567', '0661234567',
            '+381691234567', '0691234567', '+381631234567', '0631234567', '+381621234567', '0621234567', '+381671234567', '0671234567',
            '+381681234567', '0681234567', '+381611234567', '0611234567', '+381651234568', '0651234568', '+381641234568', '0641234568',
            '+381601234568', '0601234568', '+381661234568', '0661234568', '+381691234568', '0691234568', '+381631234568', '0631234568',
            '+381621234568', '0621234568', '+381671234568', '0671234568', '+381681234568', '0681234568', '+381611234568', '0611234568'
        ];

        $postcodes = [
            '11000', '11010', '11030', '11050', '11060', '11070', '11080', '11107', '11108', '11109',
            '11110', '11120', '11130', '11140', '11150', '11160', '11170', '11180', '11190', '11200',
            '11210', '11220', '11230', '11240', '11250', '11260', '11270', '11280', '11290', '11300', '11310',
            '11320', '11330', '11340', '11350', '11360', '11370', '11380', '11390', '11400', '11410'
        ];

        $tipPaketaIds = [1,2,3,4,5,6];
        $userIds = range(1,30);

        // 4 korisnika nema pakete
        $usedUserIds = array_slice($userIds, 0, 26);

        $entries = [];
        
        $unusedUserIds = array_slice($userIds, -4);
        $usedUserIds = array_slice($userIds, 0, 26);

        // Uputstva dostave
        $realInstructions = [
            'Zgrada ima visoko prizemlje pa prvi sprat.',
            'Vrata stana su desno kad se izadje iz lifta i desno do kraja hodnika.',
            'Zvono ne radi, kucajte na vrata rucno.',
            'Stan je na trećem spratu, levo od lifta.',
            'Ulaz je sa dvorišne strane.',
            'Pozvonite dva puta, pas je miran.',
            'Stan se nalazi na kraju hodnika, vrata su crvena.',
            'Lift ne radi, koristite stepenice.',
            'Stan je pored prodavnice, vrata sa brojem 5.',
            'Stan ima interfon, pozvati broj 12.'
        ];

        // prvih 15 imaju godisnju pretplatu;
        // tip_paketa ima 6 cestih koji se dodeljuju u krug
        // 26 zaredom i 4 random
        // adresa/telefon/postanski_broj se biraju is nizova  
        // prva 24 nemaju uputstvo
        // $i % count(...) postavlja podatke iz pocetka kada u nizu nema novih
        

        for ($i = 0; $i < 40; $i++) {
            $godisnja = $i < 15;
            $tipPaketaId = $tipPaketaIds[$i % count($tipPaketaIds)];
            $userId = $i < 26 ? $usedUserIds[$i] : $usedUserIds[array_rand($usedUserIds)];
            $adresa = $addresses[$i % count($addresses)];
            $brojTelefona = $phones[$i % count($phones)];
            $postanskiBroj = $postcodes[$i % count($postcodes)];
            // 60% prazni, 40% popunjeni
            if ($i < 24) {
                $uputstvo = '';
            } else {
                $uputstvo = $realInstructions[array_rand($realInstructions)];
            }
            $entries[] = [
                'godisnja_pretplata' => $godisnja,
                'tip_paketa_id' => $tipPaketaId,
                'user_id' => $userId,
                'adresa' => $adresa,
                'uputstvo_za_dostavu' => $uputstvo,
                'broj_telefona' => $brojTelefona,
                'postanski_broj' => $postanskiBroj,
            ];
        }

        foreach ($entries as $entry) {
            PaketKorisnika::create($entry);
        }
    }
}
