<?php

namespace App\Imports;

use App\Models\Alumni;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumniImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            // dd($row);
            $timestamp = $row['tanggal_lahir'];
            $tanggal_lahir = date('Y-m-d', mktime(0,0,0,1,$timestamp-1,1900));
            $data = [
                'email'             => $row['email_address'],
                'nama_lengkap'      => $row['nama_lengkap'],
                'tempat_lahir'      => $row['tempat_lahir'],
                'tanggal_lahir'     => $tanggal_lahir,
                'jenis_kelamin'     => $row['jenis_kelamin'],
                'status_perkawinan' => $row['status_perkawinan'],
                'nomor_kontak'      => $row['nomor_kontak'],
                'jalan'             => $row['jalan'],
                'desa_kelurahan'    => $row['desakelurahan'],
                'kecamatan'         => $row['kecamatan'],
                'kabupaten_kota'    => $row['kabupatenkota'],
                'provinsi'          => $row['provinsi'],
                'tahun_masuk_s1'    => $row['tahun_masuk_s1'],
                'bulan_yudisium_s1' => $row['bulan_yudisium_s1'],
                'tahun_lulus_s1'    => $row['tahun_lulus_s1'],
                'ipk_s1'            => $row['ipk_s1'],
                'bulan_masuk_pendidikan' => $row['bulan_masuk_pendidikan_profesi_dokter'],
                'tahun_masuk_pendidikan' => $row['tahun_masuk_pendidikan_profesi_dokter'],
                'tahun_yudisium_koaas_pra_yudisium' => $row['tahun_yudisium_koaas_pra_yudisium'],
                'ipk_profesi_dokter'=> $row['ipk_profesi_dokter'],
                'tahun_lulus_ukmppd'=> $row['tahun_lulus_ukmppd'],
                'periode_ujian_yang_dinyatakan_lulus_umkppd' => $row['periode_ujian_yang_dinyatakan_lulus_ukmppd'],
                'berapa_kali_mengikuti_ukmppd'       => $row['berapa_kali_anda_mengikuti_ukmppd'],
                'angkatan_pengambilan_sumpah_dokter' => $row['angkatan_pengambilan_sumpah_dokter_ke'],
                'bulan_dan_tahun_mulai_internship'   => $row['bulan_dan_tahun_mulai_internship'],
                'bulan_dan_tahun_selesai_internship' => $row['bulan_dan_tahun_selesai_internship'],
                'wahana_internship' => $row['wahana_internship'],
                'kabupaten_kota_pelaksanaan_internship' => $row['kabupaten_kota_pelaksanaan_internship'],
                'provinsi_pelaksanaan_internship' => $row['provinsi_pelaksanaan_internship'],
                'pendapatan_rata_rata_per_bulan_saat_internship' => $row['pendapatan_rata_rata_per_bulan_saat_internship'],
                'pendapatan_rata_rata_per_bulan_saat_internship' => $row['sumber_pendapatan_saat_internship'],
                'sumber_pendapatan_saat_internship' => $row['sumber_pendapatan_saat_internship'],
                'fasilitas_yang_diberikan_wahana' => $row['fasilitas_yang_diberikan_wahana'],
                'apakah_anda_sudah_bekerja' => $row['apakah_anda_sudah_bekerja_jika_belum_bekerja_silahkan_lanjut_pada_bagian_pendidikan_selanjutnya'],
                'lama_menanti_pekerjaan_pasca_internship' => $row['berapa_bulan_waktu_yang_anda_habiskan_untuk_mendapatkan_pekerjaan_pertama_setelah_masa_internship_selesai'],
                'tahun_mulai_bekerja' => $row['tahun_mulai_bekerja'],
                'bagaimana_cara_mendapatkan_pekerjaan_pertama' => $row['bagaimana_cara_anda_mendapatkan_pekerjaan_pertama'],
                'berapa_perusahaan_yang_merespons_lamaran_anda' => $row['berapa_perusahaaninstansiinstitusi_yang_sudah_anda_lamar_lewat_surat_atau_e_mail_sebelum_anda_memperoleh_pekerjaan_pertama'],
                'pernahkah_anda_berpindah_perusahaan_tempat_bekerja' => $row['pernahkah_anda_berpindah_perusahaaninstansiinstitusi_tempat_bekerja'],
                'nama_istitusi_tempat_anda_pernah_bekerja' => $row['nama_istitusi_tempat_anda_pernah_bekerja'],
                'alasan_anda_pindah_tempat_pekerjaan' => $row['apa_alasan_anda_tempat_pindah_pekerjaan'],
                'leval_tingkatan_tempat_anda_bekerja' => $row['apakah_level_tingkaan_tempat_anda_bekerja'],
                'kesesuaian_bidang_studi_dengan_perkerjaan_anda_sekarang' => $row['bagaimanakah_kesesuaian_bidang_studi_anda_dengan_perkerjaan_anda_sekarang'],
                'status_pekerjaan_utama_saat_ini' => $row['status_pekerjaan_utama_saat_ini'],
                'tempat_kerja' => $row['tempat_kerja'],
                'jabatan_pada_tempat_kerja_saat_ini' => $row['jabatan_pada_tempat_kerja_saat_ini'],
                'jabatan_pada_tempat_kerja_saat_ini' => $row[''],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                'kota_kabupaten_tempat_pekerjaan_utama' => $row['kota_kabupaten_tempat_pekerjaan_utama'],
                'provinsi_tempat_pekerjaan_Utama' => $row['provinsi_tempat_pekerjaan_utama'],
                'informasi_pemimpin_instansi_tempat_utama_anda_bekerja' => $row['mohon_menuliskan_nama_dan_nomor_telepone_mail_pemimpin_instansi_tempat_anda_bekerja_tempat_pekerjaan_utama'],
                'tahun_mulai_berkerja_pada_tempat_kerja_utama' => $row['tahun_mulai_berkerja_pada_tempat_kerja_utama_anda_saat_ini'],
                'cara_mendapatkan_pekerjaan_utama_anda_saat_ini' => $row['bagaimana_cara_anda_mendapatkan_pekerjaan_pekerjaan_utama_anda_saat_ini'],
                'penghasilan_perbulan' => $row['penghasilan_perbulan'],
                'jenis_pendidikan_yang_ditempuh' => $row['jenis_pendidikan_yang_ditempuh'],
                'tahun_masuk' => $row['tahun_masuk'],
                'tahun_keluar' => $row['tahun_keluar'],
                'prodi_spesialisasi_subSpesialis_s2_yang_diambil' => $row['program_studi_spesialisasi_sub_spesialis_s2_yang_diambil'],
                'fakultas_dan_universitas_tempat_studi_saat_ini' => $row['fakultas_dan_universitas_tempat_studi_saat_ini'],
                'mendapatkan_beasiswa' => $row['mendapatkan_beasiswa'],
                'asal_beasiswa_yang_diperoleh' => $row['asal_beasiswa_yang_diperoleh'],
                'tempat_bekerja_sebelum_melanjutkan_study' => $row['tempat_bekerja_sebelum_melanjutkan_study'],
                'indeks_prestasi_akademik_menunjang_pengembangan_karir' => $row['indeks_prestasi_akademik_transkrip_menunjang_pengembangan_karir_saya'],
                'pengetahuan_yang_didapatkan_membantu_dalam_melakukan_pekerjaan' => $row['pengetahuan_yang_didapatkan_aplikatif_sehingga_sangat_membantu_dalam_melakukan_pekerjaan'],
                'pengetahuan_tambahan_yang_tidak_didapatkan_pada_kuliah' => $row['masih_diperlukan_pengetahuan_tambahan_lainnya_yang_tidak_didapatkan_pada_kuliah_untuk_membantu_melakukan_pekerjaan_saya'],
                'ketrampilan_klinis_saat_kuliah_yang_menunjang_pekerjaan' => $row['ketrampilan_klinis_yang_diperoleh_semasa_kuliah_dan_pendidikan_profesi_dapat_digunakan_dengan_baik_serta_menunjang_pekerjaan_saya'],
                'muatan_lokal_kurikulum_dokter_pulau_menunjang_pekerjaan' => $row['muatan_lokal_dalam_kurikulum_fk_unpatti_dokter_pulau_sangat_menunjang_pekerjaan_saya'],
                'ketrampilan_diluar_kuliah_dan_dibutuhkan_menunjang_pekerjaan' => $row['ketrampilan_klinis_yang_diperoleh_diluar_bangku_kuliah_dan_pendidikan_profesi_masih_dibutuhkan_dalam_menunjang_pekerjaan_saya'],
                'reputasi_almamater_dan_akresitasi_program_studi_dan_institusi' => $row['reputasi_almamater_dan_akresitasi_program_studi_dan_institusi_mempengaruhi_pekerjaan_serta_perkembangan_karir_saya'],
                'pengurusan_birokrasi_administrasi_alumni_yang_sudah_baik' => $row['pengurusan_birokrasi_dan_administrasi_bagi_alumni_yang_sudah_baik'],
                'bimbinganbantuan_akademis' => $row['bimbinganbantuan_akademis'],
                'hubungan_dengan_staff_pengajar' => $row['hubungan_dengan_staff_pengajar'],
                'kualitas_mengajar_dari_staff_pengajar' => $row['kualitas_mengajar_dari_staff_pengajar'],
                'dedikasi_dari_para_staff_pengajar' => $row['dedikasi_dari_para_staff_pengajar'],
                'kurikulumsilabussatuan_acara_perkuliahan' => $row['kurikulumsilabussatuan_acara_perkuliahan'],
                'perlengkapan_laboratorium' => $row['perlengkapan_laboratorium'],
                'pengadaan_material_pengajaran' => $row['pengadaan_material_pengajaran'],
                
                
            ];
            $alumni = Alumni::where('nim', $row['nim'])->first();

            if($alumni){
                DB::table('alumni')->where('nim', $row['nim'])->update($data);
            }else{
                $data['nim'] = $row['nim'];
                $alumni = Alumni::insert($data);
            }
        }
    }
}
