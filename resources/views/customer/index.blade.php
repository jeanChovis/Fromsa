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
            <h3 class="box-title">Lista de Clientes</h3>
        </div>

        <div class="box-header">
            <a onclick="addForm()" class="btn btn-success" ><i class="fa fa-plus"></i> Añadir cliente</a>
            <a href="{{ route('exportPDF.customerAll') }}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Exportar a PDF</a>
            <a href="{{ route('exportExcel.customerAll') }}" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
        </div>


        <!-- /.box-header -->
        <div class="box-body">
            <table id="customer-table" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Tipo cliente</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>

    @include('customer.form')

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
        var table = $('#customer-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json',
            },
            ajax: "{{ route('api.customer') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'address', name: 'address'},
                {data: 'email', name: 'email'},
                {data: 'contact', name: 'contact'},
                {data: 'client_type', name: 'client_type'},                
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Añadir Cliente');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('cliente') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Editar cliente');

                    $('#id').val(data.id);

                    // Verificar el tipo de cliente y rellenar los campos correspondientes
                    if (data.client_type === 'Persona') {
                        $('#client_type').val('Persona'); // Selecciona el tipo de cliente
                        $('#dni').val(data.dni);
                        $('#name_person').val(data.name);
                        $('#address_person').val(data.address);
                        $('#email_person').val(data.email);
                        $('#phone_person').val(data.phone);

                        // Mostrar campos de Persona y ocultar campos de Empresa
                        document.getElementById("persona_fields").style.display = "block";
                        document.getElementById("empresa_fields").style.display = "none";
                    } else {
                        $('#client_type').val('Empresa'); // Selecciona el tipo de cliente
                        $('#ruc').val(data.ruc);
                        $('#name_company').val(data.name);
                        $('#address_company').val(data.address);
                        $('#email_company').val(data.email);
                        $('#phone_company').val(data.phone);

                        // Mostrar campos de Empresa y ocultar campos de Persona
                        document.getElementById("persona_fields").style.display = "none";
                        document.getElementById("empresa_fields").style.display = "block";
                    }
                },
                error: function() {
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
                        url : "{{ url('cliente') }}" + '/' + id,
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
                                title: 'Oops...',
                                text: data.message,
                                icon: 'error',
                                timer: '1500'
                            })
                        }
                    });
                }
            });
        }

        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    var url;
                    if (save_method == 'add') url = "{{ url('cliente') }}";
                    else url = "{{ url('cliente') . '/' }}" + id;

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
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                timer: '1500'
                            })
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
