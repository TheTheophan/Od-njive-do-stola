<?php

namespace Database\Seeders;

use App\Models\TipPaketa;
use Illuminate\Database\Seeder;

class TipPaketaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packets = [
            [
                'naziv' => 'Porodična Gajba',
                'cena_mesecne_pretplate' => 3500,
                'cena_godisnje_pretplate' => 37000,
                'opis' => 'Savršena za četvoročlanu porodicu! Sadrži 15kg svežeg voća i povrća iz domaće proizvodnje svakog meseca. U gajbi se nalaze sezonske jabuke, kruške, šljive, paradajz, krastavac, paprika, krompir, šargarepa, luk i salata. Idealno za zdrave obroke i užinu za celu porodicu.',
            ],
            [
                'naziv' => 'Fit Paket',
                'cena_mesecne_pretplate' => 2500,
                'cena_godisnje_pretplate' => 26500,
                'opis' => 'Za aktivne pojedince! Sadrži 8kg voća i povrća sa naglaskom na niskokalorične i nutritivno bogate namirnice: brokoli, tikvica, spanać, avokado, borovnica, jabuka, limun, celer, šargarepa. Prilagođeno za pripremu zdravih smutija i obroka.',
            ],
            [
                'naziv' => 'Premium Gajba',
                'cena_mesecne_pretplate' => 6000,
                'cena_godisnje_pretplate' => 65000,
                'opis' => 'Ekskluzivni izbor za gurmane! 20kg pažljivo biranog voća i povrća, uključujući egzotične i domaće sorte: mango, nar, grožđe, breskva, tikva, batat, rukola, cherry paradajz, crveni luk, rotkvica. U gajbi se nalaze i organski proizvodi sa sertifikatom.',
            ],
            [
                'naziv' => 'Studentski Paket',
                'cena_mesecne_pretplate' => 1800,
                'cena_godisnje_pretplate' => 19000,
                'opis' => 'Pristupačno rešenje za studente! 6kg voća i povrća, jednostavno za pripremu: jabuka, banana, krompir, paradajz, šargarepa, luk, paprika. Dovoljno za nedeljne obroke i užinu tokom ispita.',
            ],
            [
                'naziv' => 'Mini Gajba',
                'cena_mesecne_pretplate' => 1200,
                'cena_godisnje_pretplate' => 12500,
                'opis' => 'Za pojedince ili parove! 4kg sezonskog voća i povrća: jabuka, kruška, paradajz, krastavac, šargarepa, salata. Idealno za one koji žele da probaju domaće proizvode bez obaveze.',
            ],
            [
                'naziv' => 'Zlatna Gajba',
                'cena_mesecne_pretplate' => 9000,
                'cena_godisnje_pretplate' => 98000,
                'opis' => 'Najbolje od najboljeg! 25kg voća i povrća, uključujući retke i luksuzne sorte: smokva, borovnica, malina, avokado, špargla, artičoka, organska paprika, domaći paradajz, batat, rukola. U gajbi se nalaze i specijalni pokloni iznenađenja svakog meseca.',
            ],
        ];

        foreach ($packets as $packet) {
            TipPaketa::create($packet);
        }
    }
}
