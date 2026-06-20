<?php

// Memaksa Laravel memindahkan semua folder penulisan cache ke folder /tmp bawaan Vercel
$storagePath = '/tmp/storage/bootstrap/cache';
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
}

putenv("VAPOR_ARTIFACT_NAME=laravel-app");
putenv("VIEW_COMPILED_PATH=/tmp/storage/framework/views");
putenv("SESSION_DRIVER=cookie");
putenv("LOG_CHANNEL=stderr");
putenv("CACHE_STORE=array");

// Membuat folder untuk framework views agar tidak memicu error missing directory
if (!is_dir('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0755, true);
}

// Jalankan aplikasi Laravel standar menuju folder public
require __DIR__ . '/../public/index.php';
