@extends('public.base')

@section('title')
    - Shop Online for Latest
@endsection

@section('main')
    <x-public.home.carousel />
    <livewire:public.home.show-categories />
    <livewire:public.home.best-sellers />
    <x-public.home.banner />
    <x-public.home.our-promises />
@endsection
