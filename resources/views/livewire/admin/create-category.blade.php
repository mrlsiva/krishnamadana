<div class="">
    <div class="section-header mb-4">
        Create Category
    </div>
    <form wire:submit.prevent="save">
        @csrf
        <div class="flex">
            <div class="relative mb-4 flex-1">
                <label for="categoryname" class="label">Category Name<span class="field-required">*</span></label>
                <input name="name" id="categoryname" type="text" class="peer input"
                    placeholder="Enter category name" wire:model="name" />
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="relative mb-4 flex-1 ml-5">
                <label for="order" class="label">Category Display Order</label>
                <input name="order" id="order" type="number" class="peer input"
                    placeholder="Enter category display order" wire:model="order" />
                @error('order')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <label for="categoryname" class="label">Category Image<span class="field-required">*</span></label>
        @if ($image)
            <div class="flex flex-col mb-4">
                <img src="{{ $image->temporaryUrl() }}" class="w-[200px] h-auto">
                <div class="flex mt-2">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 w-[200px]"
                        wire:click="remove_image">Remove Image</button>
                </div>
            </div>
        @else
            <div class="relative mb-4" x-data="{}">
                <div class="w-full h-40 border border-dashed flex flex-col items-center justify-center cursor-pointer">
                    <button type="button" @click="$refs.image.click()">
                        <div class="h-24 w-24 text-slate-600">
                            <x-icons.upload />
                        </div>
                    </button>
                    <p class="font-semibold text-md text-slate-600">Click to upload</p>
                </div>
                <input name="image" id="image" type="file" class="hidden" x-ref="image" wire:model="image" />
            </div>
        @endif
        <div class="flex">
            <label>
                <input type="checkbox" class="mr-2" wire:model="isResponsive" value="yes" /> Create reponsive
                images
            </label>
        </div>
        @error('image')
            <span class="error">{{ $message }}</span>
        @enderror
        <div class="flex mt-4">
            <button class="primary-button" wire:target="save" wire:loading.attr="disabled">Add
                Category</button>
        </div>
    </form>
</div>
