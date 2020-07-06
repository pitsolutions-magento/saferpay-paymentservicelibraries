<?php
$classIncl = new \Magento\Framework\Code\Generator\Io(new \Magento\Framework\Filesystem\Driver\File());
if (defined('VENDOR_PATH')) {
    $vendorDir = $classIncl->includeFile(VENDOR_PATH);
} else {
    $vendorDir = $classIncl->includeFile( __DIR__ . '/../../../../app/etc/vendor_path.php');
} 
$vendorAutoload = __DIR__ . "/../../../../{$vendorDir}/autoload.php";

if (file_exists($vendorAutoload)) {

    $composerAutoloader = $classIncl->includeFile($vendorAutoload);
    $libDirectory = dirname(dirname(__DIR__));
    // set the Lib folder path to saferpay nameSpace in Composer Auto loader
    $composerAutoloader->set('Saferpay', $libDirectory);
}else {
    throw new \Exception(
        'Vendor autoload is not found. Please run \'composer install\' under application root directory.'
    );
}
