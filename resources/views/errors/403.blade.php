@extends('errors.layout')

@section('title', app()->getLocale() === 'ar' ? 'غير مصرح بالوصول' : 'Access Denied')
@section('code', '403')
@section('heading', app()->getLocale() === 'ar' ? 'ليس لديك صلاحية للوصول إلى هذا القسم' : 'Access Forbidden')
@section('message', app()->getLocale() === 'ar' ? 'لا يملك حسابك الامتيازات الكافية لعرض هذه الصفحة أو تنفيذ هذا الإجراء. يرجى التواصل مع الإدارة.' : 'You do not have permission to access this resource or perform this action.')
