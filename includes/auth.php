<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function isLoggedIn(): bool
{
    return currentUser() !== null;
}

function hasRole(string $role): bool
{
    $user = currentUser();
    return $user !== null && $user['role'] === $role;
}

function requireLogin(?string $role = null): void
{
    if (!isLoggedIn()) {
        header('Location: /auth/login.php');
        exit;
    }

    if ($role !== null && !hasRole($role)) {
        http_response_code(403);
        echo 'Access denied.';
        exit;
    }
}

function login(string $email, string $password): bool
{
    $stmt = db()->prepare('SELECT id, full_name, email, role, password_hash FROM users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return false;
    }

    unset($user['password_hash']);
    $_SESSION['user'] = $user;

    return true;
}

function logout(): void
{
    $_SESSION = [];
    session_destroy();
}

function registerCustomer(string $fullName, string $email, string $password, string $phone, string $address): bool
{
    $stmt = db()->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        return false;
    }

    $insert = db()->prepare('INSERT INTO users (full_name, email, password_hash, role, phone, address) VALUES (:name, :email, :hash, :role, :phone, :address)');

    return $insert->execute([
        'name' => $fullName,
        'email' => $email,
        'hash' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'customer',
        'phone' => $phone,
        'address' => $address,
    ]);
}
