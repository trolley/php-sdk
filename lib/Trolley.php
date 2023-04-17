<?php

/**
 * Trolley PHP SDK
 * Creates class_aliases for old class names replaced by PSR-4 Namespaces
 */

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'autoload.php');

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    throw new Trolley_Exception('PHP version >= 5.4.0 required');
}

class Trolley {
    public static function requireDependencies() {
        $requiredExtensions = ['xmlwriter', 'openssl', 'dom', 'hash', 'curl'];
        foreach ($requiredExtensions AS $ext) {
            if (!extension_loaded($ext)) {
                throw new Trolley_Exception('The Trolley SDK requires the ' . $ext . ' extension.');
            }
        }
    }
}
Trolley::requireDependencies();
