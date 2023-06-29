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
        @unless (empty($product->additional_info))
            <div class="mt-6">
                <div class="collapsible border-y w-full border-gray-700" x-data="{ expanded: false }">
                    <button class="py-8 text-gray-700 text-xl text-left w-full flex items-center justify-between"
                        @click="expanded = !expanded">
                        Additional Information
                        <div class="inline-block" x-show="!expanded">
                            <x-icons.plus />
                        </div>
                        <div class="inline-block" x-show="expanded">
                            <x-icons.minus />
                        </div>
                    </button>
                    <div class="pb-8" x-show="expanded" x-collapse>
                        {!! $product->additional_info !!}
                    </div>
                </div>
            </div>
        @endunless
    </div>
    <div class="flex-1 px-12">
        <h2 class="text-2xl text-center text-slate-600">{{ $product->name }}</h2>
        <div class="text-slate-800 my-4">{!! $product->description !!}</div>
        @foreach ($variations as $variation)
            <div class="flex flex-col mb-4">
                <p class="mb-4">{{ $variation->name }}:</p>
                <div class="flex flex-wrap gap-y-4">
                    @foreach ($variation->options as $option)
                        <input type="radio" name="{{ $variation->id }}" class="hidden variation-input"
                            id="option={{ $option->id }}" @checked($option_ids->contains($option->id))
                            wire:change="on_variant_change({{ $loop->parent->index }}, {{ $option->id }})">
                        <label for="option={{ $option->id }}"
                            class="px-4 py-2 border me-4 text-slate-600 cursor-pointer variation-label select-none">
                            {{ $option->value }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
        <div class="price border-t pt-4 text-2xl text-slate-600">Rs. {{ $selected_item->amount }}</div>
        <button type="button" class="cta-link w-full py-3 my-4" wire:click="add_to_cart" wire:target="add_to_cart"
            wire:loading.attr="disabled">
            Add to Cart
        </button>
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
