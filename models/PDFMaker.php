<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Composer autoload betöltése
require_once __DIR__ . '/DatabaseModel.php'; // DatabaseModel osztály betöltése

// Inicializáljuk az adatbázis kapcsolatot
$db = new DatabaseModel();

// Felhasználói űrlap adatainak lekérése
$ev = $_POST['ev'];
$het = $_POST['het'];

// Adatok lekérdezése az adatbázisból
$huzasData = $db->select("huzas", "*", "ev = ? AND het = ?", "", [$ev, $het]);
$huzottData = $db->select("huzott", "*", "huzasid = ?", "", [$huzasData[0]['id']]);
$nyeremenyData = $db->select("nyeremeny", "*", "huzasid = ?", "", [$huzasData[0]['id']]);

// PDF dokumentum létrehozása TCPDF-fel
$pdf = new TCPDF();
$pdf->AddPage();

// Betűtípus beállítása Times New Roman-ra
$pdf->SetFont('times', '', 12);

// PDF metaadatok beállítása
$pdf->SetTitle('Lottó adatok PDF');

// Cím hozzáadása (nagyobb, félkövér, középen igazítva)
$pdf->SetFont('times', 'B', 16); // Félkövér és nagyobb betűméret
$pdf->Cell(0, 10, "Lottó sorsolás részletes adatai", 0, 1, 'C');
$pdf->Ln(10);

// 'huzas' tábla adatainak megjelenítése
$pdf->SetFont('times', 'B', 12); // Félkövér betűtípus
$pdf->Write(0, "Sorsolás Éve: ");
$pdf->SetFont('times', '', 12); // Normál betűtípus az értékhez
$pdf->Write(0, $huzasData[0]['ev']);
$pdf->Ln();

$pdf->SetFont('times', 'B', 12); // Félkövér betűtípus
$pdf->Write(0, "Sorsolás Hete: ");
$pdf->SetFont('times', '', 12); // Normál betűtípus az értékhez
$pdf->Write(0, $huzasData[0]['het']);
$pdf->Ln(10);

// 'huzott' tábla adatainak megjelenítése egymás mellett
$pdf->SetFont('times', 'B', 12);
$pdf->Write(0, "Húzott Számok:");
$pdf->Ln();
$pdf->SetFont('times', '', 12);

$szamok = [];
foreach ($huzottData as $huzott) {
    $szamok[] = $huzott['szam'];
}
$pdf->Write(0, implode(", ", $szamok)); // Számok egymás mellett, vesszővel elválasztva
$pdf->Ln(10);

// 'nyeremeny' tábla adatainak megjelenítése
$pdf->SetFont('times', 'B', 14);
$pdf->Cell(0, 10, "Nyeremény Részletei", 0, 1, 'C');
$pdf->Ln();

// Adatok növekvő sorrendbe rendezése a 'talalat' alapján
usort($nyeremenyData, function ($a, $b) {
    return $a['talalat'] - $b['talalat'];
});

if (empty($nyeremenyData)) {
    $pdf->SetFont('times', '', 12);
    $pdf->Cell(0, 10, "Nem volt találat az adott héten.", 0, 1, 'L');
} else {
    foreach ($nyeremenyData as $nyeremeny) {
        $pdf->SetFont('times', 'IU', 12);
        $talalatSzoveg = $nyeremeny['talalat'] == 7 ? "5+1 találat" : $nyeremeny['talalat'] . " találat";
        
        $pdf->Cell(0, 10, $talalatSzoveg, 0, 1, 'L');

        $pdf->SetFont('times', 'I', 12);
        $pdf->Cell(30, 10, "Darab:", 0, 0, 'L');
        $pdf->SetFont('times', '', 12);
        $pdf->Cell(0, 10, $nyeremeny['darab'], 0, 1, 'L');

        $pdf->SetFont('times', 'I', 12);
        $pdf->Cell(30, 10, "Érték:", 0, 0, 'L');
        $pdf->SetFont('times', '', 12);
        $ertek = number_format($nyeremeny['ertek'], 0, '', '.'); // Ezres tagolás, HUF
        $pdf->Cell(0, 10, $ertek . " HUF", 0, 1, 'L');

        $pdf->Ln();
    }
}

// PDF fájl letöltés
$pdfFileName = "Lotto_Adatok_{$ev}_{$het}.pdf";
$pdf->Output($pdfFileName, 'D');
?>
