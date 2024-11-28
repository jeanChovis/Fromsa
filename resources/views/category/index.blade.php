@extends('layouts.master')

@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Lista de categorías</h3>
        </div>
        <div class="box-header">
            <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus"></i> Añadir nueva categoría</a>
            <a href="{{ route('exportPDF.categoryAll') }}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Exportar a PDF</a>
            <a href="{{ route('exportExcel.categoryAll') }}" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table id="categories-table" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>

    @include('category.form')

@endsection

@section('bot')
    <!-- DataTables -->
    <script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- Validator -->
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

    <script type="text/javascript">
        var table = $('#categories-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json',
            },
            ajax: "{{ route('api.category') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Agregar Categoria');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();

            $.ajax({
                url: `{{ url('categoria') }}/${id}/edit`,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Editar Categoría');
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                },
                error: function() {
                    alert("No hay datos disponibles.");
                }
            });
        }

        function deleteData(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                title: '¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) { 
                    $.ajax({
                        url: `{{ url('categoria') }}/${id}`,
                        type: "POST",
                        data: {
                            '_method': 'DELETE',
                            '_token': csrf_token
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    title: '¡Eliminado!',                                    
                                    icon: 'success',
                                    timer: 1500
                                });
                                table.ajax.reload();
                            } else {
                                Swal.fire({
                                    title: '¡Error!',
                                    text: 'No se pudo eliminar la categoría.',
                                    icon: 'error',
                                    timer: 1500
                                });
                            }
                        },                
                        error: function() {
                            Swal.fire({
                                title: '¡Error!',
                                text: 'Algo salió mal, inténtelo de nuevo.',
                                icon: 'error',
                                timer: 1500
                            });
                        }
                    });
                }
            });
        }




        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') {
                        url = "{{ url('categoria') }}";
                    } else {
                        url = "{{ url('categoria') . '/' }}" + id;
                    }

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            Swal.fire({
                                title: '¡Éxito!',
                                text: data.message,
                                icon: 'success',
                                timer: 1500
                            });
                        },
                        error: function(xhr) {
                            let errorMessage = 'Oops... ¡Algo salió mal!';
                            
                            // Verifica si la respuesta tiene un mensaje específico
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }                            
                            Swal.fire({
                                title: '¡Error!',
                                text: errorMessage,
                                icon: 'error',
                                timer: 1500
                            });
                        }
                    });
                    return false;
                }
            });
        });

    </script>
@endsection
