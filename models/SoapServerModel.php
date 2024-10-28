<?php
// /models/SoapServerModel.php - SOAP szerver

require_once __DIR__ . '/DatabaseModel.php';

class SoapServerModel {
    private $db;
    private $credentials;
    private $username;
    private $password;
    private $role ;
    private $MNBClient;

    //Konstruktor. Inicializálja a username, password és role változókat az autentikációhoz, valamint a DataBaseModel osztályt példányosítja
    public function __construct() {
        $this->db = new DatabaseModel();
        $this->credentials = $this->SoapAuth();
        $this->username = $this->credentials[0];
        $this->password = $this->credentials[1];
        $this->role = $this->credentials[2];
        try {
            $this->MNBClient = new SoapClient("https://www.mnb.hu/arfolyamok.asmx?WSDL");
        } catch (Exception $e) {
            echo 'SOAP Kliens inicializálási hiba: ' . $e->getMessage();
            $this->MNBClient = null; // Állítsd be null-ra, ha nem sikerül az inicializálás
        }
    }

    // Összes adat lekérése
    public function getAllItems($table) {
        try {
            
            //a dbAuth() metódussal ellenőrzi, hogy a BasicAuth-al beküldött felhasználónév/jelszó létezik-e az adatbázisban.
            if (!$this->db->dbAuth($this->username, $this->password)) {
                throw new Exception('Hibás felhasználónév vagy jelszó');
            }
            
            //Sikeres autentikáció után kilistázza és visszaadja az összes táblát a database model select osztályával
            return $this->db->select($table, '*');
            
        }
        catch (Exception $e) {
            return "Hibás felhasználónév vagy jelszó!";
        }       
    }

    // Egy sor lekérése ID alapján
    public function getDataById($table, $id) {
        try {
            
            //a dbAuth() metódussal ellenőrzi, hogy a BasicAuth-al beküldött felhasználónév/jelszó létezik-e az adatbázisban.
            if (!$this->db->dbAuth($this->username, $this->password)) {
                throw new Exception('Hibás felhasználónév vagy jelszó');
            }
            //Sikeres autentikáció után kiírja annak a rekordnak az adatait, aminek megadtuk az id-jét
            return $this->db->select($table, '*', 'id = ?', '', [$id]);
            
        }
        catch (Exception $e) {
            return "$this->username és $password Hibás felhasználónév vagy jelszó!";
        }          
    }

    // Új elem hozzáadása
    public function addRecord() {

        return "not implemented yet";


    }

    // Rekord frissítése
    public function updateRecord() {
        return "not implemented yet";
    }

    //Rekord törlése
    public function deleteRecord() {
        return "not implemented yet";
    }

    private function SoapAuth(){
        if (isset($_SERVER['PHP_AUTH_USER']) && isset ($_SERVER['PHP_AUTH_PW'])){
            $username=$_SERVER['PHP_AUTH_USER'];
            $password=$_SERVER['PHP_AUTH_PW'];
            $db_role =  $this->db->select('users', 'role', "username=?",'',[$username]);
            $role =  $db_role[0]["role"];
        }
        else{
            $username=null;
            $password=null;
            $role=null;
        }
        return [$username,$password,$role];
    }

