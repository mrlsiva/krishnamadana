@extends('admin.base')

@section('title')
    Dashboard
@endsection

@section('body')
    <div class="flex">
        <nav class="main-nav">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.store.productList') }}" class="text-center flex flex-col items-center justify-center @if(Route::is('admin.store.*')) active @endif">
                        <x-icons.store /> <span>Store</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.order.list') }}" class="text-center flex flex-col items-center justify-center @if(Route::is('admin.order.*')) active @endif">
                        <x-icons.store /> <span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.user.list') }}" class="text-center flex flex-col items-center justify-center @if(Route::is('admin.user.*')) active @endif">
                        <x-icons.store /> <span>Users</span>
                    </a>
                </li>
            </ul>
        </nav>
        <nav class="secondary-nav">
            @if(Route::is('admin.store.*'))
            <ul>
                <li>
                    <a href="{{ route('admin.store.productList') }}" class="@isLinkActive('admin.store.productList')">Products</a>
                </li>
                <li>
                    <a href="{{ route('admin.store.createProduct') }}" class="@isLinkActive('admin.store.createProduct')">Create
                        Product</a>
                </li>
                <li>
                    <a href="{{ route('admin.store.categoryList') }}" class="@isLinkActive('admin.store.categoryList')">Categories</a>
                </li>
                <li>
                    <a href="{{ route('admin.store.createCategory') }}" class="@isLinkActive('admin.store.createCategory')">Create
                        Category</a>
                </li>
                {{-- <li>
                    <a href="">Collections</a>
                </li>
                <li>
                    <a href="">Create Collection</a>
                </li> --}}
                <li>
                    <a href="{{ route('admin.store.createProductVariation') }}" class="@isLinkActive('admin.store.createProductVariation')">Product Variations</a>
                </li>
                <li>
                    <a href="{{ route('admin.store.createVariationOption') }}" class="@isLinkActive('admin.store.createVariationOption')">Variation Options</a>
                </li>
            </ul>
            @endif
            @if(Route::is('admin.user.*'))
            <ul>
                <li>
                    <a href="{{ route('admin.user.list') }}" class="@isLinkActive('admin.user.list')">User List</a>
                    <a href="{{ route('admin.user.create') }}" class="@isLinkActive('admin.user.create')">Create User</a>
                </li>
            </ul>
            @endif
            @if(Route::is('admin.order.*'))
            <ul>
                <li>
                    <a href="{{ route('admin.order.list') }}" class="@isLinkActive('admin.order.list')">Order List</a>
                </li>
            </ul>
            @endif
        </nav>
        <div class="page-content flex-1">
            <div class="header">
                <a href="">
                    <x-icons.menu />
                </a>
            </div>
            <section class="section-content flex-1 p-4">
                @yield('section')
            </section>
        </div>
    </div>
@endsection
