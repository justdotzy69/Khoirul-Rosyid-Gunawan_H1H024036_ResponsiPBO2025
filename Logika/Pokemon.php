<?php

abstract class Pokemon {
    protected $nama;
    protected $tipe;
    protected $level;
    protected $hp;
    protected $hpMaksimal;

    public function __construct($nama, $tipe, $levelAwal = 5, $hpAwal = 100) {
        $this->nama = $nama;
        $this->tipe = $tipe;
        $this->level = $levelAwal;
        $this->hp = $hpAwal;
        $this->hpMaksimal = $hpAwal;
    }
    
    abstract public function jurusSpesial();
    
    abstract protected function bonusTipeLatihan($jenisLatihan);
    
    public function latihan($jenisLatihan, $intensitas) {
        // Dapatkan bonus berdasarkan tipe Pokémon
        $bonus = $this->bonusTipeLatihan($jenisLatihan);
        
        // Hitung peningkatan dengan bonus
        $peningkatanLevel = ($intensitas / 10) * $bonus;
        $peningkatanHP = ($intensitas * 3) * $bonus;
        
        // Tambahkan level dan HP
        $this->level += $peningkatanLevel;
        $this->hp += $peningkatanHP;
        $this->hpMaksimal += $peningkatanHP;
        
        $this->level = round($this->level, 2);
        $this->hp = round($this->hp);
        $this->hpMaksimal = round($this->hpMaksimal);
    }
    
    public function getNama() {
        return $this->nama;
    }
    
    public function getTipe() {
        return $this->tipe;
    }
    
    public function getLevel() {
        return $this->level;
    }
    
    public function getHP() {
        return $this->hp;
    }
    
    public function getHPMaksimal() {
        return $this->hpMaksimal;
    }
    

    public function setLevel($level) {
        $this->level = $level;
    }
    
    public function setHP($hp) {
        $this->hp = $hp;
    }
    
    public function setHPMaksimal($hpMaks) {
        $this->hpMaksimal = $hpMaks;
    }
    
    public function getInfoLengkap() {
        return [
            'nama' => $this->nama,
            'tipe' => $this->tipe,
            'level' => $this->level,
            'hp' => $this->hp,
            'hpMaksimal' => $this->hpMaksimal,
            'jurusSpesial' => $this->jurusSpesial()
        ];
    }
}
?>