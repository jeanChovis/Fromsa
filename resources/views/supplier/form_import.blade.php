<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Importar datos de proveedor</h3>
                <br><br>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible ">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i> !Exito!&nbsp;
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-ban"></i> !Error!&nbsp;
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form"  action="{{ route('import.supplier') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputFile" >
                            Archivo de entrada
                        </label>
                        <input type="file" id="file" name="file">
                        <p class="text-danger">{{ $errors->first('file') }}</p>
                    </div>
                </div>


                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>

                <div class="box-body">
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-warning"></i> Atención! &nbsp;
                    Tipo de datos de archivo (.xls, .xlsx)
                </div>
                </div>
            </form>
        </div>


        <!-- /.box -->
    </div>

</div>
