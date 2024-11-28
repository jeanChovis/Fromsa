@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Log on to codeastro.com for more projects! -->
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="box box-success">

        <div class="box-header">
            <h3 class="box-title">Vender producto</h3>
        </div>

        <div class="box-header">
            <a onclick="addForm()" class="btn btn-success" ><i class="fa fa-plus"></i> Agregar nueva venta</a>
            <a href="{{ route('exportPDF.outputproductAll') }}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Exportar PDF</a>
            <a href="{{ route('exportExcel.outputproductAll') }}" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Exportar Excel</a>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table id="products-out-table" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Cliente</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>



    <div class="box box-success col-md-6">

        <div class="box-header">
            <h3 class="box-title">Exportar factura</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="invoice" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Cliente</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                </thead>

                @foreach($invoice_data as $i)
                    <tbody>
                        <td>{{ $i->id }}</td>
                        <td>{{ $i->product->name }}</td>
                        <td>{{ $i->customer->name }}</td>
                        <td>{{ $i->total }}</td>
                        <td>{{ $i->date }}</td>
                        <td>
                            <a href="{{ route('exportPDF.outputproductAll', [ 'id' => $i->id ]) }}" class="btn btn-sm btn-danger">Exportar factura</a>
                        </td>
                    </tbody>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
    </div>

    @include('product_output.form')

@endsection

@section('bot')

    <!-- DataTables -->
    <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>

    <!-- Log on to codeastro.com for more projects! -->
    <!-- InputMask -->
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(function () {
            //Date picker
            $('#tanggal').datepicker({
                autoclose: true,
                // dateFormat: 'yyyy-mm-dd'
            })
            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            })
        })
    </script>

    <script type="text/javascript">
        var table = $('#products-out-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json',
            },
            ajax: "{{ route('api.outputproduct') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'products_name', name: 'products_name'},
                {data: 'customer_name', name: 'customer_name'},
                {data: 'total', name: 'total'},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Agregar nueva venta');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('venderProducto') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Editar producto');

                    $('#id').val(data.id);
                    $('#product_id').val(data.product_id);
                    $('#customer_id').val(data.customer_id);
                    $('#total').val(data.total);
                    $('#date').val(data.date);
                },
                error : function() {
                    alert("No hay datos disponibles.");
                }
            });
        }

        function deleteData(id){
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('venderProducto') }}" + '/' + id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success : function(data) {
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error : function () {
                        swal({
                            title: 'Oops...',
                            text: data.message,
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            });
        }

        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('venderProducto') }}";
                    else url = "{{ url('venderProducto') . '/' }}" + id;

                    $.ajax({
                        url : url,
                        type : "POST",
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success : function(data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error : function(data){
                            swal({
                                title: 'Oops...',
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });
        });
    </script>

@endsection
