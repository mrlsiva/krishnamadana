<div class="grid grid-cols-4 gap-4 p-12">
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
            <h2 class="mt-2"><a href="{{ route('home.product-details', ['slug' => $product->slug]) }}">{{ $product->name }}</a></h2>
            <p class="price">Rs. {{ $product->display_price }}</p>
        </div>
    @endforeach	
</div>

<div class="w-full flex justify-center pb-6">
	{{ $products->links() }}
</div>
