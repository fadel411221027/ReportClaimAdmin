<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-primary">
            {{ __('Report Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between px-4 mb-6">
                @role('PIC')
                    <h2 class="btn btn-accent"><a href="{{ route('task-categories.index') }}">Tambah Kategori Tugas</a></h2>
                @endrole
                <a href="{{ route('daily-reports.create') }}" class="btn btn-primary">
                    Buat Report Baru
                </a>
            </div>
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
            <div class="grid gap-4">
                @php
    $groupedReports = $reports->sortByDesc('report_date')->groupBy(function ($report) {
        return $report->report_date->format('d/m/Y');
    });
@endphp
                @foreach ($groupedReports as $date => $dateReports)
                    <div class="border-2 shadow-sm transition-shadow card border-accent bg-base-100 hover:shadow-md">
                        <div class="p-4 card-body">
                            <div class="flex flex-wrap gap-2 justify-between items-center mb-3">
                                <h3 class="text-lg font-semibold">{{ $date }}</h3>
                                <div class="flex flex-wrap gap-2">
                                    <span class="badge badge-success badge-sm">
                                        Disetujui: {{ $dateReports->where('is_approved', true)->count() }}
                                    </span>
                                    <span class="badge badge-warning badge-sm">
                                        Pending: {{ $dateReports->where('is_approved', false)->count() }}
                                    </span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($dateReports as $report)
                                    <div class="border-2 border-accent shadow-sm transition-shadow card bg-base-100 hover:shadow-md hover:border-primary">
                                        <div class="p-3 card-body">
                                            <div class="flex flex-wrap justify-between items-center mb-2">
                                                <div class="flex flex-wrap gap-1 items-center text-sm">
                                                    @role(['PIC','Leader'])
                                                        <form id="approveForm-{{ $report->id }}"
                                                            action="{{ route('daily-reports.approve', $report->id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="button"
                                                                onclick="confirmApprove({{ $report->id }})"
                                                                class="cursor-pointer badge badge-primary badge-sm"
                                                                {{ $report->is_approved ? 'disabled' : '' }}>Report</button>
                                                        </form>
                                                    @else
                                                        <span class="badge badge-primary badge-sm">Report</span>
                                                    @endrole
                                                    <span class="font-medium">{{ ucwords($report->user->name) }}</span>
                                                    <div class="tooltip tooltip-right {{ $report->is_approved ? 'block' : 'hidden' }}" data-tip="{{ $report->approved_by ? '👍 dari ' . ucwords(\App\Models\User::find($report->approved_by)->name) : '' }}">
                                                        <button id="checkmark-{{ $report->id }}" class="btn btn-ghost btn-xs">
                                                            <i class="text-green-500 fas fa-check-circle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mt-2 opacity-10 sm:mt-0 hover:opacity-100">
                                                    <a href="{{ route('daily-reports.continue', $report) }}"
                                                        class="btn btn-ghost btn-xs">Teruskan</a>
                                                </div>
                                            </div>                                            <div class="space-y-1 text-sm">
                                                @foreach ($report->tasks as $index => $task)
                                                    <div class="flex gap-1">
                                                        <span>{{ $index + 1 }}.</span>
                                                        <div class="flex-1">
                                                            <span class="font-medium">{{ $task->category->name }}
                                                                @if (!$task->task_date) :@endif
                                                            </span>
                                                            @if ($task->category->id && $task->task_date)
                                                                <span class="text-xs">DOR {{ \Carbon\Carbon::parse($task->task_date)->format('d-m-Y') }} :</span>
                                                            @endif
                                                            <span class="text-xs text-accent-500">
                                                                @if ($task->batch_count){{ $task->batch_count }} Batch,@endif
                                                                @if ($task->claim_count){{ $task->claim_count }} Klaim @endif
                                                                @if ($task->start_time && $task->end_time)
                                                                    {{ \Carbon\Carbon::parse($task->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($task->end_time)->format('H:i') }}
                                                                @endif
                                                                @if ($task->sheet_count){{ $task->sheet_count }} Lembar @endif
                                                                @if ($task->email){{ $task->email }} Email @endif
                                                                @if ($task->form){{ $task->form }} Form @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center px-3 pb-2">
                                            @role(['PIC','Leader'])
                                                <button
                                                    onclick="document.getElementById('delete-modal-{{ $report->id }}').showModal()"
                                                    class="btn btn-error btn-xs">
                                                    Hapus
                                                </button>
                                                <dialog id="delete-modal-{{ $report->id }}" class="modal">
                                                    <div class="modal-box">
                                                        <h3 class="text-lg font-bold">Konfirmasi Hapus</h3>
                                                        <p class="py-4">Apakah anda yakin ingin menghapus report ini?</p>
                                                        <div class="modal-action">
                                                            <form action="{{ route('daily-reports.destroy', $report) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-error btn-sm">Ya, Hapus</button>
                                                            </form>
                                                            <form method="dialog">
                                                                <button class="btn btn-sm">Batal</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </dialog>
                                            @endrole

                                            <div class="flex gap-1 items-center text-xs text-gray-500">
                                                <i class="fa-regular fa-clock"></i>
                                                {{ $report->created_at->locale('id')->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $reports->links() }}
            </div>
        </div>
    </div>


    <script>
        function confirmApprove(reportId) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin menyetujui report ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setuju!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Berhasil!',
                        'Report telah disetujui',
                        'success'
                    ).then(() => {
                        document.getElementById(`approveForm-${reportId}`).submit();
                    })
                }
            })
        }
    </script>
</x-app-layout>
