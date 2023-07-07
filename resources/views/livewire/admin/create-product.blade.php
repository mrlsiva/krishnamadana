<div class="">
    <div class="section-header">
        {{ $editing ? 'Edit' : 'Create' }} Product
    </div>
    <form wire:submit.prevent="save">
        <div class="flex p-4">
            <div class="flex flex-col basis-3/4 mr-4">
                <div class="bg-white shadow-lg p-4 mb-8">
                    <div class="relative mb-4">
                        <label for="categoryname" class="label">Product Name</label>
                        <input name="name" id="categoryname" type="text" class="peer input"
                            placeholder="Enter product name" wire:model="product.name" />
                        @error('product.name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative mb-4" wire:ignore>
                        <label for="categoryname" class="label">Product Description</label>
                        <input name="description" id="categoryname" type="text" class="peer input"
                            placeholder="Enter category name" wire:model="product.description" />
                    </div>
                    @error('product.description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="bg-white shadow-lg p-4 mb-4">
                    <h2 class="text-slate-600 border-b pb-2 mb-4 font-semibold text-lg">Product Gallery</h2>
                    @if (sizeof($uploads) > 0 || sizeof($images) > 0)
                        <div class="flex flex-wrap">
                            @foreach ($images as $i => $upl)
                                <div class="flex flex-col relative mx-2 my-4">
                                    <img src="{{ $upl->getUrl() }}" alt=""
                                        class="w-[200px] h-[200px] object-cover">
                                    <button type="button" class="bg-red-600 text-white px-4 py-2"
                                        wire:click="remove_uploaded_image({{ $i }})">Delete</button>
                                </div>
                            @endforeach
                            @foreach ($uploads as $i => $upl)
                                <div class="flex flex-col relative mx-2 my-4">
                                    <img src="{{ $upl['src'] }}" alt=""
                                        class="w-[200px] h-[200px] object-cover">
                                    @if ($upl['progress'] < 100)
                                        <div
                                            class="absolute inset-0 backdrop w-full h-full bg-slate-700/40 flex items-center justify-center">
                                            <p class="text-white">Uploading...</p>
                                        </div>
                                    @endif
                                    <button type="button" class="bg-red-600 text-white px-4 py-2"
                                        wire:click="remove_image({{ $i }})">Remove</button>
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
                            <p class="font-semibold text-md text-slate-600">Click to upload</p>
                        </div>
                        <input name="images" id="images" type="file" class="hidden" x-ref="image" multiple />
                    </div>
                    @error('images')
                        <p class="error">Upload one or more product images.</p>
                    @enderror
                </div>
                <div class="bg-white shadow-lg mb-4" x-data="{ currentTab: 'general' }">
                    <div class="tabs border-b">
                        <button type="button" class="p-4 mr-4 text-blue-500" @click="currentTab = 'general'"
                            :class="currentTab == 'general' ? 'border-b border-blue-500' : ''">General Info</button>
                        <button type="button" class="p-4 text-blue-500" @click="currentTab = 'meta'"
                            :class="currentTab == 'meta' ? 'border-b border-blue-500' : ''">Meta Data</button>
                    </div>
                    <div class="tab-content p-4" x-show="currentTab == 'general'" wire:ignore>
                        <div class="flex w-full">
                            <div class="relative w-full mb-4">
                                <label for="stocks" class="label">Additional Information</label>
                                <input name="additionalInfo" id="additionalInfo" type="text" class="peer input"
                                    placeholder="Enter category name" wire:model="product.additional_info" />
                            </div>
                            @error('product.additional_info')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="tab-content p-4" x-show="currentTab == 'meta'">
                        <div class="flex flex-wrap">
                            <div class="relative mb-4">
                                <label for="stocks" class="label">Meta Title</label>
                                <input name="stocks" id="stocks" type="text" class="peer input"
                                    placeholder="Stock count" wire:model="meta.title" />
                                @error('meta.title')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative mb-4 ml-4 flex-1">
                                <label for="stocks" class="label">Meta Keywords</label>
                                <input name="stocks" id="stocks" type="text" class="peer input"
                                    placeholder="Stock count" wire:model="meta.keywords" />
                                @error('meta.keywords')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="relative mb-4 basis-full flex-1">
                                <label for="stocks" class="label">Meta Description</label>
                                <textarea name="stocks" id="stocks" type="text" class="peer input" placeholder="Stock count"
                                    wire:model="meta.description"></textarea>
                                @error('meta.description')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-lg p-4 mb-4">
                    <h2 class="text-slate-600 border-b pb-2 mb-4 font-semibold text-lg">Product Variations</h2>

                    <div class="tab-content pt-4">
                        @if (empty($items->count()))
                            <div class="border border-dashed p-4 mb-4">
                                <p class="text-center text-gray-600">No Product Variations added.</p>
                            </div>
                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($items as $index => $item)
                                <div class="flex flex-col mb-4">
                                    <div class="mb-2"><strong>SKU:</strong> {{ $item->sku }}</div>
                                    <div class="flex border p-2">
                                        <div class="flex flex-col flex-1">
                                            <p class="font-bold">
                                                @foreach ($item->configurations as $configuration)
                                                    {{ $configuration->option->value }}@if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </p>
                                            <div class="flex flex-col flex-1">
                                                ₹ {{ $item->amount }},
                                                Stock: {{ $item->stock ?? 'NA' }}
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <button class="w-6 text-red-500" type="button"
                                                wire:click="confirm_delete_item({{ $item->id }})">
                                                <x-icons.delete />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- <div class="border border-dashed p-4 mb-4 flex">
                                <div class="flex flex-col flex-1">
                                    <p class="text-zinc-600"><strong>{{ $sku['sku'] }}</strong></p>
                                    @php
                                        $variants = $this->attributesSku->where(fn($item) => $item['sku_id'] == $sku['id'] || $item['sku'] == $sku['sku'])->all();
                                    @endphp
                                    <p>
                                        @foreach ($variants as $variant)
                                            {{ $loop->first ? '' : ', ' }}
                                            <span class="nice">{{ $variant['value'] }}</span>
                                        @endforeach
                                    </p>
                                </div>
                                <div class="flex flex-col mx-5">
                                    <p class="text-zinc-600"><strong>₹ {{ $sku['amount'] }}</strong></p>
                                    @if (isset($sku['stock']))
                                        <p>{{ $sku['stock'] }} stock</p>
                                    @else
                                        <p>Stock unlimited</p>
                                    @endif
                                </div>
                                <div class="flex">
                                    <button type="button" class="w-8 h-8 bg-blue-600 text-white p-2 rounded mr-4"
                                        wire:click="open_sku_modal({{ $sku['id'] }})">
                                        <x-icons.edit />
                                    </button>
                                    <button type="button" class="w-8 h-8 bg-red-600 text-white p-2 rounded">
                                        <x-icons.delete />
                                    </button>
                                </div>
                            </div>
                        @endforeach --}}
                        <div class="flex items-center">
                            <button type="button" class="bg-orange-500 px-4 py-2 rounded text-white"
                                wire:click="open_sku_modal(null)">Create
                                New
                                Variation</button>
                            <span class="inline-block mx-5">or</span>
                            <button type="button" class="text-orange-500 underline"
                                wire:click="open_variation_modal">Generate
                                All Possible Variation</button>
                        </div>
                        @error('items')
                            <p class="error mt-2">Add at least one product item.</p>
                        @enderror
                    </div>
                    {{-- <div class="tab-content pt-4" x-show="currentTab == 'variant'">
                        @if (sizeof($variants) == 0)
                            <div class="border border-dashed p-4 mb-4">
                                <p class="text-center text-gray-600">No Variants added.</p>
                            </div>
                        @endif
                        @foreach ($variants as $variant)
                            <div class="border border-dashed p-4 mb-4 flex items-center justify-between">
                                <div class="font-bold">{{ $variant['name'] }}</div>
                                <button type="button">
                                    <x-icons.delete />
                                </button>
                            </div>
                        @endforeach
                        <div class="relative mb-4">
                            <label for="categoryname" class="label">Add New Variant</label>
                            <input name="description" id="categoryname" type="text" class="peer input"
                                placeholder="Enter variant name. (eg. Size, Color)" wire:model="title"
                                wire:model="variant_name" />
                        </div>
                        <button type="button" class="bg-orange-500 px-4 py-2 rounded text-white"
                            wire:click="create_variant">Add Variant</button>
                        @if (sizeof($variants) == 0)
                            <button type="button" class="bg-orange-800 ms-4 px-4 py-2 rounded text-white"
                                wire:click="create_default_variants">Create
                                Default Variants</button>
                        @endif
                    </div> --}}
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
                            placeholder="Enter category name" wire:model="product.status">
                            <option value="Published">Published</option>
                            <option value="Draft">Draft</option>
                        </select>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="relative mb-4">
                        <label for="categoryname" class="label">Visibility</label>
                        <select name="name" id="categoryname" type="text" class="peer input"
                            placeholder="Enter category name" wire:model="product.visibility">
                            <option value="Public">Public</option>
                            <option value="Hidden">Hidden</option>
                        </select>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="bg-white shadow-lg p-4 mt-4">
                    <h2 class="text-slate-600 border-b pb-2 mb-4 font-semibold text-lg">Categories</h2>
                    <div class="flex flex-col">
                        <select name="category_id" id="category_id" wire:model="product.category_id">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('product.category_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <a href="{{ route('admin.createCategory') }}" class="my-2 text-blue-500 text-center">Add New
                            Category</a>
                    </div>
                </div>
                <div class="bg-white shadow-lg p-4 mt-4">
                    <h2 class="text-slate-600 border-b pb-2 mb-4 font-semibold text-lg">Collection</h2>
                    <div class="flex flex-col">
                        <select name="" id="">
                            <option value="">Select collection</option>
                        </select>
                        <a href="" class="my-2 text-blue-500 text-center">Add New Collection</a>
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
                @this.set('uploads.' + length, file, (n) => {}, () => {}, (e) => {});
                @this.set('uploads.' + length + '.fileRef', file, (n) => {}, () => {}, (e) => {});
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
        var editorOptions = {
            toolbar: [
                ['Bold', 'Italic', 'Strike'],
                ['Link', 'Unlink', 'Anchor'],
                ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'],
                ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
            ]
        };
        const descEditor = CKEDITOR.replace('description', editorOptions);
        const addEditor = CKEDITOR.replace('additionalInfo', editorOptions);
        descEditor.on('change', function(event) {
            @this.set('product.description', event.editor.getData());
        });
        addEditor.on('change', function(event) {
            @this.set('product.additional_info', event.editor.getData());
        });
        descEditor.setData('{!! trim($product->description) !!}');
        addEditor.setData('{!! trim($product->additional_info) !!}');
    </script>
@endsection
