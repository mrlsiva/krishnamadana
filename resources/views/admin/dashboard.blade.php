@extends('admin.base')

@section('title')
    Dashboard
@endsection

@section('body')
    <div class="flex">
        <nav class="main-nav">
            <ul>
                <li>
                    <a href="" class="text-center flex flex-col items-center justify-center active">
                        <x-icons.store /> <span>Store</span>
                    </a>
                </li>
            </ul>
        </nav>
        <nav class="secondary-nav">
            <ul>
                <li>
                    <a href="">Products</a>
                </li>
                <li>
                    <a href="{{ route('admin.createProduct') }}" class="@isLinkActive('admin.createProduct')">Create
                        Product</a>
                </li>
                <li>
                    <a href="">Categories</a>
                </li>
                <li>
                    <a href="{{ route('admin.createCategory') }}" class="@isLinkActive('admin.createCategory')">Create
                        Category</a>
                </li>
                <li>
                    <a href="">Collections</a>
                </li>
                <li>
                    <a href="">Create Collection</a>
                </li>
            </ul>
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
