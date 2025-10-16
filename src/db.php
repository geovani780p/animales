<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

class DB {
    public Client $client;
    public $db;
    public $col;

    public function __construct() {
        $envPath = __DIR__ . '/../.env';
        $env = [];
        if (file_exists($envPath)) {
            foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (str_starts_with(trim($line), '#')) continue;
                [$k,$v] = array_pad(explode('=', $line, 2), 2, null);
                if ($k) $env[trim($k)] = trim($v);
            }
        }
        $uri = $env['MONGO_URI'] ?? 'mongodb://127.0.0.1:27017';
        $dbName = $env['MONGO_DB'] ?? 'escuela';
        $colName = $env['MONGO_COLLECTION'] ?? 'animales';

        $this->client = new Client($uri);
        $this->db = $this->client->selectDatabase($dbName);
        $this->col = $this->db->selectCollection($colName);
    }

    public static function oid(string $id): ObjectId {
        return new ObjectId($id);
    }
}

function h(?string $s): string {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

function baseUrl(): string {
    // Ajusta si despliegas en subcarpeta distinta
    $envPath = __DIR__ . '/../.env';
    $base = '/crud_animales_php_mongodb/public';
    if (file_exists($envPath)) {
        foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (str_starts_with(trim($line), '#')) continue;
            [$k,$v] = array_pad(explode('=', $line, 2), 2, null);
            if ($k === 'APP_BASE') $base = trim($v);
        }
    }
    return rtrim($base, '/');
}
    