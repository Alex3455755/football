<?php
require_once __DIR__ . '/cors.php';



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
        if ($_GET['method'] === 'getPlayers'){
            $conn = new mysqli($host, $username, $password, $dbname);
        
                if ($conn->connect_error) {
                    throw new Exception("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT * FROM players ORDER BY id";
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
                            'number' => (int)($row['number'] ?? 0),
                            'rate' => (float)($row['rate'] ?? 0),
                            'team_id' => (int)$row['team_id']
                        ];
                    }
                }
                
                $conn->close();
                
                echo json_encode($players, JSON_PRETTY_PRINT);
        }if ($_GET['method'] === 'getPlayersByTeam'){
            $id = $_GET['id'];
            $conn = new mysqli($host, $username, $password, $dbname);
        
                if ($conn->connect_error) {
                    throw new Exception("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT * FROM players WHERE team_id = ".$id;
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
                            'number' => (int)($row['number'] ?? 0),
                            'rate' => (float)($row['rate'] ?? 0),
                            'team_id' => (int)$row['team_id']
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