<!DOCTYPE html>
<html>
<head>
    <title>LAPORAN ALUMNI</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <style type="text/css">
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
            border: 1px solid black !important;
        }
        .border-hide {
            border-left-color: white !important;
            border-bottom-color: white !important;
        }
    </style>
    <center>
        <h1>LAPORAN ALUMNI<br>MAHASISWA KEDOKTERAN<br>UNIVERSITAS PATTIMURA</h1>
    </center>
    {!! $filter !!}
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th style="width: 30px">NO</th>
                <th>NIM</th>
                <th>NAMA</th>
                <th>TAHUN MASUK</th>
                <th>TAHUN LULUS</th>
                <th>KOTA</th>
                <th>TEMPAT KERJA</th>
                <th>PEKERJAAN SEBELUMNYA</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($alumnus as $key => $item)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $item->nim }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->entry_year }}</td>
                <td>{{ $item->graduation_year }}</td>
                <td>{{ $item->city_name }}</td>
                <td>{{ $item->workplace_name }}</td>
                <td>{{ $item->previous_job }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
