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
                            'count_points'=> (int)$row['count_points'],
                        ];
                    }
                }
                
                $conn->close();
                
                echo json_encode($players, JSON_PRETTY_PRINT);
        }if ($_GET['method'] === 'getOneTeam'){
            $id = $_GET['id'];
            $conn = new mysqli($host, $username, $password, $dbname);
        
                if ($conn->connect_error) {
                    throw new Exception("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "SELECT * FROM teams WHERE id = " . $id;
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
}else if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($_GET['method'] === 'setPoints'){
            $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data || !isset($data['idTeam']) || !isset($data['countPoints'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required parameters: idTeam, countPoints']);
        exit;
    }
    
    $idTeam = (int)$data['idTeam'];
    $countPoints = (int)$data['countPoints'];

    $conn = new mysqli($host, $username, $password, $dbname);
        
                if ($conn->connect_error) {
                    throw new Exception("Connection failed: " . $conn->connect_error);
                }
                
                $sql = "UPDATE `teams` SET `count_points` = `count_points` + '$countPoints' WHERE `id` = $idTeam";
                $result = $conn->query($sql);
                
                if ($result === false) {
                    throw new Exception("Query failed: " . $conn->error);
                }
                $conn->close();
                
                echo json_encode([
            'success' => true, 
            'message' => 'Points updated successfully',
            'idTeam' => $idTeam,
            'countPoints' => $countPoints
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
 else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use GET.']);
 }
?>