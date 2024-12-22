<?php

require_once 'vendor/autoload.php';

// use Mpdf\Mpdf;

try {
    $mpdf = new \Mpdf\Mpdf();
    echo "MPDF is successfully loaded!";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
