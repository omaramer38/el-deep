@extends('errors.layout')

@section('title', app()->getLocale() === 'ar' ? 'الصفحة غير موجودة' : 'Page Not Found')
@section('code', '404')
@section('heading', app()->getLocale() === 'ar' ? 'عذراً، الصفحة التي تبحث عنها غير موجودة' : 'Page Not Found')
@section('message', app()->getLocale() === 'ar' ? 'ربما تم نقل الصفحة، أو تم حذفها، أو أن الرابط الذي اتبعته غير صحيح.' : 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.')
