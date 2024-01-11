        <?php

        class Database
        {
            private $conn;
            private $host;
            private $user;
            private $pass;
            private $db;

            public function __construct()
            {
                $this->host = 'localhost:3306';
                $this->user = 'root';
                $this->pass = '';
                $this->db = 'sui';

                $conn = "mysql:host=$this->host;dbname=$this->db";
                $this->conn = new PDO($conn, $this->user, $this->pass);
            }

            public function register(string $name, string $lastname, string $birthday, string $adres, string $rijbewijsnummer, int $tele, string $email, string $pass)
            {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return "Ongeldig e-mailadres";
                }
                if (strlen($pass) < 8) {
                    return "Wachtwoord moet minimaal 8 tekens bevatten";
                }
                if (!preg_match("/^[a-zA-Z-' ]*$/", $name) || !preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
                    return "Ongeldige naam of achternaam";
                }
                $sql = 'INSERT INTO klanten (klant_naam, klant_achternaam, birthday, adres, rijbewijsnummer, telefoonnummer, email, password) VALUES (:name, :lastname, :birthday, :adres, :rijbewijs, :tele, :email, :pass)';
                $stmt = $this->conn->prepare($sql);

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':birthday', $birthday);
                $stmt->bindParam(':adres', $adres);
                $stmt->bindParam(':rijbewijs', $rijbewijsnummer);
                $stmt->bindParam(':tele', $tele);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pass', $hash);

                $stmt->execute();
            }
            public function gebruikte_emails($email)
            {
                $stmt = $this->conn->prepare("SELECT * FROM klanten WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $count = $stmt->fetchColumn();

                return $count > 0;
            }

            public function login($email, $password)
            {
                if (!isset($_SESSION)) {
                    session_start();
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return "Ongeldig e-mailadres";
                }
                $query = $this->conn->prepare('SELECT * FROM klanten WHERE email = :email');
                $query->bindParam(':email', $email);
                $query->execute();

                $row = $query->fetch(PDO::FETCH_ASSOC);

                if ($row) {

                    if (password_verify($password, $row['password'])) {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["KlantID"] = $row['id'];
                    } else {
                        return "Verkeerd email of Wachtwoord";
                    }
                } else {
                    return "Gebruiker bestaat niet!!";
                }
            }
            public function deleteUser(int $userID)
            {
                $sql = 'DELETE FROM klanten WHERE KlantID =:ID';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(['ID' => $userID]);
            }
            public function getKlantID($email)
            {
                $stmt = $this->conn->prepare("SELECT KlantID FROM klanten WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result['KlantID'];
            }

            public function getUser($id = null)
            {
                $sql = 'SELECT * FROM klanten';
                $result = null;

                if ($id !== null) {
                    $sql = 'SELECT * FROM klanten WHERE KlantID = :id';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $stmt = $this->conn->query($sql);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                return $result;
            }
            //------------------------- ------------------------------klantlogin en registeren delete en update/selecteren------------------------------------------------------------//

            public function addCar($Name, $merk, $model, $type, $jaar, $kenteken, $kmafstand, $color, $Transmissie, $brandstof, $prijs, $imagename)
            {

                $sql = 'INSERT INTO auto (Name, Merk, Model, type, Jaar, Kenteken, kmafstand, Color, Transmissie,Brandstof, Prijs, Imagename) VALUES (:name, :merk, :model, :type, :jaar, :kenteken, :kmafstand, :color, :transmissie, :brandstof, :prijs, :file)';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':name', $Name);
                $stmt->bindParam(':merk', $merk);
                $stmt->bindParam(':model', $model);
                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':jaar', $jaar);
                $stmt->bindParam(':kenteken', $kenteken);
                $stmt->bindParam(':kmafstand', $kmafstand);
                $stmt->bindParam(':color', $color);
                $stmt->bindParam(':transmissie', $Transmissie);
                $stmt->bindParam(':brandstof', $brandstof);
                $stmt->bindParam(':prijs', $prijs);
                $stmt->bindParam(':file', $imagename);

                $stmt->execute();
            }
            function getBeschikbareAuto()
            {
                $sql = 'SELECT * FROM auto WHERE AutoID NOT IN (SELECT AutoID FROM verhuringen WHERE EindVerhuurdatum >= NOW())';
                $stmt = $this->conn->query($sql);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            public function getAllCars()
            {
                $sql = 'SELECT * FROM auto';
                $stmt = $this->conn->query($sql);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            public function editklant(string $name, string $lastname, string $birthday, string $adres, int $rijbewijsnummer, int $tele, string $email, string $pass, int $klantID)
            {
                $hash = password_hash($pass, PASSWORD_BCRYPT);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return "Ongeldig e-mailadres";
                }
                if (!preg_match("/^[a-zA-Z-' ]*$/", $name) || !preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
                    return "Ongeldige naam of achternaam";
                }

                $stmt = $this->conn->prepare("UPDATE klanten SET Klant_naam = ?, klant_achternaam = ?, birthday = ?, adres = ?, Rijbewijsnummer = ?, Telefoonnummer = ?, email = ?, password = ? WHERE KlantID = ?");
                $stmt->execute([$name, $lastname, $birthday, $adres, $rijbewijsnummer, $tele, $email, $hash, $klantID]);
            }

            public function editcar($Name, $merk, $model, $type, $jaar, $kenteken, $kmafstand, $color, $Transmissie, $brandstof, $prijs, $imagename, $autoID)
            {
                try {
                    $stmt = $this->conn->prepare("UPDATE auto SET Name=?, Merk=?, Model=?, type=?, Jaar=?, Kenteken=?, kmafstand=?, Color=?, Transmissie=?, Brandstof=?, Prijs=?, imagename=? WHERE AutoID=?");
                    $stmt->execute([$Name, $merk, $model, $type, $jaar, $kenteken, $kmafstand, $color, $Transmissie, $brandstof, $prijs, $imagename, $autoID]);

                    return true;
                } catch (PDOException $e) {
                    return "Error: " . $e->getMessage();
                }
            }
            public function deletecar($carID)
            {
                $sql = 'DELETE FROM auto WHERE autoID =:id';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(['id' => $carID]);
            }

            public function getcar($id = null)
            {
                $sql = 'SELECT * FROM auto';
                $result = null;

                if ($id !== null) {
                    $sql = 'SELECT * FROM auto WHERE autoID = :id';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $stmt = $this->conn->query($sql);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                return $result;
            }
            //------------------------- ------------------------------auto selecteren, toevoegen bewerken en verwijderen ------------------------------------------------------------//

            public function addReservation($startVerhuurdatum, $eindVerhuurdatum, $autoID, $klantID, $kosten)
            {
                try {
                    $insertQuery = "INSERT INTO verhuringen (StartVerhuurdatum, EindVerhuurdatum, AutoID, KlantID, Kosten)
                                    VALUES (:startVerhuurdatum, :eindVerhuurdatum, :autoID, :klantID, :kosten)";

                    $stmt = $this->conn->prepare($insertQuery);

                    $stmt->bindParam(':startVerhuurdatum', $startVerhuurdatum);
                    $stmt->bindParam(':eindVerhuurdatum', $eindVerhuurdatum);
                    $stmt->bindParam(':autoID', $autoID);
                    $stmt->bindParam(':klantID', $klantID);
                    $stmt->bindParam(':kosten', $kosten);

                    return $stmt->execute();
                } catch (PDOException $e) {
                    return "Error: " . $e->getMessage();
                }
            }
            public function getPricePerDay($autoID)
            {
                $prijsQuery = "SELECT Prijs FROM auto WHERE AutoID = :autoID";
                $prijsStmt = $this->conn->prepare($prijsQuery);
                $prijsStmt->bindParam(':autoID', $autoID);
                $prijsStmt->execute();
                $prijsResult = $prijsStmt->fetch(PDO::FETCH_ASSOC);

                return ($prijsResult) ? $prijsResult['Prijs'] : null;
            }
            public function getverhuring()
            {
                try {
                    $stmt = $this->conn->query("
                        SELECT v.VerhuurID, v.StartVerhuurdatum, v.EindVerhuurdatum, v.KlantID, k.Klant_naam, v.AutoID, v.Kosten
                        FROM verhuringen v
                        JOIN klanten k ON v.KlantID = k.KlantID
                        ORDER BY v.VerhuurID
                    ");
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $data;
                } catch (PDOException $e) {
                    return "Error: " . $e->getMessage();
                }
            }

            public function editverhuring($StartVerhuurdatum, $EindVerhuurdatum, $AutoID, $Kosten, $verhuurID)
            {
                try {
                    $stmt = $this->conn->prepare("UPDATE verhuringen SET StartVerhuurdatum=?, EindVerhuurdatum=?, AutoID=?, Kosten=? WHERE VerhuurID=?");
                    $stmt->execute([$StartVerhuurdatum, $EindVerhuurdatum, $AutoID, $Kosten, $verhuurID]);

                    return true;
                } catch (PDOException $e) {
                    return "Error: " . $e->getMessage();
                }
            }


            public function getReservedCarsForDate($date)
            {
                try {
                    $stmt = $this->conn->prepare("SELECT * FROM verhuringen WHERE :date BETWEEN StartVerhuurdatum AND EindVerhuurdatum");
                    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                    $stmt->execute();

                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
            public function deleteverhuuring(int $verhuurID)
            {
                $sql = 'DELETE FROM verhuringen WHERE VerhuurID =:ID';
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(['ID' => $verhuurID]);
            }
            public function gereserveerdeauto($klantID)
            {
                $sql = 'SELECT auto.* FROM verhuringen
                JOIN auto ON verhuringen.AutoID = auto.AutoID
                WHERE verhuringen.KlantID = :klantID';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':klantID', $klantID, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result;
            }

            public function verhuring($id = null)
            {
                $sql = 'SELECT * FROM verhuringen';
                $result = null;

                if ($id !== null) {
                    $sql = 'SELECT * FROM verhuringen WHERE KlantID = :id';
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $stmt = $this->conn->query($sql);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                return $result;
            }
            public function getGereserveerdeAutoIDsVoorDatumBereik($startDatum, $eindDatum)
            {
                try {
                    $stmt = $this->conn->prepare("SELECT AutoID FROM verhuringen WHERE (StartVerhuurdatum <= :eindDatum) AND (EindVerhuurdatum >= :startDatum)");
                    $stmt->bindParam(':startDatum', $startDatum);
                    $stmt->bindParam(':eindDatum', $eindDatum);
                    $stmt->execute();

                    return $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (PDOException $e) {
                    echo "Fout: " . $e->getMessage();
                }
            }

            public function haalAlleBeschikbareAutosOp($gereserveerdeAutoIDs)
            {

                if (empty($gereserveerdeAutoIDs)) {
                    $gereserveerdeAutoIDs = [0];
                }

                $plaatsHouder = implode(',', array_fill(0, count($gereserveerdeAutoIDs), '?'));

                $sql = "SELECT * FROM auto WHERE AutoID NOT IN ($plaatsHouder)";
                $stmt = $this->conn->prepare($sql);
                foreach ($gereserveerdeAutoIDs as $key => $value) {
                    $stmt->bindValue(($key + 1), $value, PDO::PARAM_INT);
                }

                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
