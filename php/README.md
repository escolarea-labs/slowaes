# PHP Howto

Encryption and decryption howto for PHP (in comparsion with openssl functions). 

## Encryption

```php

/**
 * Encrypts data
 * @link http://php.net/manual/en/function.openssl-encrypt.php
 * @param string $data The data
 * @param string $method The cipher method.
 * @param string $password The password.
 * @param int $options [optional] Setting to true will return as raw output data, otherwise the return value is base64 encoded.
 * @param string $iv [optional] A non-NULL Initialization Vector.
 * @return string the encrypted string on success or false on failure.
 * @since 5.3.0
 */
function openssl_encrypt($data, $method, $password, $options = 0, $iv = "")

/*
 * Mode of Operation Encryption
 * bytesIn - Input String as array of bytes
 * mode - mode of type modeOfOperation
 * key - a number array of length 'size'
 * size - the bit length of the key
 * iv - the 128 bit number array Initialization Vector
 */
public static function encrypt($bytesIn, $mode, $key, $size, $iv){

```
### OpenSSL
So, let's consider AES256, CBC mode. Then, the code will be: 

```php
$key = "32 characters long encryption key";
$iv = "16 characters long random vector";
$data = "Data to encrypt";

$result = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);

var_dump($result); // base64 encoded output
```

### SlowAES
From the other way, SlowAES does same thing without OpenSSL instaled, in pure PHP. Difference is in 

```php

include "............."; // aes_slow.php, cryptoHelpers.php or composer autoloader

$key = cryptoHelpers::convertStringToByteArray("32 characters long encryption key");
$iv = cryptoHelpers::convertStringToByteArray("16 characters long random vector");
$data = cryptoHelpers::convertStringToByteArray("Data to encrypt");

$result = AES::encrypt($data, AES::modeOfOperation_CBC, $key, count($key), $iv);

var_dump($result); // contains array with results..
// to get base64 string, we need to go deeper
$result = cryptoHelpers::convertByteArrayToString($resultArr['cipher']); // get encoded data
$result = base64_encode($result); // now, we have base64 data
```

## Decryption

Decryption of data is similar, look into tests directory. To decrypt with SlowAES (in cbc mode), you have to pass length of original data. 

```php
/** params are adequate to encryption function */
function openssl_decrypt($data, $method, $password, $options = 1, $iv = "");

/*
 * Mode of Operation Decryption
 * cipherIn - Encrypted String as array of bytes
 * originalsize - The unencrypted string length - required for CBC
 * mode - mode of type modeOfOperation
 * key - a number array of length 'size'
 * size - the bit length of the key
 * iv - the 128 bit number array Initialization Vector
 */
public static function decrypt($cipherIn,$originalsize,$mode,$key,$size,$iv)

```
