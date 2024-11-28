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

    {{--<title>Product entry Exports All PDF</title>--}}
{{--</head>--}}
{{--<body>--}}
    <style>
        #product-entry {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #product-entry td, #product-entry th {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        #product-entry tr:nth-child(even){background-color: #f2f2f2;}

        #product-entry tr:hover {background-color: #ddd;}

        #product-entry th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #D81B60;
            color: white;
        }
    </style>
<div class="table-container">
    <table id="product-entry" width="100%">
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Cantidad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product_entry as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->product->name }}</td>
                    <td>{{ $p->supplier->company_name }}</td>
                    <td>{{ $p->amount }}</td>
                    <td>{{ $p->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


    {{--<!-- jQuery 3 -->--}}
    {{--<script src="{{  asset('assets/bower_components/jquery/dist/jquery.min.js') }} "></script>--}}
    {{--<!-- Bootstrap 3.3.7 -->--}}
    {{--<script src="{{  asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }} "></script>--}}
    {{--<!-- AdminLTE App -->--}}
    {{--<script src="{{  asset('assets/dist/js/adminlte.min.js') }}"></script>--}}
{{--</body>--}}
{{--</html>--}}


