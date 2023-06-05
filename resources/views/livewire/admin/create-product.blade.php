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
                    @foreach ($uploads as $i => $upl)
                        <div class="flex flex-wrap">
                            <div class="flex flex-col relative">
                                <img src="{{ $upl['src'] }}" alt="" width="200" height="auto"
                                    class="object-cover">
                                <div>{{ $upl['fileName'] }}</div>
                                {{-- @if ($upl['progress'] < 100) --}}
                                <div class="absolute inset-0 backdrop w-full h-full bg-slate-700/20">
                                    <p>Uploading...</p>
                                </div>
                                {{-- @endif --}}
                            </div>
                        </div>
                    @endforeach
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
            </div>
        </div>
    </form>
</div>

@section('scripts')
    <script>
        const filesSelector = document.querySelector('#images');
        filesSelector.addEventListener('change', function() {
            const fileList = [...filesSelector.files];
            fileList.forEach(function(file, index) {
                @this.upload('uploads.' + index, file, (n) => {}, () => {}, (e) => {});
                @this.upload('uploads.' + index + '.fileRef', file, (n) => {}, () => {}, (e) => {});
                @this.set('uploads.' + index + '.fileName', file.name);
                @this.set('uploads.' + index + '.fileSize', file.size);
                @this.set('uploads.' + index + '.progress', 0);
                @this.set('uploads.' + index + '.uploadedFilename', '');
                @this.set('uploads.' + index + '.src', URL.createObjectURL(file));
                @this.upload('uploads.' + index + '.fileRef', file, (n) => {}, () => {}, (e) => {
                    @this.set(
                        'uploads.' + index + '.progress',
                        e.detail.progress);
                });
            });
        });
    </script>
@endsection
