<?php

require_once 'Logika/SessionManager.php';

SessionManager::init();

$riwayatLatihan = SessionManager::ambilRiwayatLatihan();

$dataPokemon = SessionManager::ambilPokemon();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Latihan - PokéCare</title>
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
            max-width: 1200px;
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
        
        .summary-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .summary-card h2 {
            font-size: 1.3rem;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }
        
        .summary-item {
            background: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
        }
        
        .summary-label {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        
        .summary-value {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
        }

        .empty-state {
            background: white;
            border-radius: 16px;
            padding: 4rem 2rem;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .empty-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }
        
        .empty-state p {
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 1.05rem;
        }
        
        .empty-btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .empty-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }
        
        .history-section {
            margin-bottom: 2rem;
        }
        
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .history-header h2 {
            font-size: 1.5rem;
            color: #1a1a1a;
        }
        
        .session-count {
            background: #667eea;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .history-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s;
        }
        
        .history-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transform: translateX(4px);
        }
        
        .history-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .session-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .session-date {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .improvement-tag {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-left: 1rem;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }
        
        .detail-box {
            background: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
        }
        
        .detail-label {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }
        
        .detail-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .value-change {
            color: #667eea;
            font-weight: 700;
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
            .history-header-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .improvement-tag {
                margin-left: 0;
                margin-top: 0.5rem;
            }
            
            .details-grid {
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
            <a href="index.php" class="logo">PokéCare</a>
            <div class="nav-links">
                <a href="index.php">Beranda</a>
                <a href="latihan.php">Latihan</a>
                <a href="riwayat.php" class="active">Riwayat</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1>📜 Riwayat Latihan</h1>
            <p>Catatan lengkap semua sesi latihan yang telah dilakukan</p>
        </div>

        <?php if ($dataPokemon): ?>
        <div class="summary-card">
            <h2>Status Pokémon Terkini</h2>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-label">Nama Pokémon</div>
                    <div class="summary-value" style="font-size: 1.5rem;"><?= $dataPokemon['nama'] ?></div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Level</div>
                    <div class="summary-value"><?= $dataPokemon['level'] ?></div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">HP</div>
                    <div class="summary-value"><?= $dataPokemon['hp'] ?></div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Total Latihan</div>
                    <div class="summary-value"><?= count($riwayatLatihan) ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (empty($riwayatLatihan)): ?>
            <div class="empty-state">
                <div class="empty-icon">📝</div>
                <h3>Belum Ada Riwayat Latihan</h3>
                <p>Nidoqueen belum pernah melakukan latihan. Mulai latihan pertamamu sekarang!</p>
                <a href="latihan.php" class="empty-btn">💪 Mulai Latihan</a>
            </div>
        <?php else: ?>
            <div class="history-section">
                <div class="history-header">
                    <h2>Daftar Riwayat Latihan</h2>
                    <span class="session-count"><?= count($riwayatLatihan) ?> Sesi</span>
                </div>

                <?php 
                $riwayatTerbalik = array_reverse($riwayatLatihan);
                $nomorSesi = count($riwayatLatihan);
                
                foreach ($riwayatTerbalik as $riwayat): 
                    $peningkatanLevel = round($riwayat['levelSesudah'] - $riwayat['levelSebelum'], 2);
                    $peningkatanHP = round($riwayat['hpSesudah'] - $riwayat['hpSebelum'], 0);
                ?>
                <div class="history-card">
                    <div class="history-header-row">
                        <div>
                            <span class="session-title">Sesi #<?= $nomorSesi ?> - <?= $riwayat['jenisLatihan'] ?></span>
                            <span class="improvement-tag"> +<?= $peningkatanLevel ?> Level | +<?= $peningkatanHP ?> HP</span>
                        </div>
                        <div class="session-date">
                            🕐 <?= $riwayat['waktu'] ?>
                        </div>
                    </div>
                    
                    <div class="details-grid">
                        <div class="detail-box">
                            <div class="detail-label">Jenis Latihan</div>
                            <div class="detail-value"><?= $riwayat['jenisLatihan'] ?></div>
                        </div>
                        <div class="detail-box">
                            <div class="detail-label">Intensitas</div>
                            <div class="detail-value"><?= $riwayat['intensitas'] ?></div>
                        </div>
                        <div class="detail-box">
                            <div class="detail-label">Level</div>
                            <div class="detail-value">
                                <?= $riwayat['levelSebelum'] ?> 
                                <span class="value-change">→ <?= $riwayat['levelSesudah'] ?></span>
                            </div>
                        </div>
                        <div class="detail-box">
                            <div class="detail-label">HP</div>
                            <div class="detail-value">
                                <?= $riwayat['hpSebelum'] ?> 
                                <span class="value-change">→ <?= $riwayat['hpSesudah'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    $nomorSesi--;
                endforeach; 
                ?>
            </div>
        <?php endif; ?>

        <div class="nav-buttons">
            <a href="index.php" class="nav-btn">Kembali ke Beranda</a>
            <a href="latihan.php" class="nav-btn">Latihan</a>
        </div>
    </div>

    <div class="footer">
        <p>&copy;JustDotzy69.</p>
    </div>
</body>
</html>