<?php

namespace App\Exports;

use App\Models\Alumni;
use App\Services\AlumniServices;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlumniExport implements FromCollection, WithHeadings
{

    protected array $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AlumniServices::getTracerStudy($this->filter);
    }

    public function headings(): array
    {
        return [
            '#',
            'email',
            'nim',
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'status_perkawinan',
            'nomor_kontak',
            'jalan',
            'desa_kelurahan',
            'kecamatan',
            'kabupaten_kota',
            'provinsi',
            'tahun_masuk_s1',
            'bulan_yudisium_s1',
            'tahun_lulus_s1',
            'ipk_s1',
            'bulan_masuk_pendidikan',
            'tahun_masuk_pendidikan',
            'tahun_yudisium_koaas_pra_yudisium',
            'ipk_profesi_dokter',
            'tahun_lulus_ukmppd',
            'periode_ujian_yang_dinyatakan_lulus_umkppd',
            'berapa_kali_mengikuti_ukmppd',
            'angkatan_pengambilan_sumpah_dokter',
            'bulan_dan_tahun_mulai_internship',
            'bulan_dan_tahun_selesai_internship',
            'wahana_internship',
            'kabupaten_kota_pelaksanaan_internship',
            'provinsi_pelaksanaan_internship',
            'pendapatan_rata_rata_per_bulan_saat_internship',
            'sumber_pendapatan_saat_internship',
            'fasilitas_yang_diberikan_wahana',
            'apakah_anda_sudah_bekerja',
            'lama_menanti_pekerjaan_pasca_internship',
            'tahun_mulai_bekerja',
            'bagaimana_cara_mendapatkan_pekerjaan_pertama',
            'berapa_perusahaan_yang_merespons_lamaran_anda',
            'pernahkah_anda_berpindah_perusahaan_tempat_bekerja',
            'nama_istitusi_tempat_anda_pernah_bekerja',
            'alasan_anda_pindah_tempat_pekerjaan',
            'leval_tingkatan_tempat_anda_bekerja',
            'kesesuaian_bidang_studi_dengan_perkerjaan_anda_sekarang',
            'status_pekerjaan_utama_saat_ini',
            'tempat_kerja',
            'jabatan_pada_tempat_kerja_saat_ini',
            'kota_kabupaten_tempat_pekerjaan_utama',
            'provinsi_tempat_pekerjaan_Utama',
            'informasi_pemimpin_instansi_tempat_utama_anda_bekerja)',
            'tahun_mulai_berkerja_pada_tempat_kerja_utama',
            'cara_mendapatkan_pekerjaan_utama_anda_saat_ini',
            'penghasilan_perbulan',
            'jenis_pendidikan_yang_ditempuh',
 
            'tahun_masuk',
            'tahun_keluar',
            'prodi_spesialisasi_subSpesialis_s2_yang_diambil',
            'fakultas_dan_universitas_tempat_studi_saat_ini',
            'mendapatkan_beasiswa',
            'asal_beasiswa_yang_diperoleh',
            'tempat_bekerja_sebelum_melanjutkan_study',
            'indeks_prestasi_akademik_menunjang_pengembangan_karir',
            'pengetahuan_yang_didapatkan_membantu_dalam_melakukan_pekerjaan',
            'pengetahuan_tambahan_yang_tidak_didapatkan_pada_kuliah',
            'ketrampilan_klinis_saat_kuliah_yang_menunjang_pekerjaan',
            'muatan_lokal_kurikulum_dokter_pulau_menunjang_pekerjaan',
            'ketrampilan_diluar_kuliah_dan_dibutuhkan_menunjang_pekerjaan',
            'reputasi_almamater_dan_akresitasi_program_studi_dan_institusi',
            'pengurusan_birokrasi_administrasi_alumni_yang_sudah_baik',
            'bimbinganbantuan_akademis',
            'hubungan_dengan_staff_pengajar',
            'kualitas_mengajar_dari_staff_pengajar',
            'dedikasi_dari_para_staff_pengajar',
            'kurikulumsilabussatuan_acara_perkuliahan',
            'perlengkapan_laboratorium',
            'pengadaan_material_pengajaran',
            'fasilitas_perpustakaan',
            'orientasi_praktis_dalam_pengajaran',
            'pelatihan_di_laboratorium',
            'praktek_di_lapangan_dan_instansi_kesehatan',
            'pelayanan_administrasi_akademik',
            'infrastruktur_secara_umum_ruang_kuliah_kantin_dll',
            'suasana_perkuliahan',
            'kegiatan_ekstra_kurikuler',
            'pengetahuan_di_bidang_atau_disiplin_ilmu',
            'pengetahuan_di_luar_bidang_atau_disiplin_ilmu_anda',
            'pengetahuan_umum',
            'kemampuan_berpikir_kritis_dan_menganalisis_masalah',
            'kemampuan_memecahkan_masalah',
            'kemampuan_adaptasi_teknologi_baru',
            'kemampuan_menulis_laporandokumen_dan_penulisan_efektif',
            'kemampuan_berkomunikasi_secara_lisan',
            'kefasihan_penggunaan_bahasa_asing',
            'keterampilan_komputer_dan_internet',
            'kemampuan_bekerja_secara_mandiri',
            'kemampuan_bekerja_dalam_tim_bekerja_dengan_orang_lain',
            'kedisiplinan',
            'etos_kerja',
            'motivasi_dan_inisiatif',
            'kemampuan_bekerja_dibawah_tekanan',
            'manajemen_waktu',
            'toleransi',
            'kepemimpinan',
            'loyalitas',
            'integritas',
            'managemen_programkegiatan',
            'kemampuan_belajar_sepanjang_hayat',
            'keterampilan_dalam_melaksanakan_tugas_pada_daerah_laut_pulau',
            'keterampilan_riset',
            'kemampuan_belajar',
            'kemampuan_beradaptasi',
            'bekerja_dengan_orang_yang_berbeda_budaya_maupun_latar_belakang',
            'kemampuan_dalam_memegang_tanggungjawab',
            'manajemen_proyekprogram',
            'kemampuan_untuk_memresentasikan_ideproduklaporan',
            'keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_interna',
            'berikan_saran_anda_dalam_pengembangan_bagian_interna',
            'keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_bedah',
            'berikan_saran_anda_dalam_pengembangan_bagian_bedah',
            'keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_pediatri',
            'berikan_saran_anda_dalam_pengembangan_bagian_pediatri',
            'keterampilan_dan_pengetahuan_obstetri_dan_ginekologi',
            'saran_anda_dalam_pengembangan_bagian_obstetri_dan_ginekologi',
            'keterampilan_dan_pengetahuan_neurologi',
            'saran_anda_dalam_pengembangan_bagian_neurologi',
            'keterampilan_dan_pengetahuan_tht',
            'saran_anda_dalam_pengembangan_bagian_tht',
            'keterampilan_dan_pengetahuan_mata',
            'saran_anda_dalam_pengembangan_bagian_mata',
            'keterampilan_dan_pengetahuan_dermatovenerologi',
            'saran_anda_dalam_pengembangan_bagian_dermatovenerologi',
            'keterampilan_dan_pengetahuan_psikiatri',
            'saran_anda_dalam_pengembangan_bagian_psikiatri',
            'keterampilan_dan_pengetahuan_anestesi',
            'saran_anda_dalam_pengembangan_bagian_anestesi',
            'keterampilan_dan_pengetahuan_ikm',
            'saran_anda_dalam_pengembangan_bagian_ikm',
            'keterampilan_dan_pengetahuan_radiologi',
            'saran_anda_dalam_pengembangan_bagian_radiologi',
            'keterampilan_dan_pengetahuan_forensik',
            'masukan_bagi_pengembangan_kemajuan_fk_unpatti',

            // 'latitude',
            // 'longitude',

            // 'photo',
            // 'created_at',
            // 'updated_at',
        ];
    }

}
