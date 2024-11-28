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
            <h3 class="box-title">Lista de proveedores</h3>
        </div>

        <div class="box-header">
            <a onclick="addForm()" class="btn btn-success" ><i class="fa fa-plus"></i> Añadir proveedor</a>
            <a href="{{ route('exportPDF.supplierAll') }}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Exportar a PDF</a>
            <a href="{{ route('exportExcel.supplierAll') }}" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table id="suppliers-table" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>RUC</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        
    </div>

    @include('supplier.form_import')

    @include('supplier.form')

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
        var table = $('#suppliers-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json',
            },
            ajax: "{{ route('api.supplier') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'ruc', name: 'ruc' },
                { data: 'company_name', name: 'company_name' },
                { data: 'address', name: 'address' },
                { data: 'email', name: 'email' },                               
                { data: 'phone', name: 'phone' },
                { data: 'action', name: 'action', orderable: false, searchable: false}          
            ]
        });
    
        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Añadir Proveedor');
        }
    
        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
    
            $.ajax({
                url: "{{ url('proveedor') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Editar Proveedor');
                    $('#id').val(data.id);
                    $('#ruc').val(data.ruc);
                    $('#company_name').val(data.company_name);
                    $('#address').val(data.address);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                },
                error : function() {
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
                        url: `{{ url('proveedor') }}/${id}`, // Uso de template literals
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
                                    text: 'No se pudo eliminar el proveedor.',
                                    icon: 'error',
                                    timer: 1500
                                });
                            }
                        },
                        error: function() {
                            Swal.fire("¡Error!", "Algo salió mal, inténtelo de nuevo.", {
                                icon: "error",
                                timer: '1500'
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
                        url = "{{ url('proveedor') }}";
                    }else {
                        url = "{{ url('proveedor') . '/' }}" + id;
                    }
    
                    $.ajax({
                        url : url,
                        type : "POST",
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success : function(data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            Swal.fire({
                                title: '¡Éxito!',
                                //text: data.message,
                                icon: 'success',
                                timer: '1500'
                            });
                        },
                        error : function(xhr) {
                            let errorMessage = 'Oops... ¡Algo salió mal!';
                            
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                // Aquí puedes mostrar los errores en el front-end
                                console.log(errors);
                            }
                            
                            Swal.fire({
                                title: '¡Error!',
                                text: errorMessage,
                                icon: 'error',
                                timer: '1500'
                            });
                        }
                    });
                    return false;
                }
            });
        });
    </script>
    

@endsection
