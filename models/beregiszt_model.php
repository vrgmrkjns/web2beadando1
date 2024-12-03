<?php
class Beregiszt_Model
{
    public function register_user($vars)
    {
        $retData['eredmeny'] = "";
        try {
            $connection = Database::getConnection();
            $checkSql = "SELECT * FROM felhasznalok WHERE fhn = :fhn";
            $checkStmt = $connection->prepare($checkSql);
            $checkStmt->execute([':fhn' => $vars['fhn']]);
            if ($checkStmt->rowCount() > 0) {
                $retData['eredmeny'] = "ERROR";
                $retData['uzenet'] = "A felhasználónév már foglalt!";
                return $retData;
            }

            $sql = "INSERT INTO felhasznalok (fhn, jlsz) VALUES (:fhn, :jlsz)";
            $stmt = $connection->prepare($sql);
            $stmt->execute([
                ':fhn' => $vars['fhn'],
                ':jlsz' => sha1($vars['jlsz']),
            ]);

            $retData['eredmeny'] = "OK";
            $retData['uzenet'] = "Sikeres regisztráció! Üdv, " . $vars['fhn'] . "!";

        } catch (PDOException $e) {
            $retData['eredmeny'] = "ERROR";
            $retData['uzenet'] = "Adatbázis hiba: " . $e->getMessage() . "!";
        }

        return $retData;
    }
}
?>
