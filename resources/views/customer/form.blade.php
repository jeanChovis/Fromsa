<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="form-item" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data" >
                {{ csrf_field() }} {{ method_field('POST') }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"></h3>
                </div>      

                <div class="modal-body">
                    <input type="hidden" id="id" name="id">

                    <div class="box-body">

                        <div class="form-group">
                            <label>Tipo Cliente</label>
                            <select id="client_type" name="client_type" class="form-control" onchange="toggleClientFields()">
                                <option value="" disabled selected>Seleccione el tipo de cliente</option>
                                <option value="Persona">Persona</option>
                                <option value="Empresa">Empresa</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <!-- Campos para Persona -->
                        <div id="persona_fields" style="display: none;">
                            <div class="form-group">
                                <label>DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni">
                            </div>
                            <div class="form-group">
                                <label>Nombres y Apellidos</label>
                                <input type="text" class="form-control" id="name_person" name="name_person">
                            </div>
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" class="form-control" id="address_person" name="address_person">
                            </div>
                            <div class="form-group">
                                <label>Correo</label>
                                <input type="email" class="form-control" id="email_person" name="email_person">
                            </div>
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="tel" class="form-control" id="phone_person" name="phone_person">
                            </div>
                            <div class="form-group">
                                <label>Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date">
                            </div>
                            <div class="form-group">
                                <label>Género</label>
                                <select class="form-control" id="gender_person" name="gender_person">
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campos para Empresa -->
                        <div id="empresa_fields" style="display: none;">
                            <div class="form-group">
                                <label>RUC</label>
                                <input type="text" class="form-control" id="ruc" name="ruc">
                            </div>
                            <div class="form-group">
                                <label>Razón Social</label>
                                <input type="text" class="form-control" id="name_company" name="name_company">
                            </div>
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" class="form-control" id="address_company" name="address_company">
                            </div>
                            <div class="form-group">
                                <label>Correo</label>
                                <input type="email" class="form-control" id="email_company" name="email_company">
                            </div>
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="tel" class="form-control" id="phone_company" name="phone_company">
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Script para alternar los campos de cliente y limpiar al cerrar -->
<script>
    // Script para alternar los campos de cliente y limpiar al cerrar
    document.addEventListener('DOMContentLoaded', function() {
        // Alterna entre los campos de Persona y Empresa
        function toggleClientFields() {
            var clientType = document.getElementById("client_type").value;
            document.getElementById("persona_fields").style.display = (clientType === "Persona") ? "block" : "none";
            document.getElementById("empresa_fields").style.display = (clientType === "Empresa") ? "block" : "none";
        }

        // Asigna el evento al selector de tipo de cliente
        document.getElementById("client_type").addEventListener("change", toggleClientFields);

        // Limpiar campos y restablecer select cuando se cierra el modal
        $('#modal-form').on('hidden.bs.modal', function () {
            document.getElementById("client_type").value = "";
            document.getElementById("persona_fields").style.display = "none";
            document.getElementById("empresa_fields").style.display = "none";
            document.querySelectorAll('#modal-form input').forEach(input => input.value = "");
        });
    });
</script>