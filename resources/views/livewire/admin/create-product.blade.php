<div class="">
    <div class="section-header">
        Create Product
    </div>
    <form wire:submit.prevent="save">
        <div class="flex p-4">
            <div class="flex flex-col basis-3/4 mr-4">
                <div class="bg-white shadow-lg p-4 mb-8">
                    <div class="relative mb-4">
                        <label for="categoryname" class="label">Product Title</label>
                        <input name="name" id="categoryname" type="text" class="peer input"
                            placeholder="Enter category name" wire:model="title" required />
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative mb-4">
                        <label for="categoryname" class="label">Product Description</label>
                        <input name="description" id="categoryname" type="text" class="peer input"
                            placeholder="Enter category name" wire:model="title" required />
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="bg-white shadow-lg p-4 mb-4">
                    <h2 class="text-slate-600 border-b pb-2 mb-4 font-semibold text-lg">Product Gallery</h2>
                    @if (sizeof($uploads) > 0)
                        <div class="flex flex-wrap">
                            @foreach ($uploads as $i => $upl)
                                <div class="flex flex-col relative mx-2 my-4">
                                    <img src="{{ $upl['src'] }}" alt=""
                                        class="w-[200px] h-[200px] object-cover">
                                    {{-- <div style="width: 200px;" class="overflow-hidden text-ellipsis">
                                        {{ $upl['fileName'] }}
                                    </div> --}}
                                    @if ($upl['progress'] < 100)
                                        <div
                                            class="absolute inset-0 backdrop w-full h-full bg-slate-700/40 flex items-center justify-center">
                                            <p class="text-white">Uploading...</p>
                                        </div>
                                    @endif
                                    <button class="bg-red-600 text-white px-4 py-2">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="relative mb-4" x-data="{}">
                        <label for="images" class="label">Product Images</label>
                        <div
                            class="w-full h-40 border border-dashed flex flex-col items-center justify-center cursor-pointer">
                            <button type="button" @click="$refs.image.click()">
                                <div class="h-24 w-24 text-slate-600">
                                    <x-icons.upload />
                                </div>
                            </button>
                            <p class="font-semibold text-md text-slate-600">Drop files here or click to upload</p>
                        </div>
                        <input name="images" id="images" type="file" class="hidden" x-ref="image" multiple />
                    </div>
                </div>
                <div class="bg-white shadow-lg p-4 mb-4" x-data="{ currentTab: 'sku' }">
                    <h2 class="text-slate-600 border-b pb-2 mb-4 font-semibold text-lg">Product SKU</h2>
                    <div class="tabs border-b">
                        <button type="button" class="pb-4 mr-4 text-blue-500" @click="currentTab = 'sku'"
                            :class="currentTab == 'sku' ? 'border-b border-blue-500' : ''">Add SKU</button>
                        <button type="button" class="pb-4 text-blue-500" @click="currentTab = 'variant'"
                            :class="currentTab == 'variant' ? 'border-b border-blue-500' : ''">Add Variant</button>
                    </div>
                    <div class="tab-content pt-4" x-show="currentTab == 'sku'">
                        <div class="border border-dashed p-4 mb-4">
                            <p class="text-center text-gray-600">No SKU added.</p>
                        </div>
                        <button type="button" class="bg-orange-500 px-4 py-2 rounded text-white">Create New
                            SKU</button>
                        <div class="relative mb-4">
                            <label for="categoryname" class="label">Product SKU</label>
                            <input name="description" id="categoryname" type="text" class="peer input"
                                placeholder="Enter category name" wire:model="title" required />
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="tab-content pt-4" x-show="currentTab == 'variant'">
                        <div class="border border-dashed p-4 mb-4">
                            <p class="text-center text-gray-600">No Variants added.</p>
                        </div>
                        <div class="relative mb-4">
                            <label for="categoryname" class="label">Add New Variant</label>
                            <input name="description" id="categoryname" type="text" class="peer input"
                                placeholder="Enter variant name. (eg. Size, Color)" wire:model="title"
                                wire:model="variant_name" />
                        </div>
                        <button type="button" class="bg-orange-500 px-4 py-2 rounded text-white"
                            wire:click="create_variant">Add Variant</button>
                        <button type="button" class="bg-orange-800 ms-4 px-4 py-2 rounded text-white"
                            wire:click="create_default_variants">Create
                            Default Variants</button>
                    </div>
                </div>
                <div class="bg-white shadow-lg mb-4" x-data="{ currentTab: 'general' }">
                    <div class="tabs border-b">
                        <button type="button" class="p-4 mr-4 text-blue-500" @click="currentTab = 'general'"
                            :class="currentTab == 'general' ? 'border-b border-blue-500' : ''">General Info</button>
                        <button type="button" class="p-4 text-blue-500" @click="currentTab = 'meta'"
                            :class="currentTab == 'meta' ? 'border-b border-blue-500' : ''">Meta Data</button>
                    </div>
                    <div class="tab-content p-4" x-show="currentTab == 'general'">
                        <div class="flex">
                            <div class="relative mb-4">
                                <label for="stocks" class="label">Stocks</label>
                                <input name="stocks" id="stocks" type="text" class="peer input"
                                    placeholder="Stock count" wire:model="title" required />
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative mb-4 ml-4">
                                <label for="stocks" class="label">Price</label>
                                <input name="stocks" id="stocks" type="text" class="peer input"
                                    placeholder="Stock count" wire:model="title" required />
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="tab-content p-4" x-show="currentTab == 'meta'">
                        <div class="flex flex-wrap">
                            <div class="relative mb-4">
                                <label for="stocks" class="label">Meta Title</label>
                                <input name="stocks" id="stocks" type="text" class="peer input"
                                    placeholder="Stock count" wire:model="title" required />
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative mb-4 ml-4">
                                <label for="stocks" class="label">Meta Keywords</label>
                                <input name="stocks" id="stocks" type="text" class="peer input"
                                    placeholder="Stock count" wire:model="title" required />
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative mb-4 basis-full flex-1">
                                <label for="stocks" class="label">Meta Description</label>
                                <textarea name="stocks" id="stocks" type="text" class="peer input" placeholder="Stock count"
                                    wire:model="title" required></textarea>
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end">
                    <button class="primary-button">Submit</button>
                </div>
            </div>
            <div class="flex flex-col flex-1">
                <div class="bg-white shadow-lg p-4">
                    <h2 class="text-slate-600 border-b pb-2 mb-4 font-semibold text-lg">Publish</h2>
                    <div class="relative mb-4">
                        <label for="categoryname" class="label">Status</label>
                        <select name="name" id="categoryname" type="text" class="peer input"
                            placeholder="Enter category name" wire:model="title" required>
                            <option value="">Published</option>
                            <option value="">Draft</option>
                        </select>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative mb-4">
                        <label for="categoryname" class="label">Visibility</label>
                        <select name="name" id="categoryname" type="text" class="peer input"
                            placeholder="Enter category name" wire:model="title" required>
                            <option value="">Public</option>
                            <option value="">Hidden</option>
                        </select>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="bg-white shadow-lg p-4 mt-4">
                    <h2 class="text-slate-600 border-b pb-2 mb-4 font-semibold text-lg">Categories</h2>
                    <div class="flex flex-col">
                        <select name="" id="">
                            <option value="">Select category</option>
                        </select>
                        <a href="" class="my-2 text-blue-500">Add New Category</a>
                    </div>
                </div>
                <div class="bg-white shadow-lg p-4 mt-4">
                    <h2 class="text-slate-600 border-b pb-2 mb-4 font-semibold text-lg">Collection</h2>
                    <div class="flex flex-col">
                        <select name="" id="">
                            <option value="">Select collection</option>
                        </select>
                        <a href="" class="my-2 text-blue-500">Add New Collection</a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@section('scripts')
    <script>
        const filesSelector = document.querySelector('#images');
        filesSelector.addEventListener('change', function() {
            var fileList = [...filesSelector.files];
            var length = @this.uploads.length;

            fileList.forEach(function(file, index) {
                @this.upload('uploads.' + length, file, (n) => {}, () => {}, (e) => {});
                @this.upload('uploads.' + length + '.fileRef', file, (n) => {}, () => {}, (e) => {});
                @this.set('uploads.' + length + '.fileName', file.name);
                @this.set('uploads.' + length + '.fileSize', file.size);
                @this.set('uploads.' + length + '.progress', 0);
                @this.set('uploads.' + length + '.uploadedFilename', '');
                @this.set('uploads.' + length + '.src', URL.createObjectURL(file));
                @this.upload('uploads.' + length + '.fileRef', file, (n) => {}, () => {}, (e) => {
                    @this.set(
                        'uploads.' + length + '.progress',
                        e.detail.progress);
                });
            });
        });
    </script>
@endsection
