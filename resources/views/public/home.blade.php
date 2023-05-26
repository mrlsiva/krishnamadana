@extends('public.base')

@section('title')
    - Shop Online for Latest
@endsection

@section('body')
    <x-public.common.announcement />
    <x-public.common.header />
    <x-public.home.carousel />
    <x-public.home.collections />
    <x-public.home.best-sellers />
@endsection
