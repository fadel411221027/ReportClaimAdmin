<div class="navbar bg-base-100">
    <div class="navbar-start">
        <div class="dropdown lg:hidden">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="{{ route('daily-reports.index') }}">Report Harian</a></li>
                <li><a href="{{ route('meetings.index') }}">Meeting</a></li>
                <li>
                    <details>
                        <summary>Alat</summary>
                        <ul class="p-2 rounded-t-none bg-base-100">
                            <li><a class="text-md" href="{{ route('pdftools.merge') }}">PdfMerge</a></li>
                            <li><a class="text-md" href="{{route('pdftools.selected')}}" >PdfSelected</a></li>
                            <li><a class="text-md" href="{{route('splitbill')}}" >Split Bill</a></li>
                        </ul>
                    </details>
                </li>
                @role('PIC')
                    <li>
                        <details>
                            <summary>Pengaturan</summary>
                            <ul class="p-2 rounded-t-none bg-base-100">

                                <li><a href="{{ route('users.index') }}">User Management</a></li>
                                <li><a href="{{route('task-categories.index')}}" >Kategori Tugas</a></li>
                            </ul>
                        </details>
                    </li>
                @endrole
            </ul>
        </div>
        <a class="text-xl text-red-600 btn btn-ghost" href="{{ route('dashboard') }}">
            rca
        </a>
    </div>

    <div class="hidden navbar-center lg:flex">
        <ul class="px-1 menu menu-horizontal">
            <li><a href="{{ route('dashboard') }}">Beranda</a></li>
            <li><a href="{{ route('daily-reports.index') }}">Report Harian</a></li>
            <li><a href="{{ route('meetings.index') }}">Meeting</a></li>
            <li>
                <details>
                    <summary>Alat</summary>
                    <ul class="p-2 pb-2 rounded-t-none bg-base-100">
                        <li><a class="text-md" href="{{ route('pdftools.merge') }}">PdfMerge</a></li>
                        <li><a class="text-md" href="{{route('pdftools.selected')}}" >PdfSelected</a></li>
                    </ul>
                </details>
            </li>
            @role('dev')
            <li>
                <a href="{{ route('feedback')}}">Masukan User</a>
            </li>
            @endrole
            @role('PIC')
                <li>
                    <details>
                        <summary>Pengaturan</summary>
                        <ul class="p-2 rounded-t-none bg-base-100">
                            <li><a href="{{ route('users.index') }}">User Management</a></li>
                            <li><a href="{{route('task-categories.index')}}" >Kategori Tugas</a></li>
                        </ul>
                    </details>
                </li>
            @endrole
        </ul>
    </div>
    <div class="navbar-end">
        <div>
            <p>Hi! {{ ucwords(Str::before(auth()->user()->name, ' ')) }}</p>
        </div>
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <img alt="Null Foto Profil" src="{{ auth()->user()->path ? asset('storage/' . auth()->user()->path) : asset('image.webp') }}" />
                </div>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">

                <li>
                    <a href={{ route('profile.edit') }} class="justify-between">
                        Profil
                        {{-- <span class="badge text-accent">New</span> --}}
                    </a>
                </li>
                <li>
                    <div class="mr-4">
                        <a class="" onclick="feedback_modal.showModal()">Masukan</a>
                        <dialog id="feedback_modal" class="modal">
                            <div class="modal-box">
                                <h3 class="font-bold text-lg">Kirim Masukan untuk Aplikasi</h3>
                                <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Judul</span>
                                        </label>
                                        <input type="text" name="title" class="input input-bordered" required />
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Detail</span>
                                        </label>
                                        <textarea name="detail" class="textarea textarea-bordered" required></textarea>
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">File (Opsional)</span>
                                        </label>
                                        <input type="file" name="file" class="file-input file-input-bordered w-full" />
                                    </div>
                                    <div class="modal-action">
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                        <button type="button" class="btn" onclick="feedback_modal.close()">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </dialog>
                    </div>
                </li>

                <div class="dropdown dropdown-end">
                    <!-- Existing dropdown content -->
                </div>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button href={{ route('logout') }} class="text-red-500 hover:text-red-700">
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>


@if(session('feedback_success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('feedback_success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
