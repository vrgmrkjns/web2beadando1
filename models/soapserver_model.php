<?php

class SoapServer_Model {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getJoinedData() {
        $sql = "
            SELECT hajo.az AS hajaz, hajo.nev AS hajnev, tipus, tulajdonos.nev AS tulnev, varos, tort.nev AS reginev
            FROM hajo
            INNER JOIN tulajdonos ON hajo.tulaz = tulajdonos.az
            INNER JOIN tort ON hajo.az = tort.hajoaz
        ";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}