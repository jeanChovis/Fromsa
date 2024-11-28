{{--<!doctype html>--}}
{{--<html lang="es">--}}
{{--<head>--}}
{{--<meta charset="UTF-8">--}}
{{--<meta name="viewport"--}}
{{--content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--<meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--<link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css ')}}">--}}
{{--<!-- Font Awesome -->--}}
{{--<link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css')}} ">--}}
{{--<!-- Ionicons -->--}}
{{--<link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css')}} ">--}}

{{--<title>Product Masuk Exports All PDF</title>--}}
{{--</head>--}}
{{--<body>--}}
<style>
    #supplier {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #supplier td, #supplier th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #supplier tr:nth-child(even){background-color: #f2f2f2;}

    #supplier tr:hover {background-color: #ddd;}

    #supplier th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>

<table id="supplier" width="100%">
    <thead>
    <tr>
        <td>RUC</td>
        <td>Nombre</td>
        <td>Dirección</td>
        <td>Correo</td>
    </tr>
    </thead>
    @foreach($supplier as $s)
        <tbody>
        <tr>
            <td>{{ $s->ruc }}</td>
            <td>{{ $s->company_name }}</td>
            <td>{{ $s->address }}</td>
            <td>{{ $s->email }}</td>
        </tr>
        </tbody>
    @endforeach

</table>


{{--<!-- jQuery 3 -->--}}
{{--<script src="{{  asset('assets/bower_components/jquery/dist/jquery.min.js') }} "></script>--}}
{{--<!-- Bootstrap 3.3.7 -->--}}
{{--<script src="{{  asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }} "></script>--}}
{{--<!-- AdminLTE App -->--}}
{{--<script src="{{  asset('assets/dist/js/adminlte.min.js') }}"></script>--}}
{{--</body>--}}
{{--</html>--}}


