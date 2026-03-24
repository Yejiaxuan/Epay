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
 * 判断是否为 bcrypt 哈希
 * @param string $hash
 * @return bool
 */
function is_bcrypt_hash($hash) {
    return is_string($hash) && preg_match('/^\$2[aby]\$\d{2}\$/', $hash) === 1;
}

/**
 * 商户密码哈希
 * @param string $password
 * @return string|false
 */
function hash_user_password($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * 校验商户密码，兼容旧版 MD5+UID 盐值
 * @param string $password
 * @param string $hash
 * @param int|null $uid
 * @return bool
 */
function verify_user_password($password, $hash, $uid = null) {
    if (!is_string($hash) || $hash === '') {
        return false;
    }
    if (is_bcrypt_hash($hash)) {
        return password_verify($password, $hash);
    }
    if ($uid === null) {
        return false;
    }
    return hash_equals($hash, getMd5Pwd($password, $uid));
}

/**
 * 商户密码是否需要升级为 bcrypt
 * @param string $hash
 * @return bool
 */
function user_password_needs_rehash($hash) {
    if (!is_bcrypt_hash($hash)) {
        return true;
    }
    return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * 验证明文或 bcrypt 存储的口令
 * @param string $password
 * @param string $stored
 * @return bool
 */
function verify_hashed_or_plaintext_password($password, $stored) {
    if (!is_string($stored) || $stored === '') {
        return false;
    }
    if (is_bcrypt_hash($stored)) {
        return password_verify($password, $stored);
    }
    return hash_equals((string)$stored, (string)$password);
}

/**
 * 口令是否需要升级为 bcrypt
 * @param string $stored
 * @return bool
 */
function stored_password_needs_rehash($stored) {
    if (!is_bcrypt_hash($stored)) {
        return true;
    }
    return password_needs_rehash($stored, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * 是否为公网可路由 IP
 * @param string $ip
 * @return bool
 */
function is_public_ip_address($ip) {
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return false;
    }
    return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false;
}

/**
 * 解析主机名对应 IP 列表
 * @param string $host
 * @return array
 */
function resolve_host_ips($host) {
    $ips = [];
    if (function_exists('dns_get_record')) {
        $types = DNS_A;
        if (defined('DNS_AAAA')) {
            $types |= DNS_AAAA;
        }
        $records = @dns_get_record($host, $types);
        if (is_array($records)) {
            foreach ($records as $record) {
                if (!empty($record['ip'])) {
                    $ips[] = $record['ip'];
                } elseif (!empty($record['ipv6'])) {
                    $ips[] = $record['ipv6'];
                }
            }
        }
    }
    if (empty($ips) && function_exists('gethostbynamel')) {
        $resolved = @gethostbynamel($host);
        if (is_array($resolved)) {
            $ips = array_merge($ips, $resolved);
        }
    }
    if (empty($ips) && function_exists('gethostbyname')) {
        $resolved = @gethostbyname($host);
        if (!empty($resolved) && $resolved !== $host) {
            $ips[] = $resolved;
        }
    }
    return array_values(array_unique($ips));
}

/**
 * 选择一个公网 IP，用于安全回调请求
 * @param string $host
 * @return string|false
 */
function resolve_public_host_ip($host) {
    if (filter_var($host, FILTER_VALIDATE_IP)) {
        return is_public_ip_address($host) ? $host : false;
    }
    $ips = resolve_host_ips($host);
    foreach ($ips as $ip) {
        if (is_public_ip_address($ip)) {
            return $ip;
        }
    }
    return false;
}

/**
 * 校验回调 URL 是否安全
 * @param string $url
 * @param bool $require_public_host 是否要求主机必须可公网解析
 * @return bool
 */
function callback_url_is_valid($url, $require_public_host = false) {
    if (!is_string($url) || trim($url) === '') {
        return false;
    }
    $parts = @parse_url($url);
    if ($parts === false || empty($parts['scheme']) || empty($parts['host'])) {
        return false;
    }
    $scheme = strtolower($parts['scheme']);
    if (!in_array($scheme, ['http', 'https'], true)) {
        return false;
    }
    if (isset($parts['user']) || isset($parts['pass'])) {
        return false;
    }
    if (!empty($parts['port']) && (!is_numeric($parts['port']) || $parts['port'] < 1 || $parts['port'] > 65535)) {
        return false;
    }
    $host = strtolower(trim($parts['host'], '[]'));
    if ($host === 'localhost' || substr($host, -6) === '.local' || substr($host, -12) === '.localdomain') {
        return false;
    }
    if ($require_public_host) {
        return resolve_public_host_ip($host) !== false;
    }
    return true;
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
    return is_bcrypt_hash($hash) && password_verify($password, $hash);
}
