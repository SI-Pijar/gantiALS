<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Penumpang - PT. Antar Lintas Sumatera</title>
    <link rel="stylesheet" href="../penumpang/penumpang.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <nav class="BatangNavigasiUtama">
        <div class="WadahPembatasLebarKonten">
            <div class="ElemenLogoPerusahaan">
                <img src="../penumpang/gambar/logo als.jpg" alt="Logo ALS" width="58" height="58" />
                <div class="WadahTeksLogo">
                    <h1>ALS</h1>
                    <p>Bekerjasama Dan Sama-Sama Bekerja</p>
                </div>
            </div>
            <div class="DaftarMenuNavigasi">
                <a href="#" class="MenuSaatIni">Daftar Penumpang</a>
            </div>
        </div>
    </nav>

    <main class="WadahPembatasLebarKonten" style="margin-top: 50px;">
        <div class="KartuKontenBesar">
            <h2 style="margin-bottom: 20px;"><i class="fa-solid fa-users"></i> Data Penumpang Terdaftar</h2>
            
            <table class="TabelData" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8fafc; text-align: left;">
                        <th style="padding: 12px; border-bottom: 1px solid #e2e8f0;">ID</th>
                        <th style="padding: 12px; border-bottom: 1px solid #e2e8f0;">Nama</th>
                        <th style="padding: 12px; border-bottom: 1px solid #e2e8f0;">Email</th>
                        <th style="padding: 12px; border-bottom: 1px solid #e2e8f0;">Tanggal Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $users->fetch(PDO::FETCH_ASSOC)) : ?>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><?php echo htmlspecialchars($row['id']); ?></td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>