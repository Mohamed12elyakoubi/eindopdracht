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
        $this->db = 'eindopdracht';

        $conn = "mysql:host=$this->host;dbname=$this->db";
        $this->conn = new PDO($conn, $this->user, $this->pass);
    }
    public function addadmin(string $name, string $email, string $pass)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Ongeldig e-mailadres";
        }
    
        if (strlen($pass) < 8) {
            return "Wachtwoord moet minimaal 8 tekens bevatten";
        }
    
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            return "Ongeldige naam";
        }

        $hash = password_hash($pass, PASSWORD_BCRYPT);
        $sql = "INSERT INTO admin (name, email, Wachtwoord) VALUES (:name, :email, :pass)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $hash);
        $stmt->execute();
    }
    public function getadmin($id = null)
    {
        $sql = 'SELECT * FROM admin';
        $result = null;

        if ($id !== null) {
            $sql = 'SELECT * FROM admin WHERE ID = :id';
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
    public function editadmin(string $name, string $email, string $pass, int $adminID)
    {
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Ongeldig e-mailadres";
        }
    
        if (strlen($pass) < 8) {
            return "Wachtwoord moet minimaal 8 tekens bevatten";
        }
        
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            return "Ongeldige naam";
        }
        $stmt = $this->conn->prepare("UPDATE admin SET name = ?, email = ?, Wachtwoord = ? WHERE ID = ?");
        $stmt->execute([$name, $email, $hash, $adminID]);
    }
    public function deleteadmin(int $adminID)
    {
        $sql = 'DELETE FROM admin WHERE ID =:ID';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ID' => $adminID]);
    }
    public function loginadmin($email, $password)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Ongeldig e-mailadres";
        }
        $query = $this->conn->prepare('SELECT * FROM admin WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (password_verify($password, $row['Wachtwoord'])) {
                $_SESSION["loggedin"] = true;
                $_SESSION["ID"] = $row['ID'];
            } else {
                return "Verkeerde email of wachtwoord";
            }
        } else {
            return "Er is geen Medewerker gevonden";
        }
    }

    
}
?>
