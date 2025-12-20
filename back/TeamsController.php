<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbname = "football_db";
$host = "localhost";
$password = "";
$username = "root";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        if ($_GET['method'] === 'getTeams'){
            $conn = new mysqli($host, $username, $password, $dbname);
        
                if ($conn->connect_error) {
                    throw new Exception("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT * FROM teams ORDER BY id";
                $result = $conn->query($sql);
                
                if ($result === false) {
                    throw new Exception("Query failed: " . $conn->error);
                }
                
                $players = [];
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $players[] = [
                            'id' => (int)$row['id'],
                            'name' => $row['name'] ?? '',
                            'color' => ($row['color'] ?? 0),
                            'common_rate' => (float)($row['common_rate'] ?? 0),
                        ];
                    }
                }
                
                $conn->close();
                
                echo json_encode($players, JSON_PRETTY_PRINT);
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => true,
            'message' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use GET.']);
}
?>