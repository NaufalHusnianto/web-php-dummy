<?php
require_once("config.php");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // validasi CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        die('CSRF token tidak valid');
    }

    // ambil input
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $ip = $_SERVER['REMOTE_ADDR'];

    // Cleanup data lama
    $pdo->prepare("DELETE FROM login_attempts WHERE last_attempt < NOW() - INTERVAL 24 HOUR")->execute();

    // LAYER 1: Check IP+Email combination (seperti kode awal)
    $stmt = $pdo->prepare("
        SELECT attempts, last_attempt,
            TIMESTAMPDIFF(SECOND, last_attempt, NOW()) as seconds_ago
        FROM login_attempts 
        WHERE ip_address = ? AND email = ?
    ");
    $stmt->execute([$ip, $email]);
    $combo_data = $stmt->fetch();

    // Reset jika sudah lebih dari 10 menit
    if ($combo_data && $combo_data['seconds_ago'] >= 600) {
        $pdo->prepare("DELETE FROM login_attempts WHERE ip_address = ? AND email = ?")
            ->execute([$ip, $email]);
        $combo_data = null;
    }

    // Blokir jika masih dalam cooldown
    if ($combo_data && $combo_data['attempts'] >= 5) {
        $remaining = ceil((600 - $combo_data['seconds_ago']) / 60);
        die("Terlalu banyak percobaan. Coba lagi dalam $remaining menit.");
    }

    // LAYER 2: Global account lock (dari berbagai IP)
    $stmt = $pdo->prepare("
        SELECT COUNT(DISTINCT ip_address) as unique_ips,
            COUNT(*) as total_attempts,
            MAX(last_attempt) as last_try,
            TIMESTAMPDIFF(SECOND, MAX(last_attempt), NOW()) as seconds_ago
        FROM login_attempts 
        WHERE email = ? 
        AND last_attempt > NOW() - INTERVAL 1 HOUR
        GROUP BY email
    ");
    $stmt->execute([$email]);
    $account_data = $stmt->fetch();

    if ($account_data) {
        // Jika ada 3 IP berbeda mencoba akun ini dalam 1 jam
        if ($account_data['unique_ips'] >= 3 && $account_data['total_attempts'] >= 15) {
            if ($account_data['seconds_ago'] < 7200) { // 2 jam lock
                die("Akun ini dikunci sementara karena aktivitas mencurigakan.");
            } else {
                // Reset setelah 2 jam
                $pdo->prepare("DELETE FROM login_attempts WHERE email = ?")->execute([$email]);
            }
        }
    }

    // LAYER 3: IP rate limiting
    $stmt = $pdo->prepare("
        SELECT COUNT(DISTINCT email) as unique_accounts,
            COUNT(*) as total_attempts
        FROM login_attempts 
        WHERE ip_address = ? 
        AND last_attempt > NOW() - INTERVAL 5 MINUTE
        GROUP BY ip_address
    ");
    $stmt->execute([$ip]);
    $ip_rate_data = $stmt->fetch();

    // Jika 1 IP mencoba 10 akun berbeda dalam 5 menit
    if ($ip_rate_data && $ip_rate_data['unique_accounts'] >= 10) {
        die("Terlalu banyak percobaan login dari IP Anda.");
    }


    if (empty($email) || empty($password)) {
        $error = "Email dan password harus diisi";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true); // Generate a new session ID

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['logged_in'] = true;

                $stmt = $pdo->prepare("
                    DELETE FROM login_attempts 
                    WHERE ip_address = ? AND email = ?
                ");
                $stmt->execute([$ip, $email]);

                header("Location: index.php");
                exit;
            } else {
                $error = "Email atau password salah";
                if ($combo_data) {
                    $stmt = $pdo->prepare("
                        UPDATE login_attempts 
                        SET attempts = attempts + 1, last_attempt = NOW() 
                        WHERE ip_address = ? AND email = ?
                    ");
                    $stmt->execute([$ip, $email]);
                } else {
                    $stmt = $pdo->prepare("
                        INSERT INTO login_attempts (ip_address, email, attempts, last_attempt) 
                        VALUES (?, ?, 1, NOW())
                    ");
                    $stmt->execute([$ip, $email]);
                }
                // unset($_SESSION['csrf_token']);
            }
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan sistem";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="login-card p-4">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Login</h2>
            <p class="text-muted">Sistem Informasi Perpustakaan</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="csrf_token"
                value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required
                    placeholder="Masukkan email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required
                    placeholder="Masukkan password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="text-center mt-3">
            <a href="index.php" class="text-decoration-none">Kembali ke halaman utama</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>