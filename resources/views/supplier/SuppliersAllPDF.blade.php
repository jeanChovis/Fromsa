{{-- <!doctype html> --}}
{{-- <html lang="es"> --}}
{{-- <head> --}}
{{-- <meta charset="UTF-8"> --}}
{{-- <meta name="viewport" --}}
{{-- content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"> --}}
{{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css ')}}"> --}}
{{-- <!-- Font Awesome --> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css')}} "> --}}
{{-- <!-- Ionicons --> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css')}} "> --}}

{{-- <title>Product Masuk Exports All PDF</title> --}}
{{-- </head> --}}
{{-- <body> --}}
<style>
    #supplier {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }

    #supplier td,
    #supplier th {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    #supplier tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #supplier tr:hover {
        background-color: #ddd;
        cursor: pointer;
    }

    #supplier th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #605ca8;
        color: white;
    }

    #supplier td {
        font-size: 13px;
        color: #333;
    }

    .table-container {
        overflow-x: auto;
    }
</style>
<div class="table-container">
    <table id="supplier">
        <thead>
            <tr>
                <th>RUC</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Correo</th>
            </tr>
        </thead>        
        <tbody>
            @foreach ($supplier as $s)
                <tr>
                    <td>{{ $s->ruc }}</td>
                    <td>{{ $s->company_name }}</td>
                    <td>{{ $s->address }}</td>
                    <td>{{ $s->email }}</td>
                </tr>
            @endforeach
        </tbody>        
    </table>
</div>


{{-- <!-- jQuery 3 --> --}}
{{-- <script src="{{  asset('assets/bower_components/jquery/dist/jquery.min.js') }} "></script> --}}
{{-- <!-- Bootstrap 3.3.7 --> --}}
{{-- <script src="{{  asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }} "></script> --}}
{{-- <!-- AdminLTE App --> --}}
{{-- <script src="{{  asset('assets/dist/js/adminlte.min.js') }}"></script> --}}
{{-- </body> --}}
{{-- </html> --}}
