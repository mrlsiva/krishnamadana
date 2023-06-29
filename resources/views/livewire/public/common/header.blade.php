<div class="flex flex-col">
    <div class="flex my-4 w-full items-center">
        <div class="flex-1"></div>
        <div class="logo mb-2">
            <a href="{{ route('home') }}"><img src="/images/logo.png" alt=""></a>
        </div>
        <div class="flex-1">
            <nav class="flex justify-end mx-8">
                <a href="" class="px-4">Account</a>
                <a href="" class="px-4">Search</a>
                <a href="{{ route('home.cart') }}" class="px-4">Cart ({{ Cart::getTotalQuantity() }})</a>
            </nav>
        </div>
    </div>
    <div class="flex w-full border-b pb-4">
        <nav class="w-full">
            <ul class="flex items-center justify-center w-full">
                <li><a href="{{ route('home') }}" class="p-4 nav-link">Home</a></li>
                <li class="relative" x-data="{ open: false }" @mouseover.away="open=false">
                    <a href="" class="p-4 nav-link" @mouseover="open=true">Shop</a>
                    <ul class="dropdown-menu shop-menu" x-show="open">
                        <a href="">Shop All</a>
                        <a href="">Kurta Sets</a>
                        <a href="">Saree All</a>
                        <a href="">Blouses</a>
                    </ul>
                </li>
                {{-- <li class="relative" x-data="{ open: false }" @mouseover.away="open=false">
                    <a href="" class="p-4 nav-link" @mouseover="open=true">Collections</a>
                    <ul class="dropdown-menu collections-menu" x-show="open">
                        <a href="">Shop All</a>
                        <a href="">Marigold</a>
                        <a href="">Ikara</a>
                    </ul>
                </li>
                <li><a href="" class="p-4 nav-link">Sale</a></li> --}}
                <li><a href="" class="p-4 nav-link">About Us</a></li>
                <li><a href="" class="p-4 nav-link">Contact Us</a></li>
            </ul>
        </nav>
    </div>
</div>
