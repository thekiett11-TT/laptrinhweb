<?php
require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
require_once __DIR__ . '/../../vendor/autoload.php';

class JWTHandler
{
private $secret_key;
public function __construct()
{
$this->secret_key = str_pad("HUTECH", 32, "_"); // Padding thành 32 bytes vì thư viện jwt v6 bắt buộc độ dài key tối thiểu cho SHA256
}
// Tạo JWT
public function encode($data)
{
$issuedAt = time();
$expirationTime = $issuedAt + 3600; // jwt valid for 1 hour from the issued time


$payload = array(
'iat' => $issuedAt,
'exp' => $expirationTime,
'data' => $data
);
return JWT::encode($payload, $this->secret_key, 'HS256');
}
// Giải mã JWT
public function decode($jwt)
{
try {
$decoded = JWT::decode($jwt, new Key($this->secret_key, 'HS256'));
return (array) $decoded->data;
} catch (Exception $e) {
return null;
}
}
}
?>