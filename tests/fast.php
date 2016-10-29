<?php

include __DIR__ .  "/../php/aes_fast.php";
include __DIR__ . "/../php/cryptoHelpers.php";

// generate key
$keyArr = cryptoHelpers::generateSharedKey(32); // AES-256-CBC
$key = cryptoHelpers::convertByteArrayToString($keyArr);

// random vector
$ivArr = cryptoHelpers::generateSharedKey(16);
$iv = cryptoHelpers::convertByteArrayToString($ivArr);


$toEncrypt = "HELLO";
$toEncryptArr = cryptoHelpers::convertStringToByteArray($toEncrypt);


$resultArr = AES::encrypt($toEncryptArr, AES::modeOfOperation_CBC, $keyArr, 32, $ivArr);
$result = cryptoHelpers::convertByteArrayToString($resultArr['cipher']);

$outputCH = base64_encode($result);
$outputOSSL = openssl_encrypt($toEncrypt, 'aes-256-cbc', $key, 0, $iv);

if ($outputCH <> $outputOSSL){
	echo "SlowAES:\n";
	var_dump($outputCH);
	echo "OpenSSL:\n";
	var_dump($outputOSSL);
	die("Outputs of encryption differs. Sorry");
}

// ecrypted data to decrypt
$encrypted = $outputOSSL;
$encrypted = cryptoHelpers::convertStringToByteArray(base64_decode($encrypted));

$res = AES::decrypt($encrypted, strlen($toEncrypt), AES::modeOfOperation_CBC, $keyArr, 32, $ivArr);
$res = cryptoHelpers::convertByteArrayToString($res);

if ($res <> $toEncrypt){
	echo "Original:\n";
	var_dump($toEncrypt);
	echo "Decrypted:\n";
	var_dump($res);
	die("Decrypted string differs from original");
}
