<div class="collections-grid mx-12 my-8">
    @foreach ($categories as $category)
        <div class="collection relative overflow-hidden">
            <img src="{{ $category->media[0]->original_url }}" class="w-full" alt="">
            <div class="collection__content">
                <h2>{{ $category->name }}</h2>
                <a href="{{ route('home.collections', ['slug' => $category->slug]) }}" class="primary-link">Shop
                    Now</a>
            </div>
        </div>
    @endforeach
</div>
