<?php

$privateKeyPath = __DIR__ . '/config/jwt/private.pem'; // ajuste o caminho se precisar
$passphrase = 'nZ7!tR4#qLp9@Vx2';

// Lê o conteúdo da chave privada
$privateKeyContent = file_get_contents($privateKeyPath);

if ($privateKeyContent === false) {
    die("Erro ao ler o arquivo da chave privada.\n");
}

// Tenta carregar a chave privada com a passphrase
$privateKey = openssl_pkey_get_private($privateKeyContent, $passphrase);

if ($privateKey === false) {
    echo "Falha ao carregar a chave privada. A passphrase pode estar incorreta ou a chave está inválida.\n";
    while ($msg = openssl_error_string()) {
        echo "OpenSSL Error: $msg\n";
    }
} else {
    echo "Chave privada carregada com sucesso!\n";
    openssl_pkey_free($privateKey);
}
