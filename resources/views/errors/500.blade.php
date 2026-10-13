@extends('errors.layout')

@section('title', app()->getLocale() === 'ar' ? 'خطأ في الخادم' : 'Server Error')
@section('code', '500')
@section('heading', app()->getLocale() === 'ar' ? 'حدث خطأ غير متوقع في النظام' : 'Internal Server Error')
@section('message', app()->getLocale() === 'ar' ? 'نعتذر عن هذا الخطأ المؤقت، يعمل فريقنا الفني على معالجة المشكلة بأسرع وقت ممكن.' : 'We are experiencing an internal server issue. Our engineering team has been notified.')
