<?php

namespace Database\Seeders;

use App\Models\TaskCategory;
use Illuminate\Database\Seeder;

class TaskCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // [
            //     'name' => 'Callslog',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Cek Data yang seharusnya tidak di Return / Reject',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Cek Dokumen Kelengkapan',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Cek kelengkapan dokumen return',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Cek Notifikasi Return dan Reject',
            //     'has_batch' => false,
            //     'has_claim' => false,
            //     'has_time_range' => true,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            [
                'name' => 'Filling Provider',
                'has_batch' => true,
                'has_claim' => false,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => false
            ],
            [
                'name' => 'Filling Reimbursement',
                'has_batch' => true,
                'has_claim' => false,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => false
            ],
            [
                'name' => 'Follow Up Email',
                'has_batch' => false,
                'has_claim' => false,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => true,
                'has_form' => false,
                'has_dor_date' => false
            ],
            [
                'name' => 'Follow Up RS',
                'has_batch' => false,
                'has_claim' => true,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => false
            ],
            // [
            //     'name' => 'Input Approve klaim Reject kadaluarsa',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => true
            // ],
            // [
            //     'name' => 'Input Reject Reguler REL 2',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Input Reject Softcopy REL 2',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Input Return Reguler REL 2',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Input Return Softcopy REL 2',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Koordinasi Internal',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Membagikan Dokumen Scan AdMedika',
            //     'has_batch' => false,
            //     'has_claim' => false,
            //     'has_time_range' => true,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Membuka Amplop dan COP Dokumen AdMedika',
            //     'has_batch' => false,
            //     'has_claim' => false,
            //     'has_time_range' => true,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Membuka Dokumen Provider DOR 10 Desember 2024',
            //     'has_batch' => false,
            //     'has_claim' => false,
            //     'has_time_range' => true,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => true
            // ],
            // [
            //     'name' => 'Mengambil Dokumen Provider di Receptionist',
            //     'has_batch' => false,
            //     'has_claim' => false,
            //     'has_time_range' => true,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Mencari Dokumen Permintaan by Analyst',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Mencari Dokumen Surat Return, Reject dan Pending Rel 2',
            //     'has_batch' => false,
            //     'has_claim' => false,
            //     'has_time_range' => true,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Merger Dokumen',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Pengecekan & Rekap Pengembalian Dokumen Di Internal ARI',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Pengajuan Form Konsiderasi & Form Error Internal',
            //     'has_batch' => false,
            //     'has_claim' => false,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => true,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Permintaan Akseptasi',
            //     'has_batch' => true,
            //     'has_claim' => false,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Proses ulang Claim Photo',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Proses ulang Reguler REL 2',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Proses ulang Softcopy REL 2',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Re-Register & Reject',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => true
            // ],
            // [
            //     'name' => 'Reclaim Reject Claim Photo',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Reclaim Reject Regular',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Reclaim Reject Softcopy',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            // [
            //     'name' => 'Registrasi & Merger Klaim Direct Payment',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            [
                'name' => 'Registrasi Dokumen AdMedika',
                'has_batch' => true,
                'has_claim' => true,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => true
            ],
            [
                'name' => 'Registrasi Dokumen Provider',
                'has_batch' => true,
                'has_claim' => true,
                'has_time_range' => true,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => true
            ],
            [
                'name' => 'Registrasi Klaim Softcopy',
                'has_batch' => true,
                'has_claim' => true,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => true
            ],
            // [
            //     'name' => 'Reproses approve reject',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
            [
                'name' => 'Reprosess Approve/Reject',
                'has_batch' => false,
                'has_claim' => true,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => false
            ],
            [
                'name' => 'Scan Dokumen AdMedika',
                'has_batch' => true,
                'has_claim' => true,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => true
            ],
            [
                'name' => 'Scan Dokumen Isomedik',
                'has_batch' => true,
                'has_claim' => true,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => true
            ],
            [
                'name' => 'Scan Dokumen Provider',
                'has_batch' => true,
                'has_claim' => true,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => true
            ],
            [
                'name' => 'Jumlah angka scanner',
                'has_batch' => false,
                'has_claim' => false,
                'has_time_range' => false,
                'has_sheets' => true,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => false
            ],
            // [
            //     'name' => 'Download Data Penggesekan ARI Daily Transaction',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => true
            // ],
            [
                'name' => 'Download dan Upload Data AdMedika',
                'has_batch' => true,
                'has_claim' => true,
                'has_time_range' => false,
                'has_sheets' => false,
                'has_email' => false,
                'has_form' => false,
                'has_dor_date' => true
            ],
            // [
            //     'name' => 'Upload Data Ke AdMedika',
            //     'has_batch' => false,
            //     'has_claim' => true,
            //     'has_time_range' => false,
            //     'has_sheets' => false,
            //     'has_email' => false,
            //     'has_form' => false,
            //     'has_dor_date' => false
            // ],
        ];

        foreach ($categories as $category) {
            TaskCategory::create($category);
        }
    }
}

