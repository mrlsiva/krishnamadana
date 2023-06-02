    <div class="">
        <div class="section-header">
            Create Category
        </div>
        <form wire:submit.prevent="save">
            @csrf
            <div class="relative mb-4">
                <label for="categoryname" class="label">Category Name</label>
                <input name="name" id="categoryname" type="text" class="peer input" placeholder="Enter category name"
                    wire:model="name" required />
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <button class="primary-button">Add Category</button>
        </form>
    </div>
