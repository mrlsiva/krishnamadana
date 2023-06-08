<div class="collections-grid mx-12 my-8">
    @foreach ($categories as $category)
        <div class="collection relative overflow-hidden">
            <img src="{{ $category->media[0]->original_url }}" class="w-full" alt="">
            <div class="collection__content">
                <h2>{{ $category->name }}</h2>
                <a href="{{ route('home.collections', ['collection' => 'kurta-sets']) }}" class="primary-link">Shop
                    Now</a>
            </div>
        </div>
    @endforeach
    {{-- <div class="collection relative overflow-hidden">
        <img src="/images/home/collection-2.jpg" class="w-full" alt="">
        <div class="collection__content">
            <h2>Blouses</h2>
            <a href="" class="primary-link">Shop Now</a>
        </div>
    </div>
    <div class="collection relative overflow-hidden">
        <img src="/images/home/collection-3.jpg" class="w-full" alt="">
        <div class="collection__content">
            <h2>Lehangas</h2>
            <a href="" class="primary-link">Shop Now</a>
        </div>
    </div>
    <div class="collection relative overflow-hidden">
        <img src="/images/home/collection-4.jpg" class="w-full" alt="">
        <div class="collection__content">
            <h2>Men's Kurta</h2>
            <a href="" class="primary-link">Shop Now</a>
        </div>
    </div>
    <div class="collection relative overflow-hidden">
        <img src="/images/home/collection-5.jpg" class="w-full" alt="">
        <div class="collection__content">
            <h2>Dresses</h2>
            <a href="" class="primary-link">Shop Now</a>
        </div>
    </div>
    <div class="collection relative overflow-hidden">
        <img src="/images/home/collection-6.jpg" class="w-full" alt="">
        <div class="collection__content">
            <h2>Sarees</h2>
            <a href="" class="primary-link">Shop Now</a>
        </div>
    </div> --}}
</div>
