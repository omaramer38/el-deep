@extends('errors.layout')

@section('title', app()->getLocale() === 'ar' ? 'انتهت صلاحية الجلسة' : 'Page Expired')
@section('code', '419')
@section('heading', app()->getLocale() === 'ar' ? 'انتهت صلاحية الصفحة أو الجلسة' : 'Page Session Expired')
@section('message', app()->getLocale() === 'ar' ? 'لحماية أمان بياناتك، انتهت صلاحية الرمز الأمني للصفحة. يرجى إعادة تحميل الصفحة والمحاولة مجدداً.' : 'Your session has expired due to inactivity. Please refresh the page and try again.')
