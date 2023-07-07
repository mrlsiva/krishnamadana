<div class="py-12">
    <form class="flex flex-col items-center justify-center" wire:submit.prevent="submit">
        <h2 class="uppercase text-2xl tracking-widest">Register</h2>
        <p class="my-4 text-gray-700">Please fill in the information below</p>
        <div class="mb-4">
            <input type="text" class="peer input w-96" placeholder="Name" name="name" wire:model.defer="user.name" />
            @error('user.name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <input type="text" class="peer input w-96" placeholder="Email" name="email"
                wire:model.defer="user.email" />
            @error('user.email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <input type="tel" class="peer input w-96" placeholder="Mobile" maxlength="10" name="mobile"
                wire:model.defer="user.mobile" />
            @error('user.mobile')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <input type="password" class="peer input w-96" placeholder="Password" name="password"
                wire:model.defer="password" />
            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-8">
            <input type="password" class="peer input w-96" placeholder="Confirm Password" name="confirm_password"
                wire:model.defer="confirm_password" />
            @error('confirm_password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button class="cta-link mb-4 w-96 py-3">Create My Account</button>
        <p class="mt-4">Already registered? <a href="{{ route('home.login') }}">Login Now</a></p>
    </form>
</div>
