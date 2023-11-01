<?php

/*
 * Here there will be made some constants which not need to be altered.
 * These contants will hold information about database connection, JWT secret key
 * And it will hold information for encrypting and decrypting data with openssl
 * library, and as the last thing it will also hold a secret key for hashing password.
 */

// Here we have the database information
define("DB_HOST", "localhost");
define("DB_USER", "jp_pro_dk");
define("DB_PASS", "ma1701");
define("DB_NAME", "jp_pro_dk");

// Here we have the openssl information
define('OPENSSL_CIPHERING', 'AES-128-CTR');
define('OPENSSL_OPTIONS', '0');
define('OPENSSL_ENCRYP_KEY', 'CodeBase4All');
define('OPENSSL_ENCRYPT_IV', '1234567891011121');
define('OPENSSL_IV_LENGTH', openssl_cipher_iv_length(OPENSSL_CIPHERING));

// Here we have the secret Key for JWT
define("JWT_SECRET_KEY", "Code20base23");

// Here we have the secret key for password hashing
define("HASH_PASS_SECRET_KEY", "Codebase2023Isgreat4all");