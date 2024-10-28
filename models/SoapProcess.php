<?php
// /controllers/SoapProcess.php

require_once __DIR__ . '/../models/SoapServerModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rateType = $_POST['rateType'];
    $soapModel = new SoapServerModel();

    try {
        if ($rateType === 'daily') {
            $selectedDate = $_POST['selected-date'];
            $baseCurrency = $_POST['base-currency'];
            $targetCurrency = $_POST['target-currency'];
        
            // SOAP lekérdezés futtatása a megadott dátummal
            $result = $soapModel->getExchangeRateByCurrencyPair($baseCurrency, $targetCurrency, $selectedDate);
        
            // Ellenőrizzük, hogy az eredmény nem üres vagy null
            if ($result !== null && $result !== '' && !str_contains($result, 'Nincs elérhető adat')) {
                echo "<div class='rate-result'>Az árfolyam $selectedDate napon: $result HUF / EUR</div>";
            } else {
                // Ha hibaüzenet van, akkor azt írjuk ki
                echo "<div class='rate-result'>" . htmlspecialchars($result) . "</div>";
            }
        } elseif ($rateType === 'monthly') {
            $selectedMonth = $_POST['selected-month'];
            $baseCurrency = $_POST['base-currency'];
            $targetCurrency = $_POST['target-currency'];
        
            // Év és hónap kinyerése a selected-month értékből
            list($year, $month) = explode('-', $selectedMonth);
        
            // SOAP lekérdezés futtatása a megadott évvel és hónappal
            $result = $soapModel->getMonthlyExchangeRates($baseCurrency, $targetCurrency, $year, (int)$month);
        
            // Tisztítjuk a visszakapott HTML-t
            $trimmedResult = trim($result);
        
            // Ellenőrizzük, hogy az eredmény nem csak egy üres táblázat-e
            if ($trimmedResult !== null && $trimmedResult !== '' && !str_contains($trimmedResult, '<table border="1"><tr><th>Date</th><th>Exchange Rate</th></tr></table>')) {
                // Cseréljük le a fejléceket a magyar megfelelőjükre
                $modifiedResult = str_replace(
                    ['Date', 'Exchange Rate'], 
                    ['Dátum', 'Árfolyam (HUF / EUR)'], 
                    $result
                );
                echo "<div class='rate-result'>" . $modifiedResult . "</div>";

                // JSON formátumban is visszaadjuk az adatokat a grafikonhoz
                $data = []; // Ide jön a tömb, ami tartalmazza a dátumokat és árfolyamokat
                $dom = new DOMDocument();
                @$dom->loadHTML($result);
                $rows = $dom->getElementsByTagName('tr');

                foreach ($rows as $index => $row) {
                    if ($index === 0) continue; // Kihagyjuk a fejléc sort
                    $columns = $row->getElementsByTagName('td');
                    $date = $columns->item(0)->textContent;
                    $rate = $columns->item(1)->textContent;
                    $data[] = [
                        'date' => $date,
                        'rate' => (float) $rate,
                    ];
                }
            } else {
                echo "<div class='rate-result'>Nincs elérhető adat erre a hónapra.</div>";
            }
        }
        
    } catch (Exception $e) {
        echo "<p>Hiba történt: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Hibás kérés.</p>";
}
