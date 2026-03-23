<?php
/**
 * 安全加固辅助函数
 * Security hardening helpers
 */

/**
 * 验证列名是否在白名单中，防止 SQL 注入
 * @param string $column 用户提供的列名
 * @param array $whitelist 允许的列名列表
 * @param string $default 默认列名
 * @return string 安全的列名
 */
function safe_column($column, $whitelist, $default = null) {
    $column = trim($column);
    if (in_array($column, $whitelist, true)) {
        return $column;
    }
    if ($default !== null) {
        return $default;
    }
    return false;
}

/**
 * 验证排序字段是否安全
 * @param string $order 用户提供的排序字符串（如 "uid desc"）
 * @param array $allowed_columns 允许的列名
 * @param string $default 默认排序
 * @return string 安全的排序字符串
 */
function safe_order($order, $allowed_columns, $default = 'id desc') {
    $order = trim(str_replace('_', ' ', $order));
    $parts = preg_split('/\s+/', $order, 2);
    $col = $parts[0] ?? '';
    $dir = strtoupper($parts[1] ?? 'DESC');

    if (!in_array($col, $allowed_columns, true)) {
        return $default;
    }
    if (!in_array($dir, ['ASC', 'DESC'], true)) {
        $dir = 'DESC';
    }
    return "`{$col}` {$dir}";
}

/**
 * 安全转义 SQL 值（仍建议用 prepared statements，这是兜底方案）
 * @param string $value
 * @return string
 */
function safe_value($value) {
    return addslashes(trim($value));
}

/**
 * 生成安全的 CSRF token
 * @return string
 */
function generate_csrf_token() {
    return bin2hex(random_bytes(32));
}

/**
 * 密码哈希（使用 bcrypt 替代 MD5）
 * @param string $password 明文密码
 * @return string 哈希后的密码
 */
function secure_password_hash($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * 验证密码
 * @param string $password 明文密码
 * @param string $hash 存储的哈希
 * @return bool
 */
function secure_password_verify($password, $hash) {
    // 兼容旧版 MD5 密码
    if (strlen($hash) === 32) {
        // 这是旧的 MD5 格式，暂时兼容
        return false; // 需要重置密码
    }
    return password_verify($password, $hash);
}
