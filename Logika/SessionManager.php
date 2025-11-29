<?php

class SessionManager {
    
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function simpanPokemon($pokemon) {
        self::init();
        $_SESSION['pokemon'] = [
            'nama' => $pokemon->getNama(),
            'tipe' => $pokemon->getTipe(),
            'level' => $pokemon->getLevel(),
            'hp' => $pokemon->getHP(),
            'hpMaksimal' => $pokemon->getHPMaksimal()
        ];
    }
    
    public static function ambilPokemon() {
        self::init();
        return isset($_SESSION['pokemon']) ? $_SESSION['pokemon'] : null;
    }
    

    public static function tambahRiwayatLatihan($data) {
        self::init();
        if (!isset($_SESSION['riwayat_latihan'])) {
            $_SESSION['riwayat_latihan'] = [];
        }
        
        $_SESSION['riwayat_latihan'][] = $data;
    }
    
    public static function ambilRiwayatLatihan() {
        self::init();
        return isset($_SESSION['riwayat_latihan']) ? $_SESSION['riwayat_latihan'] : [];
    }

    public static function resetData() {
        self::init();
        session_destroy();
    }
    
    public static function pokemonAda() {
        self::init();
        return isset($_SESSION['pokemon']);
    }
}
?>