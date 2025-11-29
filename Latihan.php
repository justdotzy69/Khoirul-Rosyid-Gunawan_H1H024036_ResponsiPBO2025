<?php

require_once 'Logika/Pokemon.php';
require_once 'Logika/NidoQueen.php';
require_once 'Logika/SessionManager.php';

SessionManager::init();

$dataPokemon = SessionManager::ambilPokemon();
if (!$dataPokemon) {
    header('Location: index.php');
    exit;
}

$nidoqueen = new PoisonGroundPokemon();
$nidoqueen->setLevel($dataPokemon['level']);
$nidoqueen->setHP($dataPokemon['hp']);
$nidoqueen->setHPMaksimal($dataPokemon['hpMaksimal']);

$hasilLatihan = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenisLatihan = $_POST['jenis_latihan'];
    $intensitas = (int)$_POST['intensitas'];
    $levelSebelum = $nidoqueen->getLevel();
    $hpSebelum = $nidoqueen->getHP();
    $nidoqueen->latihan($jenisLatihan, $intensitas);
    $levelSesudah = $nidoqueen->getLevel();
    $hpSesudah = $nidoqueen->getHP();
    SessionManager::simpanPokemon($nidoqueen);
    
    $riwayat = [
        'jenisLatihan' => $jenisLatihan,
        'intensitas' => $intensitas,
        'levelSebelum' => $levelSebelum,
        'levelSesudah' => $levelSesudah,
        'hpSebelum' => $hpSebelum,
        'hpSesudah' => $hpSesudah,
        'waktu' => date('d/m/Y H:i:s')
    ];
    SessionManager::tambahRiwayatLatihan($riwayat);

    $hasilLatihan = [
        'jenis' => $jenisLatihan,
        'intensitas' => $intensitas,
        'levelSebelum' => $levelSebelum,
        'levelSesudah' => $levelSesudah,
        'hpSebelum' => $hpSebelum,
        'hpSesudah' => $hpSesudah,
        'peningkatanLevel' => round($levelSesudah - $levelSebelum, 2),
        'peningkatanHP' => round($hpSesudah - $hpSebelum, 0),
        'jurusSpesial' => $nidoqueen->jurusSpesial()
    ];
}

