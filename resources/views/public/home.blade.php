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
	<x-public.home.insta-feeds />
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript">
	  var instaAccessToken = '{{ config("app.insta_access_token") }}';
	</script>
	<script src="{{asset('/assets/js/jquery-feed-instagram-graph.js')}}"></script> 
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
