<?php
/**
 * Modelo de Usuario
 * Maneja la lógica de datos para usuarios
 */

require_once __DIR__ . '/Database.php';

class User {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Buscar usuario por email
     */
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare('SELECT id, user_name, email, password_hash FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Buscar usuario por ID
     */
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT id, user_name, email, password_hash FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Buscar usuario por token de recordar
     */
    public function findByRememberToken(string $token): ?array {
        $stmt = $this->db->prepare('
            SELECT u.id, u.user_name, u.email, u.password_hash
            FROM users u
            JOIN remember_tokens rt ON u.id = rt.user_id
            WHERE rt.token = ? AND rt.expires_at > NOW()
        ');
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Crear nuevo usuario
     */
    public function create(string $userName, string $phoneNumber, string $email, string $password): int|false {
        // Verificar si el email ya existe
        if ($this->findByEmail($email)) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare('
            INSERT INTO users (user_name, phone_number, email, password_hash, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ');

        $result = $stmt->execute([$userName, $phoneNumber, $email, $passwordHash]);

        if ($result) {
            return (int)$this->db->lastInsertId();
        }

        return false;
    }

    /**
     * Establecer token de "recordarme"
     */
    public function setRememberToken(int $userId, string $token, int $expiry): bool {
        // Eliminar tokens anteriores
        $this->db->prepare('DELETE FROM remember_tokens WHERE user_id = ?')->execute([$userId]);

        $stmt = $this->db->prepare('
            INSERT INTO remember_tokens (user_id, token, expires_at)
            VALUES (?, ?, FROM_UNIXTIME(?))
        ');

        return $stmt->execute([$userId, $token, $expiry]);
    }

    /**
     * Eliminar token de recordar
     */
    public function deleteRememberToken(string $token): bool {
        $stmt = $this->db->prepare('DELETE FROM remember_tokens WHERE token = ?');
        return $stmt->execute([$token]);
    }

    /**
     * Actualizar contraseña (para recuperación)
     */
    public function updatePassword(int $userId, string $newPassword): bool {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
        return $stmt->execute([$passwordHash, $userId]);
    }

    /**
     * Crear token de recuperación de contraseña
     */
    public function createResetToken(int $userId): string {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + 3600; // 1 hora

        // Eliminar tokens anteriores
        $this->db->prepare('DELETE FROM password_resets WHERE user_id = ?')->execute([$userId]);

        $stmt = $this->db->prepare('
            INSERT INTO password_resets (user_id, token, expires_at)
            VALUES (?, ?, FROM_UNIXTIME(?))
        ');
        $stmt->execute([$userId, $token, $expiry]);

        return $token;
    }

    /**
     * Validar token de recuperación
     */
    public function validateResetToken(string $token): ?int {
        $stmt = $this->db->prepare('
            SELECT user_id FROM password_resets
            WHERE token = ? AND expires_at > NOW()
        ');
        $stmt->execute([$token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['user_id'] : null;
    }

    /**
     * Consumir token de recuperación (usado una vez)
     */
    public function consumeResetToken(string $token): bool {
        $stmt = $this->db->prepare('DELETE FROM password_resets WHERE token = ?');
        return $stmt->execute([$token]);
    }
}