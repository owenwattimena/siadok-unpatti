<!DOCTYPE html>
<html>
<head>
    <title>LAPORAN ALUMNI</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <style type="text/css">
        body { margin: 0px; }
        * {
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: 12px !important;
        }
        hr {
            border-top: 3px solid black;
        }
        h1 {
            font-weight: bold;
        }
        #table,
        #table th,
        #table td {
            border: 0.3px solid #444444 !important;
        }
        #table th, .center{
            text-align: center;
        }
    </style>
    <center>
        <h1>LAPORAN ALUMNI<br>MAHASISWA KEDOKTERAN<br>UNIVERSITAS PATTIMURA</h1>
    </center>
    {!! $filter !!}
    <br>
    <table class='table table-bordered' id="table">
        <thead>
            <tr>
                <th style="width: 30px">NO</th>
                <th>NIM</th>
                <th>NAMA</th>
                <th>TAHUN MASUK</th>
                <th>TAHUN LULUS</th>
                <th>KOTA</th>
                <th>TEMPAT KERJA</th>
                <th>WAHANA INTERNSHIP</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($alumnus as $key => $item)
            <tr>
                <td class="center">{{ $i++ }}</td>
                <td class="center">{{ $item->nim }}</td>
                <td>{{ $item->nama_lengkap }}</td>
                <td class="center">{{ $item->tahun_masuk_s1 }}</td>
                <td class="center">{{ $item->tahun_lulus_s1 }}</td>
                <td>{{ $item->kota_kabupaten }}</td>
                <td>{{ $item->tempat_kerja }}</td>
                <td>{{ $item->wahana_internship }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
