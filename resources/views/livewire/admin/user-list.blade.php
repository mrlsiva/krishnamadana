@section('section')
    <div class="section-header">
        User List
    </div>
    <a href="{{ route('admin.user.create') }}" class="inline-block my-4 bg-green-600 text-white px-4 py-2 rounded">Create
        User</a>
        <div class="rounded-xl relative overflow-auto">
            <div class="shadow-sm overflow-hidden">
                <table class="w-full table-auto border-collapse bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="bg-grid-slate-100 border-b p-4 text-slate-800 text-left font-medium">#</th>
                            <th class="border-b p-4 text-slate-800 text-left font-medium">Name</th>
                            <th class="border-b p-4 text-slate-800 text-left font-medium">Email</th>
                            <th class="border-b p-4 text-slate-800 text-left font-medium">Mobile</th>
                            <th class="border-b p-4 text-slate-800 text-left font-medium">Account Created At</th>
                            <th class="border-b p-4 text-slate-800 text-left font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @empty($users->count())
                            <x-admin.no-results-table colspan="6" />
                        @endempty
                        @foreach ($users as $user)
                            <tr>
                                <td class="p-4">{{ $loop->iteration }}.</td>
                                <td class="p-4">{{ $user->name }}</td>
                                <td class="p-4">{{ $user->email }}</td>
                                <td class="p-4">{{ $user->mobile }}</td>
                                <td class="p-4">
                                    {{ $user->created_at->format('j F, Y') }}
                                </td>
                                <td class="p-4">
                                    <div class="flex">
                                        {{-- <a href="{{ route('admin.user.edit', ['user' => $user]) }}"
                                            class="inline-block w-8 h-8 bg-blue-600 text-white p-2 rounded mr-5">
                                            <x-icons.edit />
                                        </a> --}}
                                        {{-- <button class="w-8 h-8 bg-red-600 text-white p-2 rounded">
                                            <x-icons.delete />
                                        </button> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $users->links() }}
@endsection
