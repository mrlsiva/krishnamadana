<div>
    <div class="filterToolbar flex w-full border-b">
        <div class="sort-item product pt-2 pb-2 px-4">
            <select name="sortBy" class="chosen" wire:model="sortBy">
                <!-- <option value="default">Sort</option>
                <option value="heigh">Featured</option> -->
                <option value="latest" selected="selected">Date - New To Old</option>
                <option value="oldest">Date - Old To New </option>  
                <option value="a-z">Name - A-Z</option>
                <option value="z-a">Name - Z-A</option>                             
                <option value="low">Price - Low To High</option>
                <option value="heigh">Price - High To Low</option>
            </select>
        </div>       
        {{--
        @foreach ($this->categories as $category)
            <div class="flex items-center space-x-4 mb-2" wire:key="{{ $category->id }}">
                <input type="checkbox" id="{{ $category->name }}" name="{{ $category->name }}"
                    wire:model="filters.categories.{{ $category->id }}" />
                <label for="{{ $category->name }}">{{ $category->name }}</label>
            </div>
        @endforeach --}}
        <!-- <div class="sort-item product">
            <select name="perPage" class="use-chosen" wire:model="perPage">
                <option value="1" selected="selected">1 per page</option>
                <option value="2">2 per page</option>
                <option value="9">9 per page</option>
                <option value="12">12 per page</option>
                <option value="18">18 per page</option>
                <option value="21">21 per page</option>
                <option value="24">24 per page</option>
            </select>
        </div> -->
    </div> 
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
</div>
