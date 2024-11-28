@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <div class="box box-success">

        <div class="box-header">
            <h3 class="box-title">Lista de usuarios del sistema</h3>
        </div>

        <div class="box-header">
            <a href="/registrar" class="btn btn-success" ><i class="fa fa-plus"></i> Agregar usuario</a>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table id="user-table" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Sede</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>

    @include('user.form')
@endsection

@section('bot')

    <!-- DataTables -->
    <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>

    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

    {{--<script>--}}
    {{--$(function () {--}}
    {{--$('#items-table').DataTable()--}}
    {{--$('#example2').DataTable({--}}
    {{--'paging'      : true,--}}
    {{--'lengthChange': false,--}}
    {{--'searching'   : false,--}}
    {{--'ordering'    : true,--}}
    {{--'info'        : true,--}}
    {{--'autoWidth'   : false--}}
    {{--})--}}
    {{--})--}}
    {{--</script>--}}

    <script type="text/javascript">
        var table = $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json',
            },
            ajax: "{{ route('api.users') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'headquarters', name: 'headquarters'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        function editForm(id) {            
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('usuario') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Editar proveedor');

                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#headquarters').val(data.headquarters);
                },
                error : function() {
                    alert("Nada de datos");
                }
            });
        }

        function deleteData(id){
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: '¿Estas seguro?',
                text: "¡No podrás revertir!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, bórralo!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('usuario') }}" + '/' + id,
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
                    if (save_method == 'add') url = "{{ url('usuario') }}";
                    else url = "{{ url('usuario') . '/' }}" + id;

                    $.ajax({
                        url : url,
                        type : "POST",
                        //hanya untuk input data tanpa dokumen
//                      data : $('#modal-form form').serialize(),
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
