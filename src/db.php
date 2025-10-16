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
        
        // Configuración de MongoDB - Edita estos valores si no usas archivo .env
        // IMPORTANTE: Reemplaza con tu URI real de MongoDB Atlas
        $uri = $env['MONGO_URI'] ?? 'mongodb+srv://usuario:password@cluster.mongodb.net/';
        $dbName = $env['MONGO_DB'] ?? 'escuela';
        $colName = $env['MONGO_COLLECTION'] ?? 'animales';
        
        // Si no tienes archivo .env, puedes descomentar y editar estas líneas:
        // $uri = 'mongodb+srv://TU_USUARIO:TU_PASSWORD@TU_CLUSTER.mongodb.net/';
        // $dbName = 'escuela';
        // $colName = 'animales';

        try {
            $this->client = new Client($uri);
            $this->db = $this->client->selectDatabase($dbName);
            $this->col = $this->db->selectCollection($colName);
            
            // Probar la conexión
            $this->client->selectServer();
            
        } catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
            die("
            <div style='background: #f8d7da; color: #721c24; padding: 20px; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px; font-family: Arial;'>
                <h3>❌ Error de Conexión a MongoDB</h3>
                <p><strong>No se pudo conectar a la base de datos MongoDB.</strong></p>
                <p><strong>URI intentada:</strong> $uri</p>
                <h4>Posibles soluciones:</h4>
                <ol>
                    <li><strong>Si usas MongoDB Atlas:</strong> Verifica que tu URI esté correcta en el archivo .env</li>
                    <li><strong>Si usas MongoDB local:</strong> Asegúrate de que MongoDB esté ejecutándose en el servidor</li>
                    <li><strong>Verifica la configuración de red:</strong> El servidor debe poder acceder a MongoDB</li>
                </ol>
                <p><strong>Error técnico:</strong> " . $e->getMessage() . "</p>
            </div>
            ");
        } catch (Exception $e) {
            die("
            <div style='background: #f8d7da; color: #721c24; padding: 20px; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px; font-family: Arial;'>
                <h3>❌ Error de Base de Datos</h3>
                <p><strong>Error:</strong> " . $e->getMessage() . "</p>
            </div>
            ");
        }
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
    