@extends('admin.base')

@section('title')
    Dashboard
@endsection

@section('body')
    <div class="flex">
        <nav class="main-nav">
            <ul>
                <li>
                    <a href="" class="text-center flex flex-col items-center justify-center">
                        <x-icons.store /> <span>Store</span>
                    </a>
                </li>
            </ul>
        </nav>
        <nav class="secondary-nav">
            <ul>
                <li>
                    <a href="">Products</a>
                    <a href="">Categories</a>
                    <a href="">Collections</a>
                </li>
            </ul>
        </nav>
        <div class="page-content flex-1">
            <div class="header">
                <a href="">
                    <x-icons.menu />
                </a>
            </div>
            @yield('pagecontent')
        </div>
    </div>
@endsection
