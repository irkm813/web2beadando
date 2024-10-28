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
    public function addRecord($table, $data) {

        try{
            //a dbAuth() metódussal ellenőrzi, hogy a BasicAuth-al beküldött felhasználónév/jelszó létezik-e az adatbázisban.
            if (!$this->db->dbAuth($this->username, $this->password)) {
                throw new Exception('Hibás felhasználónév vagy jelszó');
            }

            if ($this->role != "admin"){
                throw new Exception('Nem megfelelő jogosultság');
            }

            if (is_object($data)) {
                $data = json_decode(json_encode($data), true); // XML-ből tömbbé alakítjuk
            }

            if (!is_array($data) || empty($data)) {
                throw new Exception("Érvénytelen adat: asszociatív tömb szükséges");
            }

            //Sikeres autentikáció után hozzáad egy elemet a rekordhoz
            return $this->db->insert($table, $data);
            
        }
        catch (Exception $e) {
            return "$e";
        } 
    }

    // Rekord frissítése
    public function updateRecord($table,$id,$data) {
        try{
            //a dbAuth() metódussal ellenőrzi, hogy a BasicAuth-al beküldött felhasználónév/jelszó létezik-e az adatbázisban.
            if (!$this->db->dbAuth($this->username, $this->password)) {
                throw new Exception('Hibás felhasználónév vagy jelszó');
            }

            if ($this->role != "admin"){
                throw new Exception('Nem megfelelő jogosultság');
            }

            if (is_object($data)) {
                $data = json_decode(json_encode($data), true); // XML-ből tömbbé alakítjuk
            }

            if (!is_array($data) || empty($data)) {
                throw new Exception("Érvénytelen adat: asszociatív tömb szükséges");
            }

            //Sikeres autentikáció után hozzáad egy elemet a rekordhoz
            return $this->db->update($table, $data, 'id = ?', [$id]);
            
        }
        catch (Exception $e) {
            return "$e";
        } 
    }

    //Rekord törlése
    public function deleteRecord($table,$id) {
        try{
            //a dbAuth() metódussal ellenőrzi, hogy a BasicAuth-al beküldött felhasználónév/jelszó létezik-e az adatbázisban.
            if (!$this->db->dbAuth($this->username, $this->password)) {
                throw new Exception('Hibás felhasználónév vagy jelszó');
            }

            if ($this->role != "admin"){
                throw new Exception('Nem megfelelő jogosultság');
            }

            //Sikeres autentikáció után hozzáad egy elemet a rekordhoz
            return $this->db->delete($table,'id = ?', [$id]);
            
        }
        catch (Exception $e) {
            return "$e";
        } 
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
}

$options = [
    'uri' => 'http://localhost/soapapi',
    'soap_version' => SOAP_1_2, // optional, choose SOAP version
    'trace' => true             // for debugging purposes];
];
$server = new SoapServer(null, $options);
$server->setClass('SoapServerModel');
$server->handle();
