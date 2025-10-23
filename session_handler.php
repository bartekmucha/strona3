<?php
class MySQLSessionHandler implements SessionHandlerInterface {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function open($savePath, $sessionName) {
        return true;
    }

    public function close() {
        return true;
    }

    public function read($id) {
        $stmt = $this->pdo->prepare("SELECT data FROM php_sessions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['data'] : '';
    }

    public function write($id, $data) {
        $stmt = $this->pdo->prepare(
            "REPLACE INTO php_sessions (id, data, timestamp) VALUES (:id, :data, :timestamp)"
        );
        return $stmt->execute([
            'id' => $id,
            'data' => $data,
            'timestamp' => time()
        ]);
    }

    public function destroy($id) {
        $stmt = $this->pdo->prepare("DELETE FROM php_sessions WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function gc($maxlifetime) {
        $stmt = $this->pdo->prepare("DELETE FROM php_sessions WHERE timestamp < :time");
        return $stmt->execute(['time' => time() - $maxlifetime]);
    }
}
?>
