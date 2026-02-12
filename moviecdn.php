<?php
/**
 * MovieIMDB - includes/config.php
 *
 * Central config: start session, DB connection, and small helpers.
 *
 * Place in MovieIMDB/includes/config.php
 * Edit DB creds below or use environment variables DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT
 */

// Uncomment while developing (optional)
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database credentials (prefer env vars in production)
$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$DB_NAME = getenv('DB_NAME') ?: 'movie_app';
$DB_PORT = getenv('DB_PORT') ?: 3306;

// Create mysqli connection
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, (int)$DB_PORT);
if ($mysqli->connect_errno) {
    error_log('MySQL connect error: ' . $mysqli->connect_error);
    // Fail fast - friendly message
    die('Database connection error. Please check database settings.');
}
$mysqli->set_charset('utf8mb4');

// -------------------------
// Global helpers
// -------------------------

// esc() - safe HTML escape for output. Guarded to avoid redeclaration.
if (!function_exists('esc')) {
    function esc($v) {
        return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
    }
}

// Alias e() to esc() (some files use e())
if (!function_exists('e')) {
    function e($v) { return esc($v); }
}

// current_user_id helper
if (!function_exists('current_user_id')) {
    function current_user_id() {
        return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    }
}

// is_admin helper (admin pages set $_SESSION['admin_id'] or $_SESSION['is_admin'])
if (!function_exists('is_admin')) {
    function is_admin() {
        if (!empty($_SESSION['admin_id'])) return true;
        if (!empty($_SESSION['is_admin'])) return true;
        return false;
    }
}

// Flash helpers (simple)
if (!function_exists('flash_set')) {
    function flash_set($key, $msg) {
        if (!isset($_SESSION['_flash'])) $_SESSION['_flash'] = [];
        $_SESSION['_flash'][$key] = $msg;
    }
}
if (!function_exists('flash_get')) {
    function flash_get($key) {
        if (!isset($_SESSION['_flash'])) return null;
        $v = $_SESSION['_flash'][$key] ?? null;
        if (isset($_SESSION['_flash'][$key])) unset($_SESSION['_flash'][$key]);
        return $v;
    }
}

// Convenience wrapper for single-row prepared queries
if (!function_exists('query_one')) {
    function query_one($mysqli, $sql, $types = '', $params = []) {
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) return null;
        if ($types && $params) {
            $bind = array_merge([$types], $params);
            // bind_param requires references
            $refs = [];
            foreach ($bind as $k => $v) $refs[$k] = &$bind[$k];
            call_user_func_array([$stmt, 'bind_param'], $refs);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;
        $stmt->close();
        return $row;
    }
}

// Convenience wrapper for multi-row prepared queries
if (!function_exists('query_all')) {
    function query_all($mysqli, $sql, $types = '', $params = []) {
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) return [];
        if ($types && $params) {
            $bind = array_merge([$types], $params);
            $refs = [];
            foreach ($bind as $k => $v) $refs[$k] = &$bind[$k];
            call_user_func_array([$stmt, 'bind_param'], $refs);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
        return $rows;
    }
}

/*
 * Note:
 * - Keep this file minimal and central.
 * - For larger helper libraries, create includes/functions.php and require it here.
 */
    
