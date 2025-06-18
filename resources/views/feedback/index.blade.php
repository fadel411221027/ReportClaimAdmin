<x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-primary">{{ __('Koleksi Masukan') }}</h2>
                <span class="badge badge-lg">{{ $feedbacks->count() }} Masukan</span>
            </div>
        </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-base-100 to-base-200">
        <div class="container mx-auto p-4 sm:p-6 lg:p-8">

            @if($feedbacks->isEmpty())
                <div class="flex items-center justify-center min-h-[400px] animate-fade-up">
                    <div class="text-center space-y-4">
                        <div class="inline-flex p-4 bg-base-300 rounded-full">
                            <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold">Belum ada masukan</h3>
                        <p class="text-base-content/60">Menunggu..</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($feedbacks as $feedback)
                        <div class="group hover:-translate-y-1 transition-all duration-300">
                            <div class="card bg-base-100 shadow-xl overflow-hidden">
                                @if($feedback->file_path)
                                    @php
                                        $extension = pathinfo($feedback->file_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    @endphp

                                    @if($isImage)
                                        <figure class="relative h-48 overflow-hidden">
                                            <img 
                                                src="{{ asset('storage/' . $feedback->file_path) }}"
                                                alt="Attachment"
                                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                            />
                                            <div class="absolute inset-0 bg-gradient-to-t from-base-100 to-transparent opacity-50"></div>
                                        </figure>
                                    @endif
                                @endif

                                <div class="card-body">
                                    <div class="flex items-center gap-3 -mt-2">
                                        {{-- <div class="avatar placeholder">
                                            <div class="w-10 rounded-full bg-gradient-to-br from-primary to-secondary text-primary-content">
                                                <span>{{ substr($feedback->user->name, 0, 1) }}</span>
                                            </div>
                                        </div> --}}
                                        <td>
                                            <button 
                                                onclick="toggleDone({{ $feedback->id }})"
                                                class="btn btn-sm {{ $feedback->has_done ? 'btn-success' : 'btn-warning' }}">
                                                {{ $feedback->has_done ? 'Done' : 'Pending' }}
                                            </button>
                                        </td>
                                        
                                        <div class="flex-1 min-w-0">
                                            {{-- <p class="font-semibold truncate">{{ $feedback->user->name }}</p> --}}
                                            <time class="text-sm opacity-70">{{ $feedback->created_at->diffForHumans() }}</time>
                                        </div>
                                    </div>

                                    <h3 class="card-title font-bold mt-2">{{ $feedback->title }}</h3>
                                    
                                    <div class="prose max-w-none mt-2">
                                        <p class="line-clamp-3">{{ $feedback->detail }}</p>
                                    </div>

                                    @if($feedback->file_path)
                                        <div class="mt-4">
                                            <div class="flex items-center gap-2 p-3 bg-base-200 rounded-lg">
                                                <div class="p-2 bg-base-300 rounded">
                                                    @if($isImage)
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium truncate">
                                                        {{ basename($feedback->file_path) }}
                                                    </p>
                                                    <p class="text-xs opacity-70">
                                                        {{ strtoupper($extension) }} File
                                                    </p>
                                                </div>
                                                <a href="{{ asset('storage/' . $feedback->file_path) }}" 
                                                   class="btn btn-primary btn-sm gap-2"
                                                   download>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Save
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        .animate-fade-up {
            animation: fadeUp 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .grid > div {
            animation: cardAppear 0.5s ease-out backwards;
        }
        
        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .grid > div:nth-child(1) { animation-delay: 0.1s; }
        .grid > div:nth-child(2) { animation-delay: 0.2s; }
        .grid > div:nth-child(3) { animation-delay: 0.3s; }
        .grid > div:nth-child(4) { animation-delay: 0.4s; }
        .grid > div:nth-child(5) { animation-delay: 0.5s; }
        .grid > div:nth-child(6) { animation-delay: 0.6s; }
    </style>

<script>
    function toggleDone(id) {
        fetch(`/feedback/${id}/toggle-done`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Status updated!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.reload();
                });
            }
        });
    }
    </script>
</x-app-layout>