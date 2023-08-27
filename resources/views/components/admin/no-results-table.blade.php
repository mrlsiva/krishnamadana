@if (empty($categories))
    <tr>
        <td colspan="{{ $colspan }}">
            <div class="w-full flex flex-col items-center justify-center my-4">
                <div class="w-24 text-red-400 animate-pulse">
                    <x-icons.search />
                </div>
                <p class="font-semibold">No results found.</p>
            </div>
        </td>
    </tr>
@endif
