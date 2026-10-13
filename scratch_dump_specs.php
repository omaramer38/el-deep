<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$p = \App\Models\Project::find(1);
echo "=== Project 1 Specifications ===\n";
var_dump($p->specifications);

$e = \App\Models\Elevator::first();
echo "\n=== First Elevator Specifications ===\n";
var_dump($e?->specifications);
