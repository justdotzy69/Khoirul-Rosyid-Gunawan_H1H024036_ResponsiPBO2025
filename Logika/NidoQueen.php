<?php
require_once 'Pokemon.php';

class PoisonGroundPokemon extends Pokemon {
    
    public function __construct() {
        parent::__construct("Nidoqueen", "Racun/Tanah", 1, 90);
    }
    
    public function jurusSpesial() {
        return "Gempa Racun (Earthquake + Poison Jab) - Nidoqueen menghantam tanah dengan kekuatan racun yang mematikan, menciptakan gempa beracun yang merusak area luas!";
    }
    
    protected function bonusTipeLatihan($jenisLatihan) {
        
        switch($jenisLatihan) {
            case 'Serangan':
                return 1.4; 
            case 'Pertahanan':
                return 1.5; 
            case 'Kecepatan':
                return 1.0; 
            default:
                return 1.0;
        }
    }
    

    public function kemampuanKhusus() {
        return "Tubuh Nidoqueen dilindungi oleh sisik yang sangat keras. Ia mahir menghantam lawannya dengan terjangan yang kuat. Pokémon ini menunjukkan kemampuan terbaiknya ketika melindungi anak-anaknya.";
    }
    
    public function karakteristik() {
        return [
            'tinggi' => '1.3 m',
            'berat' => '60.0 kg',
            'kategori' => 'Pokémon Bor',
            'kemampuan' => 'Poison Point / Rivalry',
            'kelemahan' => 'Psikis, Air, Tanah, Es',
            'kekuatan' => 'Serangan fisik tinggi, Pertahanan solid'
        ];
    }
}
?>