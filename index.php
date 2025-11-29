<?php


require_once 'Logika/Pokemon.php';
require_once 'Logika/NidoQueen.php';
require_once 'Logika/SessionManager.php';

SessionManager::init();

if (!SessionManager::pokemonAda()) {
    $nidoqueen = new PoisonGroundPokemon();
    SessionManager::simpanPokemon($nidoqueen);
} else {
    $dataPokemon = SessionManager::ambilPokemon();
    $nidoqueen = new PoisonGroundPokemon();
    $nidoqueen->setLevel($dataPokemon['level']);
    $nidoqueen->setHP($dataPokemon['hp']);
    $nidoqueen->setHPMaksimal($dataPokemon['hpMaksimal']);
}

$info = $nidoqueen->getInfoLengkap();
$karakteristik = $nidoqueen->karakteristik();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokéCare - Nidoqueen Training Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Flexo:wght@400;500;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8f9fa;
            color: #1a1a1a;
            line-height: 1.6;
        }
        
        .nav-header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #e63946;
            letter-spacing: -0.5px;
        }
        racun {
            position: relative;
            place-items: center;
        }
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #4b5563;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .nav-links a:hover {
            color: #e63946;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 3rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }
        
        .hero-text h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero-text p {
            font-size: 1.1rem;
            opacity: 0.95;
            margin-bottom: 1.5rem;
        }
        
        .pokemon-type {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }
        
        .hero-pokemon {
            text-align: center;
        }
        
        .pokemon-sprite {
            font-size: 180px;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
        }
        
        .stats-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .stat-card {
            background: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-color: #667eea;
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
        }
        
        .hp-bar {
            margin-top: 0.75rem;
        }
        
        .hp-bar-bg {
            background: #e5e7eb;
            height: 8px;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .hp-bar-fill {
            background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s;
        }
        
        .special-move-section {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
            border-radius: 16px;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .special-move-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .move-icon {
            font-size: 3rem;
            opacity: 0.9;
        }
        
        .move-text h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }
        
        .move-text p {
            opacity: 0.95;
            line-height: 1.6;
        }
        
        .characteristics-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .char-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .char-item {
            background: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
        }
        
        .char-item strong {
            color: #667eea;
            font-weight: 600;
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }
        
        .char-item span {
            color: #4b5563;
            font-size: 0.95rem;
        }
        
        .ability-note {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            color: #78350f;
        }
        
        .action-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .action-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }
        
        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-color: #667eea;
        }
        
        .action-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .action-card h3 {
            font-size: 1.3rem;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }
        
        .action-card p {
            color: #6b7280;
            font-size: 0.95rem;
        }
        
        .action-card.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        
        .action-card.primary h3,
        .action-card.primary p {
            color: white;
        }
        
        .footer {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
            font-size: 0.9rem;
        }
   
        @media (max-width: 768px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .hero-text h1 {
                font-size: 2rem;
            }
            
            .pokemon-sprite {
                font-size: 120px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .nav-links {
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="nav-header">
        <div class="nav-container">
            <div class="logo"> PokéCare</div>
            <div class="nav-links">
                <a href="index.php">Beranda</a>
                <a href="latihan.php">Latihan</a>
                <a href="riwayat.php">Riwayat</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1><?= $info['nama'] ?></h1>
                    <p>Pokémon Research & Training Center</p>
                    <div class="pokemon-type">
                        <img src ="RACUN1.png" class = "racun" alt="Tipe Racun" width="25" height="25">
                         <?= $info['tipe'] ?>
                    </div>
                </div>
                <div class="hero-pokemon">
                  <img src="image.png" 
                        alt="Nidoqueen" 
                        class="pokemon-sprite">
                </div>
            </div>
        </div>

        <div class="stats-section">
            <h2 class="section-title">Status Pokémon</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Level</div>
                    <div class="stat-value"><?= $info['level'] ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Hit Points (HP)</div>
                    <div class="stat-value"><?= $info['hp'] ?></div>
                    <div class="hp-bar">
                        <div class="hp-bar-bg">
                            <div class="hp-bar-fill" style="width: <?= ($info['hp'] / $info['hpMaksimal']) * 100 ?>%"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Max HP</div>
                    <div class="stat-value"><?= $info['hpMaksimal'] ?></div>
                </div>
            </div>
        </div>

        <div class="special-move-section">
            <div class="special-move-content">
                <div class="move-icon">⚡</div>
                <div class="move-text">
                    <h3>Jurus Spesial</h3>
                    <p><?= $info['jurusSpesial'] ?></p>
                </div>
            </div>
        </div>

        <div class="characteristics-section">
            <h2 class="section-title">Karakteristik Pokémon</h2>
            <div class="char-grid">
                <div class="char-item">
                    <strong>Tinggi</strong>
                    <span><?= $karakteristik['tinggi'] ?></span>
                </div>
                <div class="char-item">
                    <strong>Berat</strong>
                    <span><?= $karakteristik['berat'] ?></span>
                </div>
                <div class="char-item">
                    <strong>Kategori</strong>
                    <span><?= $karakteristik['kategori'] ?></span>
                </div>
                <div class="char-item">
                    <strong>Kemampuan</strong>
                    <span><?= $karakteristik['kemampuan'] ?></span>
                </div>
            </div>
            <div class="ability-note">
                <strong>💡 Informasi:</strong> <?= $nidoqueen->kemampuanKhusus() ?>
            </div>
        </div>

        <div class="action-section">
            <a href="latihan.php" class="action-card primary">
                <div class="action-icon">💪</div>
                <h3>Mulai Latihan</h3>
                <p>Tingkatkan kemampuan Nidoqueen dengan latihan intensif</p>
            </a>
            <a href="riwayat.php" class="action-card">
                <div class="action-icon">📜</div>
                <h3>Riwayat Latihan</h3>
                <p>Lihat catatan semua sesi latihan yang telah dilakukan</p>
            </a>
        </div>
    </div>

    <div class="footer">
        <p>Cihuyyyyyyyy.</p>
    </div>
</body>
</html>