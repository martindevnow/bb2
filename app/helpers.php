<?php

function getExtensionFromString($str) {
    $parts = explode('.', $str);
    return $parts[count($parts) - 1];
}