<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight text-primary">{{ __('Meeting Mingguan') }}</h2>
            <button onclick="generateMeetings()" class="gap-2 btn btn-primary btn-sm">
                <i class="fa-solid fa-calendar-plus"></i>
                Buat Meeting
            </button>
        </div>
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

    <div class="py-6 min-h-screen bg-base-200/50">
        <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:gap-6">
                @forelse ($meetings as $meeting)
                    <div class="shadow-md transition-all duration-300 card bg-base-100 hover:shadow-lg">
                        <div class="p-4 card-body sm:p-6">
                            <div class="flex flex-wrap gap-4 justify-between items-center pb-4 border-b border-base-200">
                                <div class="flex gap-3 items-center">
                                    <div class="p-3 badge badge-primary">
                                        <i class="text-lg fa-solid fa-calendar-week"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold sm:text-xl">
                                            {{ $meeting->meeting_date->isoFormat('dddd', 'id') }}
                                        </h2>
                                        <p class="text-sm text-base-content/70">
                                            {{ $meeting->meeting_date->isoFormat('D MMMM Y') }}
                                        </p>
                                    </div>
                                </div>
                                <button
                                    onclick="openTopicModal({{ $meeting->id }})"
                                    class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-plus"></i>
                                    <span class="hidden sm:inline">Tambah Pembahasan</span>
                                </button>
                            </div>

                            <div class="mt-4 space-y-3">
                                @forelse($meeting->topics as $topic)
                                    <div class="group relative bg-base-100 rounded-lg border-2 p-4
                                        {{ $topic->is_completed ? 'border-success/30 bg-success/5' : 'border-base-200' }}
                                        hover:border-primary/30 transition-colors">
                                        <div class="flex gap-3 items-start">
                                            <button
                                                onclick="toggleComplete({{ $topic->id }})"
                                                class="btn btn-circle btn-xs {{ $topic->is_completed ? 'btn-success' : 'btn-warning' }} mt-1">
                                                <i class="fa-solid {{ $topic->is_completed ? 'fa-check' : 'fa-clock' }}"></i>
                                            </button>

                                            <div class="flex-1 min-w-0">
                                                <div class="flex gap-2 justify-between items-center">
                                                    <h3 class="font-medium {{ $topic->is_completed | $topic->is_continued ? 'line-through opacity-50' : '' }}">
                                                        {{ $topic->title }}
                                                        <span class="inline-flex gap-2 ml-2">

                                                            @if($topic->continued_from_id)
                                                                <span class="badge badge-info badge-sm">
                                                                    <i class="mr-1 fa-solid fa-arrow-left"></i>
                                                                    Dari meeting sebelumnya
                                                                </span>
                                                            @endif

                                                            @if($topic->is_completed && $topic->is_completed = 2)
                                                            <span class="badge badge-success badge-sm">
                                                                <i class="mr-1 fa-solid fa-check"></i>
                                                                Selesai
                                                            </span>
                                                        @elseif($topic->is_completed == 0 && $topic->continued_from_id == false && $topic->is_continued == false)
                                                            <span class="badge badge-warning badge-sm">
                                                                <i class="fa-regular fa-comment mr-1"></i>
                                                                 Pembahasan baru!
                                                            </span>
                                                        @endif
                                                        @if($topic->is_continued)
                                                        <span class="badge badge-warning badge-sm">
                                                            <i class="mr-1 fa-solid fa-arrow-right"></i>
                                                            Dilanjutkan ke meeting selanjutnya
                                                        </span>
                                                        @endif
                                                        </span>
                                                    </h3>
                                                    @unless($topic->is_completed || $topic->is_continued)
                                                        <button
                                                            onclick="continueTopic({{ $topic->id }})"
                                                            class="opacity-0 transition-opacity btn hover:btn-info btn-xs group-hover:opacity-100">
                                                            Teruskan
                                                            <i class="fa-solid fa-arrow-right"></i>
                                                        </button>
                                                    @endunless
                                                </div>

                                                @if($topic->description)
                                                    <p class="text-sm text-base-content/70 mt-1 {{ $topic->is_completed ? 'line-through opacity-50' : '' }}">
                                                        {{ $topic->description }}
                                                    </p>
                                                @endif

                                                <div class="flex gap-2 items-center mt-2">
                                                    <span class="text-xs text-base-content/50">
                                                        <i class="fa-solid fa-user-pen text-primary/70"></i>
                                                        {{ ucwords(strtolower($topic->user->name)) }}
                                                    </span>
                                                    <span class="text-xs text-base-content/50">
                                                        <i class="fa-regular fa-clock text-primary/70"></i>
                                                        {{ $topic->created_at->locale('id')->diffForHumans() }}
                                                    </span>

                                                </div>
                                            </div>
                                        </div>

                                        @if($topic->files->count() > 0)
                                            <div class="pt-3 mt-3 border-t border-base-200">
                                                <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
                                                    @foreach($topic->files as $file)
        <div class="overflow-hidden rounded-lg cursor-pointer aspect-square bg-base-200/50"
             onclick="openFilePreviewModal('{{ Storage::url($file->path) }}', '{{ $file->filename }}', '{{ $file->type }}')">
            @if(Str::startsWith($file->type, 'image/'))
                <img
                    src="{{ Storage::url($file->path) }}"
                    alt="{{ $file->filename }}"
                    class="object-cover w-full h-full transition-transform hover:scale-105"
                />
            @else
                <div class="flex flex-col justify-center items-center p-2 w-full h-full">
                    <i class="text-xl fa-solid fa-file-lines text-primary/70"></i>
                    <span class="mt-1 text-xs text-center line-clamp-2">
                        {{ $file->filename }}
                    </span>
                </div>
            @endif
        </div>
    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="py-8 text-center text-base-content/50">
                                        <i class="mb-2 text-3xl fa-regular fa-clipboard"></i>
                                        <p>Belum ada pembahasan yang ditambahkan</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 shadow-md card bg-base-100">
                        <div class="text-center text-base-content/50">
                            <i class="mb-3 text-4xl fa-regular fa-calendar-xmark"></i>
                            <p class="text-lg">Belum ada jadwal meeting</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $meetings->links() }}
            </div>
        </div>
    </div>

    <dialog id="topicModal" class="modal modal-bottom sm:modal-middle">
        <div class="max-w-2xl modal-box bg-base-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-primary">Buat pembahasan baru</h3>
                <button onclick="closeTopicModal()" class="btn btn-ghost btn-sm btn-circle">
                    <i class="text-lg fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" enctype="multipart/form-data" id="topicForm" class="space-y-6">
                @csrf

                <div class="form-control">
                    <label class="label">
                        <span class="font-medium label-text">Judul</span>
                        <span class="label-text-alt text-error">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        class="w-full input input-bordered"
                        placeholder="Masukan judul pembahasan"
                        required
                    >
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="font-medium label-text">Detail</span>
                    </label>
                    <textarea
                        name="description"
                        class="textarea textarea-bordered min-h-[120px]"
                        placeholder="Masukan detail pembahasan disini"
                    ></textarea>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="font-medium label-text">File</span>
                        <span class="label-text-alt text-base-content/60">Jika diperlukan</span>
                    </label>

                    <div class="flex flex-col gap-4">
                        <input
                            type="file"
                            name="files[]"
                            multiple
                            class="w-full file-input file-input-bordered"
                            onchange="previewFiles(this)"
                        />

                        <div id="filePreview" class="grid grid-cols-2 gap-3 sm:grid-cols-4"></div>
                    </div>
                </div>

                <div class="flex gap-2 justify-end pt-4 border-t modal-action border-base-200">
                    <button
                        type="button"
                        onclick="closeTopicModal()"
                        class="btn btn-ghost"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa-solid fa-plus"></i>
                        Buat
                    </button>
                </div>
            </form>
        </div>

        <form method="dialog" class="modal-backdrop bg-base-200/80">
            <button>close</button>
        </form>
    </dialog>

    <dialog id="filePreviewModal" class="modal modal-bottom sm:modal-middle">
        <div class="p-0 max-w-4xl modal-box bg-base-100">
            <div class="flex justify-between items-center p-4 border-b border-base-200">
                <h3 class="text-lg font-medium" id="previewFileName"></h3>
                <button onclick="closeFilePreviewModal()" class="btn btn-ghost btn-sm btn-circle">
                    <i class="text-lg fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="p-4">
                <div id="previewContent" class="flex justify-center items-center">
                    <!-- Content File Meeting inside here -->
                </div>
            </div>
        </div>

        <form method="dialog" class="modal-backdrop bg-base-200/80">
            <button>close</button>
        </form>
    </dialog>

    <script>
        function openFilePreviewModal(fileUrl, fileName, fileType) {
        const modal = document.getElementById('filePreviewModal');
        const previewContent = document.getElementById('previewContent');
        const fileNameElement = document.getElementById('previewFileName');

        fileNameElement.textContent = fileName;

        if (fileType.startsWith('image/')) {
            previewContent.innerHTML = `
                <img
                    src="${fileUrl}"
                    alt="${fileName}"
                    class="max-w-full max-h-[70vh] object-contain"
                />
            `;
        } else {
            previewContent.innerHTML = `
                <div class="p-8 text-center">
                    <i class="mb-3 text-4xl fa-solid fa-file-lines text-primary"></i>
                    <p class="mb-4">${fileName}</p>
                    <a href="${fileUrl}" class="btn btn-primary" download="${fileName}">
                        <i class="mr-2 fa-solid fa-download"></i>
                        Download File
                    </a>
                </div>
            `;
        }

        modal.showModal();
    }

    function closeFilePreviewModal() {
        const modal = document.getElementById('filePreviewModal');
        modal.close();
    }

        function generateMeetings() {
            fetch('/meetings/generate', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
            //         window.location.reload();
            //         const toast = document.createElement('div');
            //         toast.className = 'toast toast-top toast-end';
            //         toast.innerHTML = `
            //             <div class="alert alert-success">
            //                 <i class="fa-solid fa-check"></i>
            //                 <span>${data.message}</span>
            //             </div>
            //         `;
            //         document.body.appendChild(toast);
            //         setTimeout(() => toast.remove(), 3000);
            //     }
            // })
            ;
        }

        function openTopicModal(meetingId) {
            const modal = document.getElementById('topicModal');
            const form = document.getElementById('topicForm');
            form.action = `/meetings/${meetingId}/topics`;
            modal.showModal();
        }

        function closeTopicModal() {
            const modal = document.getElementById('topicModal');
            const form = document.getElementById('topicForm');
            const preview = document.getElementById('filePreview');

            form.reset();
            preview.innerHTML = '';
            modal.close();
        }

        function previewFiles(input) {
            const preview = document.getElementById('filePreview');
            preview.innerHTML = '';

            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'relative group aspect-square rounded-lg overflow-hidden border-2 border-base-200';

                    if (file.type.startsWith('image/')) {
                        div.innerHTML = `
                            <img
                                src="${e.target.result}"
                                class="object-cover w-full h-full transition-transform group-hover:scale-105"
                                alt="${file.name}"
                            />
                            <div class="flex absolute inset-0 justify-center items-center opacity-0 transition-opacity bg-base-100/80 group-hover:opacity-100">
                                <span class="px-2 text-xs text-center line-clamp-2">${file.name}</span>
                            </div>
                        `;
                    } else {
                        div.innerHTML = `
                            <div class="flex flex-col justify-center items-center p-3 w-full h-full transition-colors group-hover:bg-base-200/50">
                                <i class="mb-2 text-2xl fa-solid fa-file-lines text-primary"></i>
                                <span class="text-xs text-center line-clamp-2">${file.name}</span>
                            </div>
                        `;
                    }

                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        function toggleComplete(topicId) {
            fetch(`/topics/${topicId}/toggle`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            });
        }

        function continueTopic(topicId) {
            fetch(`/topics/${topicId}/continue`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            });
        }
    </script>
</x-app-layout>
