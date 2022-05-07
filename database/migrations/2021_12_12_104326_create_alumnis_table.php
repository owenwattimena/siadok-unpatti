<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();


            $table->text('email')->nullable();
            $table->string('nim')->unique();
            $table->text('nama_lengkap')->nullable();
            $table->text('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('jenis_kelamin')->nullable();
            $table->text('status_perkawinan')->nullable();
            $table->text('nomor_kontak')->nullable();
            $table->text('jalan')->nullable();
            $table->text('desa_kelurahan')->nullable();

            $table->text('kecamatan')->nullable();
            $table->text('kabupaten_kota')->nullable();
            $table->text('provinsi')->nullable();
            $table->integer('tahun_masuk_s1')->nullable();
            $table->text('bulan_yudisium_s1')->nullable();
            $table->integer('tahun_lulus_s1')->nullable();
            $table->text('ipk_s1')->nullable();
            $table->text('bulan_masuk_pendidikan')->nullable();
            $table->integer('tahun_masuk_pendidikan')->nullable();
            $table->integer('tahun_yudisium_koaas_pra_yudisium')->nullable();
           
            $table->text('ipk_profesi_dokter')->nullable(); 
            $table->integer('tahun_lulus_ukmppd')->nullable();
            $table->text('periode_ujian_yang_dinyatakan_lulus_umkppd')->nullable();
            $table->text('berapa_kali_mengikuti_ukmppd')->nullable();
            $table->integer('angkatan_pengambilan_sumpah_dokter')->nullable();
            $table->text('bulan_dan_tahun_mulai_internship')->nullable();
            $table->text('bulan_dan_tahun_selesai_internship')->nullable();
            $table->text('wahana_internship')->nullable();
            $table->text('kabupaten_kota_pelaksanaan_internship')->nullable();
            $table->text('provinsi_pelaksanaan_internship')->nullable();

            $table->text('pendapatan_rata_rata_per_bulan_saat_internship')->nullable();
            $table->text('sumber_pendapatan_saat_internship')->nullable();
            $table->text('fasilitas_yang_diberikan_wahana')->nullable();
            $table->text('apakah_anda_sudah_bekerja')->nullable();
            $table->text('lama_menanti_pekerjaan_pasca_internship')->nullable();
            $table->text('tahun_mulai_bekerja')->nullable();
            $table->text('bagaimana_cara_mendapatkan_pekerjaan_pertama')->nullable();
            $table->text('berapa_perusahaan_yang_merespons_lamaran_anda')->nullable();
            $table->text('pernahkah_anda_berpindah_perusahaan_tempat_bekerja')->nullable();
            $table->text('nama_istitusi_tempat_anda_pernah_bekerja')->nullable();

            $table->text('alasan_anda_pindah_tempat_pekerjaan')->nullable();
            $table->text('leval_tingkatan_tempat_anda_bekerja')->nullable();
            $table->text('kesesuaian_bidang_studi_dengan_perkerjaan_anda_sekarang')->nullable();
            $table->text('status_pekerjaan_utama_saat_ini')->nullable();
            $table->text('tempat_kerja')->nullable();
            $table->text('jabatan_pada_tempat_kerja_saat_ini')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('kota_kabupaten_tempat_pekerjaan_utama')->nullable();
            $table->text('provinsi_tempat_pekerjaan_Utama')->nullable();

            $table->text('informasi_pemimpin_instansi_tempat_utama_anda_bekerja')->nullable();
            $table->text('tahun_mulai_berkerja_pada_tempat_kerja_utama')->nullable();
            $table->text('cara_mendapatkan_pekerjaan_utama_anda_saat_ini')->nullable();
            $table->text('penghasilan_perbulan')->nullable();
            $table->text('jenis_pendidikan_yang_ditempuh')->nullable();
            $table->text('tahun_masuk')->nullable();
            $table->text('tahun_keluar')->nullable();
            $table->text('prodi_spesialisasi_subSpesialis_s2_yang_diambil')->nullable();
            $table->text('fakultas_dan_universitas_tempat_studi_saat_ini')->nullable();
            $table->text('mendapatkan_beasiswa')->nullable();
           
            $table->text('asal_beasiswa_yang_diperoleh')->nullable();
            $table->text('tempat_bekerja_sebelum_melanjutkan_study')->nullable();
            $table->integer('indeks_prestasi_akademik_menunjang_pengembangan_karir')->nullable();
            $table->integer('pengetahuan_yang_didapatkan_membantu_dalam_melakukan_pekerjaan')->nullable();
            $table->integer('pengetahuan_tambahan_yang_tidak_didapatkan_pada_kuliah')->nullable();
            $table->integer('ketrampilan_klinis_saat_kuliah_yang_menunjang_pekerjaan')->nullable();
            $table->integer('muatan_lokal_kurikulum_dokter_pulau_menunjang_pekerjaan')->nullable();
            $table->integer('ketrampilan_diluar_kuliah_dan_dibutuhkan_menunjang_pekerjaan')->nullable();
            $table->integer('reputasi_almamater_dan_akresitasi_program_studi_dan_institusi')->nullable();
            $table->integer('pengurusan_birokrasi_administrasi_alumni_yang_sudah_baik')->nullable();
          
            $table->integer('bimbinganbantuan_akademis')->nullable();  
            $table->integer('hubungan_dengan_staff_pengajar')->nullable();
            $table->integer('kualitas_mengajar_dari_staff_pengajar')->nullable();
            $table->integer('dedikasi_dari_para_staff_pengajar')->nullable();
            $table->integer('kurikulumsilabussatuan_acara_perkuliahan')->nullable();
            $table->integer('perlengkapan_laboratorium')->nullable();
            $table->integer('pengadaan_material_pengajaran')->nullable();
            $table->integer('fasilitas_perpustakaan')->nullable();
            $table->integer('orientasi_praktis_dalam_pengajaran')->nullable();
            $table->integer('pelatihan_di_laboratorium')->nullable();
            
            $table->integer('praktek_di_lapangan_dan_instansi_kesehatan')->nullable();
            $table->integer('pelayanan_administrasi_akademik')->nullable();
            $table->integer('infrastruktur_secara_umum_ruang_kuliah_kantin_dll')->nullable();
            $table->integer('suasana_perkuliahan')->nullable();
            $table->integer('kegiatan_ekstra_kurikuler')->nullable();
            $table->integer('pengetahuan_di_bidang_atau_disiplin_ilmu')->nullable();
            $table->integer('pengetahuan_di_luar_bidang_atau_disiplin_ilmu_anda')->nullable();
            $table->integer('pengetahuan_umum')->nullable();
            $table->integer('kemampuan_berpikir_kritis_dan_menganalisis_masalah')->nullable();
            $table->integer('kemampuan_memecahkan_masalah')->nullable();
            
            $table->integer('kemampuan_adaptasi_teknologi_baru')->nullable();
            $table->integer('kemampuan_menulis_laporandokumen_dan_penulisan_efektif')->nullable();
            $table->integer('kemampuan_berkomunikasi_secara_lisan')->nullable();
            $table->integer('kefasihan_penggunaan_bahasa_asing')->nullable();
            $table->integer('keterampilan_komputer_dan_internet')->nullable();
            $table->integer('kemampuan_bekerja_secara_mandiri')->nullable();
            $table->integer('kemampuan_bekerja_dalam_tim_bekerja_dengan_orang_lain')->nullable();
            $table->integer('kedisiplinan')->nullable();
            $table->integer('etos_kerja')->nullable();
            $table->integer('motivasi_dan_inisiatif')->nullable();
            
            $table->integer('kemampuan_bekerja_dibawah_tekanan')->nullable();
            $table->integer('hubungan_sosial')->nullable();
            $table->integer('manajemen_waktu')->nullable();
            $table->integer('negosiasi')->nullable();
            $table->integer('toleransi')->nullable();
            $table->integer('kepemimpinan')->nullable();
            $table->integer('loyalitas')->nullable();
            $table->integer('integritas')->nullable();
            $table->integer('managemen_programkegiatan')->nullable();
            $table->integer('kemampuan_belajar_sepanjang_hayat')->nullable();
            
            $table->integer('keterampilan_dalam_melaksanakan_tugas_pada_daerah_laut_pulau')->nullable();
            $table->integer('keterampilan_riset')->nullable();
            $table->integer('kemampuan_belajar')->nullable();
            $table->integer('kemampuan_beradaptasi')->nullable();
            $table->integer('bekerja_dengan_orang_yang_berbeda_budaya_maupun_latar_belakang')->nullable();
            $table->integer('kemampuan_dalam_memegang_tanggungjawab')->nullable();
            $table->integer('manajemen_proyekprogram')->nullable();
            $table->integer('kemampuan_untuk_memresentasikan_ideproduklaporan')->nullable();
            $table->integer('keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_interna')->nullable();
            $table->text('berikan_saran_anda_dalam_pengembangan_bagian_interna')->nullable();
            
            $table->integer('keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_bedah')->nullable();
            $table->text('berikan_saran_anda_dalam_pengembangan_bagian_bedah')->nullable();
            $table->integer('keterampilan_dan_pengetahuan_yang_dapatkan_pada_bagian_pediatri')->nullable();
            $table->text('berikan_saran_anda_dalam_pengembangan_bagian_pediatri')->nullable();
            $table->integer('keterampilan_dan_pengetahuan_obstetri_dan_ginekologi')->nullable();
            $table->text('saran_anda_dalam_pengembangan_bagian_obstetri_dan_ginekologi')->nullable();
            $table->integer('keterampilan_dan_pengetahuan_neurologi')->nullable();
            $table->text('saran_anda_dalam_pengembangan_bagian_neurologi')->nullable();
            $table->integer('keterampilan_dan_pengetahuan_tht')->nullable();
            $table->text('saran_anda_dalam_pengembangan_bagian_tht')->nullable();
            
            $table->integer('keterampilan_dan_pengetahuan_mata')->nullable();
            $table->text('saran_anda_dalam_pengembangan_bagian_mata')->nullable();
            $table->integer('keterampilan_dan_pengetahuan_dermatovenerologi')->nullable();
            $table->text('saran_anda_dalam_pengembangan_bagian_dermatovenerologi')->nullable();
            $table->integer('keterampilan_dan_pengetahuan_psikiatri')->nullable();
            $table->text('saran_anda_dalam_pengembangan_bagian_psikiatri')->nullable();
            $table->integer('keterampilan_dan_pengetahuan_anestesi')->nullable();
            $table->text('saran_anda_dalam_pengembangan_bagian_anestesi')->nullable();
            $table->integer('keterampilan_dan_pengetahuan_ikm')->nullable();
            $table->text('saran_anda_dalam_pengembangan_bagian_ikm')->nullable();
            
            $table->integer('keterampilan_dan_pengetahuan_radiologi')->nullable();
            $table->text('saran_anda_dalam_pengembangan_bagian_radiologi')->nullable();
            $table->integer('keterampilan_dan_pengetahuan_forensik')->nullable();
            $table->text('masukan_bagi_pengembangan_kemajuan_fk_unpatti')->nullable();


            $table->text('photo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumni');
    }
}
