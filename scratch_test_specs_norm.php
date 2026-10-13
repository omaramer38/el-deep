<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

function normalizeSpecs($rawSpecs) {
    if (is_string($rawSpecs)) {
        $rawSpecs = json_decode($rawSpecs, true) ?: [];
    }
    $rawSpecs = is_array($rawSpecs) ? $rawSpecs : [];

    $arSpecs = [];
    $enSpecs = [];

    if (isset($rawSpecs['ar']) || isset($rawSpecs['en'])) {
        $arSpecs = is_array($rawSpecs['ar'] ?? null) ? $rawSpecs['ar'] : [];
        $enSpecs = is_array($rawSpecs['en'] ?? null) ? $rawSpecs['en'] : [];
    } else {
        $enSpecs = $rawSpecs;
        $dictionary = [
            'Payload Capacity' => 'سعة الحمولة',
            'Rated Capacity' => 'سعة الحمولة المقدرة',
            'Rated Speed' => 'سرعة المصعد',
            'Max Travel Height' => 'أقصى ارتفاع حركة',
            'Cabin Finish' => 'تشطيب الكابينة',
            'Control System' => 'نظام التحكم',
            'Stops' => 'عدد المحطات',
        ];
        foreach ($rawSpecs as $k => $v) {
            $arKey = $dictionary[$k] ?? $k;
            $arSpecs[$arKey] = $v;
        }
    }

    $compiledSpecs = [];
    $arKeys = array_keys($arSpecs);
    $enKeys = array_keys($enSpecs);
    $maxCount = max(count($arKeys), count($enKeys));

    for ($i = 0; $i < $maxCount; $i++) {
        $kAr = $arKeys[$i] ?? '';
        $vAr = $kAr !== '' ? ($arSpecs[$kAr] ?? '') : '';
        $kEn = $enKeys[$i] ?? '';
        $vEn = $kEn !== '' ? ($enSpecs[$kEn] ?? '') : '';
        $compiledSpecs[] = [
            'key_ar' => $kAr,
            'val_ar' => $vAr,
            'key_en' => $kEn,
            'val_en' => $vEn,
        ];
    }

    if (empty($compiledSpecs)) {
        $compiledSpecs = [
            ['key_ar' => '', 'val_ar' => '', 'key_en' => '', 'val_en' => '']
        ];
    }

    return $compiledSpecs;
}

$p = \App\Models\Project::find(1);
echo "Project 1 specs normalized:\n";
print_r(normalizeSpecs($p->specifications));

$e = \App\Models\Elevator::first();
echo "\nElevator 1 specs normalized:\n";
print_r(normalizeSpecs($e->specifications));
