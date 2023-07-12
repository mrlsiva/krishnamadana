<div class="py-12">

    @if (Session::has('register'))
        <div class="bg-teal-100 w-96 mx-auto mb-4 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
            role="alert">
            <div class="flex">
                <div class="py-1">
                    <x-icons.info />
                </div>
                <div>
                    <p class="font-bold">Registration Successful.</p>
                    <p class="text-sm">Please login to continue.</p>
                </div>
            </div>
        </div>
    @endif

    @if (Session::has('loginError'))
        <div class="bg-red-100 w-96 mx-auto mb-4 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md"
            role="alert">
            <div class="flex">
                <div class="py-1 mr-4">
                    <x-icons.error-alt />
                </div>
                <div>
                    <p class="font-bold">Login Failed</p>
                    <p class="text-sm">The email or password you entered is not correct. Please enter your correct
                        credentials.</p>
                </div>
            </div>
        </div>
    @endif

    <form class="flex flex-col items-center justify-center" wire:submit.prevent="login">
        @csrf
        <h2 class="uppercase text-2xl tracking-widest">Login</h2>
        <p class="my-4 text-gray-700">Please enter your e-mail and password</p>
        <div class="mb-4">
            <input type="email" class="peer input w-96" placeholder="Email" name="email"
                wire:model.defer="email" />
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-8">
            <input type="password" class="peer input w-96" placeholder="Password" name="password"
                wire:model.defer="password" />
            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button class="cta-link mb-4 w-96 py-3">LOGIN</button>
        <p class="mt-4">Don't have an account? <a href="{{ route('home.register') }}">Create One</a></p>
    </form>
</div>
