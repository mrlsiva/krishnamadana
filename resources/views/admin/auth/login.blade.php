@extends('admin.base')

@section('title') Admin Login @endsection

@section('body')
    <section class="h-screen h-full flex items-center justify-center">
        <div class="border rounded-lg shadow p-8 m-4 w-full md:w-1/3">
            <h1 class="mb-8 text-center font-bold text-2xl">Login</h1>
            @if ($errors->any())
                <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-red-400 flex">
                    <span class="text-xl inline-block mr-5 align-middle">
                        <i class="fas fa-bell"></i>
                    </span>
                    <ul class="inline-block align-top mr-8">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="post">
                @csrf
                <div class="relative mb-4">
                    <label for="username" class="font-semibold block mb-2 text-slate-800">Username</label>
                    <input name="username" id="username" type="text" class="peer w-full py-3 border px-2 rounded"
                        placeholder="Enter username" value="{{ old('username') }}" required />
                </div>
                <div class="relative">
                    <label for="password" class="font-semibold block mb-2 text-slate-800">Password</label>
                    <input name="password" id="password" type="password" class="peer w-full py-3 border px-2 rounded"
                        placeholder="Enter password" required />
                </div>
                <button class="primary mt-8 text-center w-full bg-primary text-on-primary py-4">Login</button>
            </form>
        </div>
    </section>
@section('body')
