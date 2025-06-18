<x-app-layout>
    <x-slot name="header">
        <h2 class="text-primary font-semibold text-xl md:text-2xl leading-tight">
            {{ __('Tugas Kategori') }}
        </h2>
    </x-slot>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "{{ session('error') }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('task-categories.create') }}" class="btn btn-secondary text-sm md:text-base w-full md:w-auto">
                    Tambah Kategori Tugas
                </a>
            </div>
            <div class="bg-white overflow-x-auto border-2 shadow-sm rounded-lg">
                <div class="p-3 md:p-6">
                    <table class="min-w-full text-black text-sm md:text-base">
                        <thead>
                            <tr>
                                <th class="px-3 md:px-6 py-2 md:py-3 border-b">Nama Tugas</th>
                                <th class="px-3 md:px-6 py-2 md:py-3 border-b">Fungsi</th>
                                <th class="px-3 md:px-6 py-2 md:py-3 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td class="px-3 md:px-6 py-2 md:py-4 border-b">{{ $category->name }}</td>
                                <td class="px-3 md:px-6 py-2 md:py-4 border-b">
                                    <div class="flex flex-wrap gap-1">
                                        @if($category->has_dor_date) <span class="badge badge-sm md:badge-md text-primary-content bg-primary">DOR</span> @endif
                                        @if($category->has_batch) <span class="badge badge-sm md:badge-md text-primary-content bg-primary">Batch</span> @endif
                                        @if($category->has_claim) <span class="badge badge-sm md:badge-md text-primary-content bg-primary">Claim</span> @endif
                                        @if($category->has_time_range) <span class="badge badge-sm md:badge-md text-primary-content bg-primary">Waktu</span> @endif
                                        @if($category->has_sheets) <span class="badge badge-sm md:badge-md text-primary-content bg-primary">Lembar</span> @endif
                                        @if($category->has_email) <span class="badge badge-sm md:badge-md text-primary-content bg-primary">Email</span> @endif
                                        @if($category->has_form) <span class="badge badge-sm md:badge-md text-primary-content bg-primary">Form</span> @endif
                                    </div>
                                </td>
                                <td class="px-3 md:px-6 py-2 md:py-4 border-b">
                                    <div class="flex flex-col md:flex-row gap-2">
                                        <a href="{{ route('task-categories.edit', $category->id) }}" class="btn btn-secondary btn-sm md:btn-md">Edit</a>
                                        <button type="button" onclick="confirmDelete({{ $category->id }})" class="btn btn-error btn-sm md:btn-md">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(categoryId) {
            Swal.fire({
                title: `Yakin Hapus kategori ?`,
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/task-categories/${categoryId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.needsConfirmation) {
                            Swal.fire({
                                title: 'Perhatian!',
                                text: `Kategori ini memiliki ${data.tasksCount} tugas yang terhubung. Yakin ingin menghapus semuanya?`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#dc2626',
                                cancelButtonColor: '#6b7280',
                                confirmButtonText: 'Ya, Hapus Semua',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = `/task-categories/${categoryId}/force-delete`;
                                }
                            });
                        } else {
                            window.location.reload();
                        }
                    });
                }
            });
        }
        </script>
</x-app-layout>
