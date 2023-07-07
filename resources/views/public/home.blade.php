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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper(".swiper", {
                loop: true,
                speed: 500,
                direction: "horizontal",
                autoplay: {
                    delay: 3000,
                },
                effect: "fade",
                fadeEffect: {
                    crossFade: true,
                },
                init: true,
            });
        });
    </script>
@endsection
