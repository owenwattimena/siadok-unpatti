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
            'email_address',
            'nim',
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'status_perkawinan',
            'nomor_kontak',
            'jalan',
            'desakelurahan',

            'kecamatan',
            'kabupatenkota',
            'provinsi',
            'tahun_masuk_s1',
            'bulan_yudisium_s1',
            'tahun_lulus_s1',
            'ipk_s1',
            'bulan_masuk_pendidikan_profesi_dokter',
            'tahun_masuk_pendidikan_profesi_dokter',
            'tahun_yudisium_koaas_pra_yudisium',

            'ipk_profesi_dokter',
            'tahun_lulus_ukmppd',
            'periode_ujian_yang_dinyatakan_lulus_ukmppd',
            'berapa_kali_anda_mengikuti_ukmppd',
            'angkatan_pengambilan_sumpah_dokter_ke',
            'bulan_dan_tahun_mulai_internship',
            'bulan_dan_tahun_selesai_internship',
            'wahana_internship',
            'kabupaten_kota_pelaksanaan_internship',
            'provinsi_pelaksanaan_internship',

            'pendapatan_rata_rata_per_bulan_saat_internship',
            'sumber_pendapatan_saat_internship',
            'fasilitas_yang_diberikan_wahana',
            'apakah_anda_sudah_bekerja_jika_belum_bekerja_silahkan_lanjut_pada_bagian_pendidikan_selanjutnya',
            'berapa_bulan_waktu_yang_anda_habiskan_untuk_mendapatkan_pekerjaan_pertama_setelah_masa_internship_selesai',
            'tahun_mulai_bekerja',
            'bagaimana_cara_anda_mendapatkan_pekerjaan_pertama',
            'berapa_perusahaaninstansiinstitusi_yang_sudah_anda_lamar_lewat_surat_atau_e_mail_sebelum_anda_memperoleh_pekerjaan_pertama',
            'pernahkah_anda_berpindah_perusahaaninstansiinstitusi_tempat_bekerja',
            'nama_istitusi_tempat_anda_pernah_bekerja',

            'apa_alasan_anda_tempat_pindah_pekerjaan',
            'apakah_level_tingkaan_tempat_anda_bekerja',
            'bagaimanakah_kesesuaian_bidang_studi_anda_dengan_perkerjaan_anda_sekarang',
            'status_pekerjaan_utama_saat_ini',
            'tempat_kerja',
            'jabatan_pada_tempat_kerja_saat_ini',
            'latitude',
            'longitude',
            'kota_kabupaten_tempat_pekerjaan_utama',
            'provinsi_tempat_pekerjaan_utama',

            'mohon_menuliskan_nama_dan_nomor_telepone_mail_pemimpin_instansi_tempat_anda_bekerja_tempat_pekerjaan_utama',
            'tahun_mulai_berkerja_pada_tempat_kerja_utama_anda_saat_ini',
            'bagaimana_cara_anda_mendapatkan_pekerjaan_pekerjaan_utama_anda_saat_ini',
            'penghasilan_perbulan',
            'jenis_pendidikan_yang_ditempuh',
            'tahun_masuk',
            'tahun_keluar',
            'program_studi_spesialisasi_sub_spesialis_s2_yang_diambil',
            'fakultas_dan_universitas_tempat_studi_saat_ini',
            'mendapatkan_beasiswa',

            'asal_beasiswa_yang_diperoleh',
            'tempat_bekerja_sebelum_melanjutkan_study',
            'indeks_prestasi_akademik_transkrip_menunjang_pengembangan_karir_saya',
            'pengetahuan_yang_didapatkan_aplikatif_sehingga_sangat_membantu_dalam_melakukan_pekerjaan',
            'masih_diperlukan_pengetahuan_tambahan_lainnya_yang_tidak_didapatkan_pada_kuliah_untuk_membantu_melakukan_pekerjaan_saya',
            'ketrampilan_klinis_yang_diperoleh_semasa_kuliah_dan_pendidikan_profesi_dapat_digunakan_dengan_baik_serta_menunjang_pekerjaan_saya',
            'muatan_lokal_dalam_kurikulum_fk_unpatti_dokter_pulau_sangat_menunjang_pekerjaan_saya',
            'ketrampilan_klinis_yang_diperoleh_diluar_bangku_kuliah_dan_pendidikan_profesi_masih_dibutuhkan_dalam_menunjang_pekerjaan_saya',
            'reputasi_almamater_dan_akresitasi_program_studi_dan_institusi_mempengaruhi_pekerjaan_serta_perkembangan_karir_saya',
            'pengurusan_birokrasi_dan_administrasi_bagi_alumni_yang_sudah_baik',

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
            'pengetahuan_di_bidang_atau_disiplin_ilmu_anda',
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
            'hubungan_sosial',
            'manajemen_waktu',
            'negosiasi',
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
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_interna_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_interna',
            
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_bedah_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_bedah',
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_pediatri_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_pediatri',
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_obstetri_dan_ginekologi_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_obstetri_dan_ginekologi',
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_neurologi_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_neurologi',
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_tht_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_tht',
            
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_mata_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_mata',
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_dermatovenerologi_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_dermatovenerologi',
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_psikiatri_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_psikiatri',
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_anestesi_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_anestesi',
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_ikm_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_ikm',
           
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_radiologi_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikan_saran_anda_dalam_pengembangan_bagian_radiologi',
            'menurut_anda_apakah_keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_forensik_selama_kepaniteraan_klinik_sudah_mencukupi_kebutuhan_selama_bekerja',
            'berikanlah_masukan_anda_bagi_pengembangan_dan_kemajuan_fk_unpatti',
        ];

    }//143 data

}