    //Egy adott devizapár lekérdezése egy adott napra
    public function getExchangeRateByCurrencyPair($baseCurrency, $targetCurrency, $date) {
        try {
            //if (!$this->db->dbAuth($this->username, $this->password)) {
            //    throw new Exception('Hibás felhasználónév vagy jelszó');
            //}
            
            if (!$this->MNBClient) {
                throw new Exception('Nem sikerült csatlakozni az MNB SOAP API-hoz.');
            }
    
            // Ha a baseCurrency HUF, akkor fordítjuk a targetCurrency árfolyamát
            if ($baseCurrency === 'HUF') {
                $paramsTarget = [
                    'startDate' => $date,
                    'endDate' => $date,
                    'currencyNames' => $targetCurrency
                ];
    
                // Lekérdezzük a targetCurrency árfolyamát HUF-hoz viszonyítva
                $resultTarget = $this->MNBClient->__soapCall('GetExchangeRates', [$paramsTarget]);
                $xmlTarget = simplexml_load_string($resultTarget->GetExchangeRatesResult);
                $rateTarget = isset($xmlTarget->Day->Rate) ? (float)$xmlTarget->Day->Rate : null;
    
                if ($rateTarget === null) {
                    throw new Exception('Nincs elérhető adat erre a napra és devizapárra.');
                }
    
                // 1 HUF mennyi targetCurrency (pl. EUR)
                $exchangeRate = 1 / $rateTarget;
    
            } elseif ($targetCurrency === 'HUF') {
                $paramsBase = [
                    'startDate' => $date,
                    'endDate' => $date,
                    'currencyNames' => $baseCurrency
                ];
    
                // Lekérdezzük a baseCurrency árfolyamát HUF-hoz viszonyítva
                $resultBase = $this->MNBClient->__soapCall('GetExchangeRates', [$paramsBase]);
                $xmlBase = simplexml_load_string($resultBase->GetExchangeRatesResult);
                $rateBase = isset($xmlBase->Day->Rate) ? (float)$xmlBase->Day->Rate : null;
    
                // Ellenőrizzük, hogy volt-e adat
                if ($rateBase === null) {
                    throw new Exception('Nincs elérhető adat erre a napra és devizapárra.');
                }
    
                // 1 baseCurrency (pl. EUR) mennyi HUF
                $exchangeRate = $rateBase;
    
            } else {
                // Ha egyik sem HUF, akkor mindkét árfolyamot lekérdezzük HUF-hoz viszonyítva
                $paramsBase = [
                    'startDate' => $date,
                    'endDate' => $date,
                    'currencyNames' => $baseCurrency
                ];
    
                $paramsTarget = [
                    'startDate' => $date,
                    'endDate' => $date,
                    'currencyNames' => $targetCurrency
                ];
    
                // Lekérdezzük mindkét árfolyamot
                $resultBase = $this->MNBClient->__soapCall('GetExchangeRates', [$paramsBase]);
                $xmlBase = simplexml_load_string($resultBase->GetExchangeRatesResult);
                $rateBase = isset($xmlBase->Day->Rate) ? (float)$xmlBase->Day->Rate : null;
    
                $resultTarget = $this->MNBClient->__soapCall('GetExchangeRates', [$paramsTarget]);
                $xmlTarget = simplexml_load_string($resultTarget->GetExchangeRatesResult);
                $rateTarget = isset($xmlTarget->Day->Rate) ? (float)$xmlTarget->Day->Rate : null;
    
                // Ellenőrizzük, hogy mindkét árfolyam elérhető-e
                if ($rateBase === null || $rateTarget === null) {
                    throw new Exception('Nincs elérhető adat erre a napra és devizapárra.');
                }
    
                // Az árfolyam számítása: baseCurrency értéke targetCurrency-hez viszonyítva
                $exchangeRate = $rateBase / $rateTarget;
            }
    
            // Eredmény visszaadása
            return number_format($exchangeRate, 4);
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    //Egy adott devizapár lekérdezése egy adott hónapra
    public function getMonthlyExchangeRates($baseCurrency, $targetCurrency, $year, $month) {
        try {
            //if (!$this->db->dbAuth($this->username, $this->password)) {
            //    throw new Exception('Hibás felhasználónév vagy jelszó');
            //}
            
            if (!$this->MNBClient) {
                throw new Exception('Nem sikerült csatlakozni az MNB SOAP API-hoz.');
            }
    
            // A hónap első és utolsó napjának meghatározása
            $startDate = "$year-$month-01";
            $endDate = date("Y-m-t", strtotime($startDate));
    
            // Lekérdezzük az árfolyamokat a baseCurrency és targetCurrency alapján
            $rates = [];
    
            if ($baseCurrency === 'HUF') {
                // Target árfolyam lekérdezése
                $paramsTarget = [
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'currencyNames' => $targetCurrency
                ];
    
                $resultTarget = $this->MNBClient->__soapCall('GetExchangeRates', [$paramsTarget]);
                $xmlTarget = simplexml_load_string($resultTarget->GetExchangeRatesResult);
                if ($xmlTarget === false) {
                    throw new Exception('A válasz XML nem feldolgozható.');
                }
    
                foreach ($xmlTarget->Day as $day) {
                    $date = (string)$day['date'];
                    $rate = (float)$day->Rate;
                    $exchangeRate = 1 / $rate; // 1 HUF a targetCurrency-hez képest
                    $rates[] = ['date' => $date, 'rate' => number_format($exchangeRate, 4)];
                }
    
            } elseif ($targetCurrency === 'HUF') {
                // Base árfolyam lekérdezése
                $paramsBase = [
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'currencyNames' => $baseCurrency
                ];
    
                $resultBase = $this->MNBClient->__soapCall('GetExchangeRates', [$paramsBase]);
                $xmlBase = simplexml_load_string($resultBase->GetExchangeRatesResult);
                if ($xmlBase === false) {
                    throw new Exception('A válasz XML nem feldolgozható.');
                }
    
                foreach ($xmlBase->Day as $day) {
                    $date = (string)$day['date'];
                    $rate = (float)$day->Rate;
                    $exchangeRate = $rate; // baseCurrency árfolyama HUF-hoz képest
                    $rates[] = ['date' => $date, 'rate' => number_format($exchangeRate, 4)];
                }
    
            } else {
                // Ha egyik sem HUF, mindkét devizát lekérdezzük
                $paramsBase = [
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'currencyNames' => $baseCurrency
                ];
    
                $paramsTarget = [
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'currencyNames' => $targetCurrency
                ];
    
                $resultBase = $this->MNBClient->__soapCall('GetExchangeRates', [$paramsBase]);
                $xmlBase = simplexml_load_string($resultBase->GetExchangeRatesResult);
                if ($xmlBase === false) {
                    throw new Exception('A válasz XML nem feldolgozható.');
                }
    
                $resultTarget = $this->MNBClient->__soapCall('GetExchangeRates', [$paramsTarget]);
                $xmlTarget = simplexml_load_string($resultTarget->GetExchangeRatesResult);
                if ($xmlTarget === false) {
                    throw new Exception('A válasz XML nem feldolgozható.');
                }
    
                $baseRates = [];
                foreach ($xmlBase->Day as $day) {
                    $date = (string)$day['date'];
                    $rate = (float)$day->Rate;
                    $baseRates[$date] = $rate;
                }
    
                foreach ($xmlTarget->Day as $day) {
                    $date = (string)$day['date'];
                    $rate = (float)$day->Rate;
                    if (isset($baseRates[$date])) {
                        $exchangeRate = $baseRates[$date] / $rate;
                        $rates[] = ['date' => $date, 'rate' => number_format($exchangeRate, 4)];
                    }
                }
            }
    
            // Táblázat generálása HTML formátumban
            $htmlTable = '<table border="1">';
            $htmlTable .= '<tr><th>Date</th><th>Exchange Rate</th></tr>';
            foreach ($rates as $rate) {
                $htmlTable .= '<tr>';
                $htmlTable .= '<td>' . $rate['date'] . '</td>';
                $htmlTable .= '<td>' . $rate['rate'] . '</td>';
                $htmlTable .= '</tr>';
            }
            $htmlTable .= '</table>';
    
            return $htmlTable;
    
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    
    
    

}

$options = [
    'uri' => 'http://localhost/soapapi',
    'soap_version' => SOAP_1_2, // optional, choose SOAP version
    'trace' => true             // for debugging purposes];
];
$server = new SoapServer(null, $options);
$server->setClass('SoapServerModel');
$server->handle();
