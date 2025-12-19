<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$dbname = "football_db";
$username = "root";
$password = "";


function getPlayers() {
    global $host, $dbname, $username, $password;
    
    try {
        $conn = new mysqli($host, $username, $password, $dbname);

        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM players ORDER BY id";
        $result = $conn->query($sql);
        
        $players = [];
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $players[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'number' => $row['number'],
                    'rate' => $row['rate']
                ];
            }
        }
        
        $conn->close();
        
        return $players;
        
    } catch (Exception $e) {

        return ['error' => $e->getMessage()];
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $players = getPlayers();
    echo json_encode($players, JSON_PRETTY_PRINT);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use GET.']);
}
?>