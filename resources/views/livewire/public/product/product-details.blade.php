<div class="flex w-full md:w-10/12 mx-auto my-4">
    <div class="flex-1 flex flex-col">
        <div class="swiper product-swiper">
            <div class="swiper-wrapper">
                @foreach ($product->media as $media)
                    <img src="{{ $media->original_url }}" alt="{{ $product->name }}" class="swiper-slide" />
                @endforeach
            </div>
        </div>
        <div class="flex mt-4 items-center justify-center flex-wrap">
            @foreach ($product->media as $media)
                <img class="w-32 h-32 object-cover ms-4" src="{{ $media->original_url }}" alt="{{ $product->name }}" />
            @endforeach
        </div>
    </div>
    <div class="flex-1 px-4">
        <h2 class="text-2xl text-center text-slate-600">{{ $product->name }}</h2>
        <div class="text-slate-800">{!! $product->description !!}</div>
        <div class="flex flex-col">
            @foreach ($variations as $variation)
                <p class="">{{ $variation->name }}:</p>
                <div class="flex flex-wrap">
                    @foreach ($variation->options as $option)
                        <label class="px-4 py-2 border me-4">
                            {{ $option->value }}
                        </label>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper(".product-swiper", {
                loop: false,
                speed: 500,
                direction: "horizontal",
                autoplay: false,
                effect: "fade",
                fadeEffect: {
                    crossFade: true,
                },
                init: false,
            });
        });
    </script>
@endsection
