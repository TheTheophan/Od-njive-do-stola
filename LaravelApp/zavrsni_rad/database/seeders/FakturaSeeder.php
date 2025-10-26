<?php

namespace Database\Seeders;

use App\Models\Faktura;
use Illuminate\Database\Seeder;

class FakturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipPaketaPrices = [
            1 => ['mesecna' => 3500, 'godisnja' => 37000],
            2 => ['mesecna' => 2500, 'godisnja' => 26500],
            3 => ['mesecna' => 6000, 'godisnja' => 65000],
            4 => ['mesecna' => 1800, 'godisnja' => 19000],
            5 => ['mesecna' => 1200, 'godisnja' => 12500],
            6 => ['mesecna' => 9000, 'godisnja' => 98000],
        ];

        $paketi = \App\Models\PaketKorisnika::all();
        $count = 0;
        // cena zavisi od pretplate i označava prvih 20 faktura kao placene
        foreach ($paketi as $paket) {
            if ($count >= 40) break;
            $tipId = $paket->tip_paketa_id;
            $godisnja = $paket->godisnja_pretplata;
            $cena = $godisnja ? $tipPaketaPrices[$tipId]['godisnja'] : $tipPaketaPrices[$tipId]['mesecna'];
            Faktura::create([
                'paket_korisnika_id' => $paket->id,
                'cena' => $cena,
                'tekst' => '',
                'placeno' => $count < 20 ? true : false,

            ]);
            $count++;
        }
    }
}
