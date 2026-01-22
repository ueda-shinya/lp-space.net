<?php
session_start();

$limit_seconds = 60;
$now = time();
$rate_limited = false;
if (isset($_SESSION['last_submit_time']) && ($now - $_SESSION['last_submit_time']) < $limit_seconds) {
  $rate_limited = true;
}

if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
  http_response_code(403);
  echo json_encode(["error" => "不正な送信が検出されました（CSRFトークン不一致）。"]);
  exit;
}

mb_language("ja");
mb_internal_encoding("UTF-8");
$admin_email = "tentoumushi0013@gmail.com,info@linnoa.net";
// $admin_email = "kms2wa8z@gmail.com";
$from_email = "no-reply@lp-space.net";

function sanitize($key)
{
  return htmlspecialchars(trim($_POST[$key] ?? ''), ENT_QUOTES, 'UTF-8');
}

$name = sanitize("name");
$tel = sanitize("tel");
$email = trim($_POST["email"] ?? '');
$career = sanitize("career");
$message = sanitize("message");
$nickname = trim($_POST["nickname"] ?? '');

if ($nickname !== "") {
  http_response_code(403);
  echo json_encode(["error" => "不正なアクセスが検出されました。"]);
  exit;
}

if (
  $name === '' ||
  $tel === '' ||
  $email === '' || $career === '' ||
  !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
  http_response_code(400);
  echo json_encode(["error" => "入力内容に不備があります。必須項目をご確認ください。"]);
  exit;
}

if (!preg_match('/^[0-9\-]+$/', $tel)) {
  http_response_code(400);
  echo json_encode(["error" => "電話番号の形式が正しくありません。"]);
  exit;
}

$tel_digits = str_replace('-', '', $tel);
if (strlen($tel_digits) < 10 || strlen($tel_digits) > 11) {
  http_response_code(400);
  echo json_encode(["error" => "電話番号は10〜11桁の数字で入力してください。"]);
  exit;
}

//  トークン更新処理
unset($_SESSION['csrf_token']);
$new_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $new_token;

$log_dir = __DIR__ . '/logs';
$log_file = $log_dir . '/form.log';
if (!is_dir($log_dir)) {
  mkdir($log_dir, 0755, true);
}
$log_entry = sprintf(
  "[%s] IP: %s | Email: %s | Name: %s\n",
  date('Y-m-d H:i:s'),
  $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN',
  $email,
  $name
);
file_put_contents($log_file, $log_entry, FILE_APPEND);

$subject_user = "【CLALA】求人のお問い合わせありがとうございます。";
$subject_admin = "【CLALA求人LP】お問い合わせフォームから問い合わせがありました。";

$body_admin = <<<EOT
求人LPよりお問い合わせがはいりましたので、ご確認とご対応よろしくお願いいたします。

【お名前】 {$name}
【電話番号】 {$tel}
【メールアドレス】 {$email}
【美容師歴】 {$career}
【ご質問・ご要望】
{$message}
EOT;

$body_user = <<<EOT
{$name} 様

この度は、CLALAの求人にご興味をお持ちいただき、
またお問い合わせをお送りいただき誠にありがとうございます。

▼ご入力内容
――――――――――――
【お名前】 {$name}
【電話番号】 {$tel}
【メールアドレス】 {$email}
【美容師歴】 {$career}
【ご質問・ご要望】
{$message}


内容を確認のうえ、担当者より【1〜2営業日以内】に
ご連絡させていただきますので、今しばらくお待ちください。

なお、
・面接やサロン見学について
・働き方やシフトのご相談
・ブランクや経験に関するご質問

など、事前に気になることがございましたら、
ご遠慮なくお聞かせください。

「まずは話を聞いてみたい」「雰囲気を見てから検討したい」
という方も大歓迎です。

あなたにとって、
“無理なく、長く、美容師を続けられる場所かどうか”
を一緒に確認できればと思っています。

それでは、担当者からのご連絡をお待ちください。

――――――――――――
Hair & Beauty Toco Magico
採用担当　中石
TEL：098ｰ998ｰ0910
――――――――――――
EOT;

$headers = "From: {$from_email}";
$success_user = mb_send_mail($email, $subject_user, $body_user, $headers);
$success_admin = mb_send_mail($admin_email, $subject_admin, $body_admin, $headers);

header("Content-Type: application/json");

if ($success_user && $success_admin) {
  $_SESSION['last_submit_time'] = $now;
  echo json_encode([
    "status" => "success",
    "redirect" => "https://lp-space.net/clala_2026/thanks.html",
    "message" => "お問い合わせありがとうございます。確認メールを送信しました。"
  ]);
  exit;
} else {
  if ($rate_limited) {
    $wait = $limit_seconds - ($now - $_SESSION['last_submit_time']);
    http_response_code(429);
    echo json_encode(["status" => "error", "error" => "短時間に連続して送信されています。{$wait}秒後に再送信してください。"]);
    exit;
  }
  http_response_code(500);
  echo json_encode(["status" => "error", "error" => "メール送信中にエラーが発生しました。時間を置いて再度お試しください。"]);
  exit;
}
