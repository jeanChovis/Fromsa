<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        body {
            font-family 'DejaVu Sans', sans-serif;
        }

        .invoice-box {
            padding 10px;
            border 1px solid #eee;
            box-shadow 0 0 10px rgba(0, 0, 0, 0.15);
            max-width 800px;
            margin auto;
            color #555;
        }

        #table-data {
            width 100%;
            border-collapse collapse;
            margin-bottom 20px;
        }

        #table-data td,
        #table-data th {
            padding 8px;
            border 1px solid #ddd;
            text-align left;
        }

        #table-data th {
            background-color #f2f2f2;
            color #333;
        }

        .header-title {
            text-align center;
            font-size 24px;
            font-weight bold;
            color #333;
            margin-bottom 10px;
        }

        .section-title {
            font-size 18px;
            font-weight bold;
            color #333;
            margin 10px 0;
            text-decoration underline;
        }

        .right-text {
            text-align right;
        }
    </style>

</head>

<body>
    <div class="invoice-box">
        <div class="header-title">Factura de Compra</div>
        <br>
        <table id="table-data">
            <tr>
                <th colspan="4">Detalles de la Factura</th>
            </tr>
            <tr>
                <td width="auto"><b>Factura N°.</b></td>
                <td width="auto">{{ $product_entry->id }}</td>
                <td width="auto"><b>Fecha</b></td>
                <td>{{ $product_entry->date }}</td>
            </tr>
            <tr>
                <td><b>Proveedor</b></td>
                <td>{{ $product_entry->supplier->company_name }}</td>
                <td><b>Correo</b></td>
                <td>{{ $product_entry->supplier->email }}</td>
            </tr>
            <tr>
                <td><b>Teléfono</b></td>
                <td>{{ $product_entry->supplier->phone }}</td>
                <td><b>Dirección</b></td>
                <td>{{ $product_entry->supplier->address }}</td>
            </tr>
        </table>

        <div class="section-title">Detalles del Producto</div>

        <table id="table-data">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
            </tr>
            <tr>
                <td>{{ $product_entry->product->name }}</td>
                <td>{{ $product_entry->amount }}</td>
            </tr>
        </table>

        <table width="100%" style="margin-top 30px;">
            <tr>
                <td class="right-text">Gracias por su compra</td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td class="right-text">FROMSA</td>
            </tr>
        </table>
    </div>
</body>

</html>
