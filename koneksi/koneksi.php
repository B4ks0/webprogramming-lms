<?php

$db_driver = getenv('APP_DB') ?: 'mysql';
$db_type = $db_driver === 'sqlite' ? 'sqlite' : 'mysql';

try {
    if ($db_type === 'sqlite') {
        $sqlitePath = dirname(__DIR__) . '/database/database.sqlite';
        if (!is_dir(dirname($sqlitePath))) {
            mkdir(dirname($sqlitePath), 0777, true);
        }
        $koneksi = new PDO('sqlite:' . $sqlitePath);
    } else {
        $db_host = getenv('DB_HOST') ?: 'localhost';
        $db_user = getenv('DB_USER') ?: 'root';
        $db_pass = getenv('DB_PASS') ?: '';
        $db_name = getenv('DB_NAME') ?: 'db_webprogramming';
        $koneksi = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass);
    }

    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $koneksi->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Koneksi database gagal: ' . $e->getMessage());
}

class DbResult {
    public array $rows;
    private int $index = 0;

    public function __construct(array $rows = []) {
        $this->rows = $rows;
    }

    public function fetch_assoc(): ?array {
        if ($this->index >= count($this->rows)) {
            return null;
        }
        return $this->rows[$this->index++];
    }

    public function num_rows(): int {
        return count($this->rows);
    }
}

class DbStatement {
    public PDOStatement $stmt;
    public array $params = [];

    public function __construct(PDOStatement $stmt) {
        $this->stmt = $stmt;
    }
}

function db_prepare(PDO $db, string $sql): DbStatement {
    return new DbStatement($db->prepare(db_translate_sql($sql)));
}

function db_stmt_bind_param(DbStatement $stmt, string $types, &...$vars): bool {
    $stmt->params = array_values($vars);
    return true;
}

function db_stmt_execute(DbStatement $stmt): bool {
    return $stmt->stmt->execute($stmt->params);
}

function db_stmt_get_result(DbStatement $stmt): DbResult {
    return new DbResult($stmt->stmt->fetchAll(PDO::FETCH_ASSOC));
}

function db_query(PDO $db, string $sql): DbResult|bool {
    $statement = $db->query(db_translate_sql($sql));
    if (!$statement) {
        return false;
    }
    return new DbResult($statement->fetchAll(PDO::FETCH_ASSOC));
}

function db_fetch_assoc(DbResult|false $result): ?array {
    return $result ? $result->fetch_assoc() : null;
}

function db_fetch_array(DbResult|false $result): ?array {
    return db_fetch_assoc($result);
}

function db_num_rows(DbResult|false $result): int {
    return $result ? $result->num_rows() : 0;
}

function db_translate_sql(string $sql): string {
    global $db_type;

    if ($db_type !== 'sqlite') {
        return $sql;
    }

    $sql = str_replace('CURRENT_TIMESTAMP()', 'CURRENT_TIMESTAMP', $sql);
    return $sql;
}
