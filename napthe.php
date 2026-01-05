<?php
$partner_id  = "PARTNER_ID_CỦA_BẠN";
$partner_key = "PARTNER_KEY_CỦA_BẠN";
$api_url     = "https://domain-api-nap-the.com/charging";

$telco  = $_POST['telco'] ?? '';
$amount = $_POST['amount'] ?? '';
$serial = $_POST['serial'] ?? '';
$pin    = $_POST['pin'] ?? '';

if (!$telco || !$amount || !$serial || !$pin) {
    die("Thiếu dữ liệu");
}

$request_id = time();

// ⚠️ CÔNG THỨC SIGN – chỉnh theo Postman của bạn
$sign = md5($partner_key . $pin . $serial);

$data = [
    'partner_id' => $partner_id,
    'request_id' => $request_id,
    'telco'      => $telco,
    'amount'     => $amount,
    'serial'     => $serial,
    'pin'        => $pin,
    'sign'       => $sign
];

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả nạp thẻ</title>
</head>
<body>

<h2>KẾT QUẢ NẠP THẺ</h2>

<pre><?php print_r($result); ?></pre>

<a href="index.html">← Quay lại</a>

</body>
</html>