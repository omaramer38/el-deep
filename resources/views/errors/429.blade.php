@extends('errors.layout')

@section('title', app()->getLocale() === 'ar' ? 'عدد طلبات زائد' : 'Too Many Requests')
@section('code', '429')
@section('heading', app()->getLocale() === 'ar' ? 'تم تجاوز الحد المسموح من الطلبات' : 'Too Many Requests')
@section('message', app()->getLocale() === 'ar' ? 'تم إرسال عدد كبير من الطلبات خلال فترة وجيزة لحماية أمان السيرفر. يرجى الانتظار لمدة دقيقة والمحاولة مرة أخرى.' : 'You have sent too many requests in a short period of time. Please wait a minute before trying again.')
