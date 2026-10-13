<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$article = App\Models\Article::find(1);

$route = Route::getRoutes()->getByName('site.blog.show');
echo "Route URI: " . $route->uri() . PHP_EOL;
echo "Route parameterNames: " . json_encode($route->parameterNames()) . PHP_EOL;

// Let's test with various inputs to see what throws Missing required parameter: slug
$tests = [
    ['locale' => 'en', 'slug' => 'future'],
    ['locale' => 'ar', 'slug' => 'future'],
    ['locale' => 'en', 'slug' => null],
    ['locale' => 'en', 'slug' => ''],
    ['locale' => '', 'slug' => 'future'],
    ['locale' => null, 'slug' => 'future'],
    ['locale' => 'en_US', 'slug' => 'future'],
    ['locale' => 'en'],
];

foreach ($tests as $i => $params) {
    try {
        $url = route('site.blog.show', $params);
        echo "Test $i passed: $url" . PHP_EOL;
    } catch (\Throwable $e) {
        echo "Test $i FAILED with params " . json_encode($params) . ": " . $e->getMessage() . PHP_EOL;
    }
}
