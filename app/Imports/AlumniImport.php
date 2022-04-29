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
                
                
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
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
