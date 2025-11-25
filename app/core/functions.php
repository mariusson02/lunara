<?php

// nice helper functions oder so

function esc($str): string
{
    return htmlspecialchars($str);
}

function redirect($path): void
{
    header("Location: " . ROOT.$path, true);
    exit;
}

function sanitize($data): string
{
    return htmlspecialchars(strip_tags(trim($data)));
}

function parseTimestamp($timestamp) : string {
    return date('d.m.Y H:i', strtotime($timestamp));
}

function maskWalletAddress($address) {
    $visibleChars = 5;

    if (strlen($address) <= $visibleChars) {
        return $address;
    }

    $start = substr($address, 0, strlen($address) - $visibleChars);
    $end = substr($address, -$visibleChars);

    $maskedStart = str_repeat('*', min(strlen($start), 25));

    return $maskedStart . $end;
}
