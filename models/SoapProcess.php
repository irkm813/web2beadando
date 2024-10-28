<?php
require_once __DIR__ . '/../models/SoapServerModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rateType = $_POST['rateType'];
    $soapModel = new SoapServerModel();

    try {
        header('Content-Type: application/json');
        $response = ['html' => '', 'chartData' => []];

        if ($rateType === 'daily') {
            $selectedDate = $_POST['selected-date'];
            $baseCurrency = $_POST['base-currency'];
            $targetCurrency = $_POST['target-currency'];
        
            $result = $soapModel->getExchangeRateByCurrencyPair($baseCurrency, $targetCurrency, $selectedDate);
        
            if ($result !== null && $result !== '' && !str_contains($result, 'Nincs elérhető adat')) {
                $response['html'] = "<div class='rate-result'>Az árfolyam $selectedDate napon: $result HUF / EUR</div>";
            } else {
                $response['html'] = "<div class='rate-result'>" . htmlspecialchars($result) . "</div>";
            }
        } elseif ($rateType === 'monthly') {
            $selectedMonth = $_POST['selected-month'];
            $baseCurrency = $_POST['base-currency'];
            $targetCurrency = $_POST['target-currency'];
            list($year, $month) = explode('-', $selectedMonth);
        
            $result = $soapModel->getMonthlyExchangeRates($baseCurrency, $targetCurrency, $year, (int)$month);
            $trimmedResult = trim($result);
        
            if ($trimmedResult !== null && $trimmedResult !== '' && !str_contains($trimmedResult, '<table border="1"><tr><th>Date</th><th>Exchange Rate</th></tr></table>')) {
                $modifiedResult = str_replace(
                    ['Date', 'Exchange Rate'], 
                    ['Dátum', 'Árfolyam (HUF / EUR)'], 
                    $trimmedResult
                );
                $response['html'] = "<div class='rate-result'>" . $modifiedResult . "</div>";

                $dom = new DOMDocument();
                @$dom->loadHTML($trimmedResult);
                $rows = $dom->getElementsByTagName('tr');
                foreach ($rows as $index => $row) {
                    if ($index === 0) continue;
                    $columns = $row->getElementsByTagName('td');
                    $date = $columns->item(0)->textContent;
                    $rate = $columns->item(1)->textContent;
                    $response['chartData'][] = [
                        'date' => $date,
                        'rate' => (float) $rate,
                    ];
                }
            } else {
                $response['html'] = "<div class='rate-result'>Nincs elérhető adat erre a hónapra.</div>";
            }
        }
        
        echo json_encode($response);
        exit;
    } catch (Exception $e) {
        echo json_encode(['error' => "Hiba történt: " . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['error' => "Hibás kérés."]);
    exit;
}
?>