$info = $nidoqueen->getInfoLengkap();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan Pokémon - PokéCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            text-decoration: none;
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
        
        .nav-links a.active {
            color: #667eea;
            font-weight: 600;
        }
        
        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .page-header {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .page-header h1 {
            font-size: 2rem;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }
        
        .page-header p {
            color: #6b7280;
            font-size: 1.05rem;
        }
        
        .status-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .status-item {
            text-align: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }
        
        .status-label {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        
        .status-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #667eea;
        }
        
        .success-alert {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .success-alert h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .result-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin: 1.5rem 0;
        }
        
        .result-item {
            background: rgba(255,255,255,0.15);
            padding: 1rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        
        .result-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }
        
        .result-value {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .improvement-badge {
            background: #fbbf24;
            color: #78350f;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            display: inline-block;
            font-weight: 600;
            margin-top: 1rem;
        }
        
        .special-move-display {
            background: rgba(255,255,255,0.15);
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 1rem;
            backdrop-filter: blur(10px);
        }
        
        .special-move-display h3 {
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }
        
        .training-form {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .training-form h2 {
            font-size: 1.5rem;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .form-select,
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.2s;
            background: white;
        }
        
        .form-select:focus,
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-help {
            background: #eff6ff;
            border-left: 3px solid #3b82f6;
            padding: 0.75rem 1rem;
            margin-top: 0.5rem;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #1e40af;
        }
        
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .nav-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .nav-btn {
            padding: 1rem;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            border: 2px solid #e5e7eb;
            background: white;
            color: #374151;
        }
        
        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: #667eea;
        }
        
        .footer {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .result-grid {
                grid-template-columns: 1fr;
            }
            
            .status-grid {
                grid-template-columns: repeat(2, 1fr);
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
            <a href="index.php" class="logo"> PokéCare</a>
            <div class="nav-links">
                <a href="index.php">Beranda</a>
                <a href="latihan.php" class="active">Latihan</a>
                <a href="riwayat.php">Riwayat</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1> Latihan Pokémon</h1>
            <p>Tingkatkan kemampuan <?= $info['nama'] ?> melalui latihan intensif</p>
        </div>

        <div class="status-card">
            <h2 style="font-size: 1.3rem; margin-bottom: 1rem; color: #1a1a1a;">Status Saat Ini</h2>
            <div class="status-grid">
                <div class="status-item">
                    <div class="status-label">Nama</div>
                    <div class="status-value" style="font-size: 1.3rem;"><?= $info['nama'] ?></div>
                </div>
                <div class="status-item">
                    <div class="status-label">Tipe</div>
                    <div class="status-value" style="font-size: 1.1rem;"><?= $info['tipe'] ?></div>
                </div>
                <div class="status-item">
                    <div class="status-label">Level</div>
                    <div class="status-value"><?= $info['level'] ?></div>
                </div>
                <div class="status-item">
                    <div class="status-label">HP</div>
                    <div class="status-value"><?= $info['hp'] ?></div>
                </div>
            </div>
        </div>

        <?php if ($hasilLatihan): ?>
        <div class="success-alert">
            <h2>🎉 Latihan Berhasil!</h2>
            <p style="font-size: 1.05rem; margin-bottom: 1rem;">
                <?= $info['nama'] ?> telah menyelesaikan latihan <strong><?= $hasilLatihan['jenis'] ?></strong> 
                dengan intensitas <strong><?= $hasilLatihan['intensitas'] ?></strong>
            </p>
            
            <div class="result-grid">
                <div class="result-item">
                    <div class="result-label">Level Sebelum</div>
                    <div class="result-value"><?= $hasilLatihan['levelSebelum'] ?></div>
                </div>
                <div class="result-item">
                    <div class="result-label">Level Sesudah</div>
                    <div class="result-value"><?= $hasilLatihan['levelSesudah'] ?></div>
                </div>
                <div class="result-item">
                    <div class="result-label">HP Sebelum</div>
                    <div class="result-value"><?= $hasilLatihan['hpSebelum'] ?></div>
                </div>
                <div class="result-item">
                    <div class="result-label">HP Sesudah</div>
                    <div class="result-value"><?= $hasilLatihan['hpSesudah'] ?></div>
                </div>
            </div>
            
            <div class="improvement-badge">
                 Peningkatan: Level +<?= $hasilLatihan['peningkatanLevel'] ?> | HP +<?= $hasilLatihan['peningkatanHP'] ?>
            </div>
            
            <div class="special-move-display">
                <h3>⚡ Jurus Spesial</h3>
                <p><?= $hasilLatihan['jurusSpesial'] ?></p>
            </div>
        </div>
        <?php endif; ?>

        <div class="training-form">
            <h2>Pilih Jenis Latihan</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label" for="jenis_latihan">Jenis Latihan</label>
                    <select name="jenis_latihan" id="jenis_latihan" class="form-select" required>
                        <option value="">-- Pilih Jenis Latihan --</option>
                        <option value="Serangan">⚔️ Serangan (Bonus 40% untuk Nidoqueen)</option>
                        <option value="Pertahanan">🛡️ Pertahanan (Bonus 50% untuk Nidoqueen)</option>
                        <option value="Kecepatan">⚡ Kecepatan</option>
                    </select>
                    <div class="form-help">
                        💡 Nidoqueen mendapat bonus lebih besar untuk latihan Pertahanan dan Serangan
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="intensitas">Intensitas Latihan (1-100)</label>
                    <input 
                        type="number" 
                        name="intensitas" 
                        id="intensitas" 
                        class="form-input"
                        min="1" 
                        max="100" 
                        placeholder="Contoh: 50"
                        required
                    >
                    <div class="form-help">
                        💡 Semakin tinggi intensitas, semakin besar peningkatan Level dan HP
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">
                     Mulai Latihan Sekarang
                </button>
            </form>
        </div>
        <div class="nav-buttons">
            <a href="index.php" class="nav-btn">Kembali ke Beranda</a>
            <a href="riwayat.php" class="nav-btn">Lihat Riwayat Latihan</a>
        </div>
    </div>

    <div class="footer">
        <p>Tor Monitor</p>
    </div>
</body>
</html>