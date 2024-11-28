@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="box box-success">

        <div class="box-header">
            <h3 class="box-title">Lista de productos</h3>

            <a onclick="addForm()" class="btn btn-success pull-right" style="margin-top: -8px;"><i class="fa fa-plus"></i> Añadir nuevo producto</a>
        </div>


        <!-- /.box-header -->
        <div class="box-body">
            <table id="products-table" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>

    @include('product.form')

@endsection

@section('bot')

    <!-- DataTables -->
    <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>

    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

    <script type="text/javascript">
        var table = $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json',
            },
            ajax: "{{ route('api.product') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'price', name: 'price'},
                {data: 'stock', name: 'stock'},
                {data: 'show_photo', name: 'show_photo'},
                {data: 'category_name', name: 'category_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]            
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Añadir producto');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $('#image_preview').hide();
            $.ajax({
                url: "{{ url('producto') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Editar Producto');

                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#price').val(data.price);
                    $('#stock').val(data.stock);
                    $('#category_id').val(data.category_id);
                    
                    // Muestra la imagen actual si existe
                    if (data.image) {
                        $('#image_preview').attr('src', '{{ url('') }}/' + data.image).show(); // Muestra la imagen
                    } else {
                        $('#image_preview').hide(); // Oculta si no hay imagen
                    }
                    
                },
                error : function() {
                    alert("No se encontraron datos.");
                }
            });
        }

        function deleteData(id){
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                title: '¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, borrar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : "{{ url('producto') }}" + '/' + id,
                        type : "POST",
                        data : {'_method' : 'DELETE', '_token' : csrf_token},
                        success : function(data) {
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
                                    text: 'No se pudo eliminar el producto.',
                                    icon: 'error',
                                    timer: 1500
                                });
                            }
                        },
                        error : function () {
                            Swal.fire({
                                title: '¡Error!',
                                text: 'Algo salió mal.',
                                icon: 'error',
                                timer: '1500'
                            });
                        }
                    });
                }
            });
        }

        $(function() {
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()) {
                    var id = $('#id').val();
                    var url;
                    if (save_method == 'add') {
                        url = "{{ url('producto') }}";
                    } else {
                        url = "{{ url('producto') . '/' }}" + id;
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
