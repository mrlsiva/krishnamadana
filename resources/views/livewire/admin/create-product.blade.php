<div class="">
    <div class="section-header">
        Create Product
    </div>
    <form wire:submit.prevent="save">
        <div class="flex p-4">
            <div class="flex flex-col bg-white shadow-lg p-4 mr-4 basis-3/4">
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
            <div class="flex flex-col flex-1 bg-white shadow-lg p-4">
                <h2 class="text-slate-600 border-b pb-2 mb-4">Publish</h2>
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
    </form>
</div>
