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
                            <label >Nombre</label>
                            <input type="text" class="form-control" id="name" name="name"  autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Precio</label>
                            <input type="text" class="form-control" id="price" name="price"   required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Cantidad</label>
                            <input type="text" class="form-control" id="stock" name="stock"   required>
                            <span class="help-block with-errors"></span>
                        </div>


                        <div class="form-group">
                            <label >Imagen</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Categoria</label>                        
                            <select name="category_id" id="category_id" class="form-control select" required>                            
                                <option value="" disabled selected>-- Elige una categoría --</option>
                                @foreach($category as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!-- /.box-body -->

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
