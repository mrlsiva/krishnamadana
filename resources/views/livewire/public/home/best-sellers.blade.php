<div class="flex flex-col best-sellers">
    <h2 class="text-center text-2xl font-semibold">Best Sellers</h2>
    <div class="grid grid-cols-4 gap-8 mx-4 my-8">
        @foreach ($products as $product)
            <div class="flex flex-col text-center">
                <a href="{{ route('home.product-details', ['slug' => $product->slug]) }}" class="product__images__link">
                    <div class="relative product__images">
                        @foreach ($product->media->slice(0, 2) as $image)
                            <img src="{{ $image->original_url }}"
                                class="@if ($loop->first) front-image @else back-image @endif"
                                alt="{{ $product->name }}">
                        @endforeach
                    </div>
                </a>
                <h2 class="mt-2"><a href="">{{ $product->name }}</a></h2>
                <p class="price">Rs. {{ $product->display_price }}</p>
            </div>
        @endforeach
    </div>
    <a href="" class="cta-link mx-auto p-4">View All BestSellers</a>
</div>
