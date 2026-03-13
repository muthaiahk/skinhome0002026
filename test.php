<?php

$controller = app()->make('App\Http\Controllers\DashboardController');
$request = new \Illuminate\Http\Request();

echo "Customer Chart test:\n";
try {
    $res = $controller->customerChart($request);
    echo $res->getContent() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nTreatment Chart test:\n";
try {
    $res = $controller->treatmentChart($request);
    echo $res->getContent() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
