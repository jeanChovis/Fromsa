@extends('layouts.master')

@section('top')
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ \App\Models\User::count() }}</h3>

                <p>Usuarios del sistema</p>
            </div>
            <div class="icon">
                <i class="fa fa-user-secret"></i>
            </div>
            <a href="{{ route('user.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ \App\Models\Category::count() }}<sup style="font-size: 20px"></sup></h3>

                <p>Categoría</p>
            </div>
            <div class="icon">
                <i class="fa fa-list"></i>
            </div>
            <a href="{{ route('category.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ \App\Models\Product::count() }}</h3>
                <p>Producto</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <a href="{{ route('product.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>   

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ \App\Models\Customer::count() }}</h3>

                <p>Cliente</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="{{ route('customer.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
</div>

<div class="row">
    
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ \App\Models\Supplier::count() }}<sup style="font-size: 20px"></sup></h3>

                <p>Proveedor</p>
            </div>
            <div class="icon">
                <i class="fa fa-signal"></i>
            </div>
            <a href="{{ route('supplier.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-maroon">
            <div class="inner">
                <h3>{{ \App\Models\Product_Entry::count() }}</h3>

                <p>Comprar productos</p>
            </div>
            <div class="icon">
                <i class="fa fa-cart-plus"></i>
            </div>
            <a href="{{ route('product_entry.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ \App\Models\Product_Output::count()  }}</h3>

                <p>Venta de productos</p>
            </div>
            <div class="icon">
                <i class="fa fa-minus"></i>
            </div>
            <a href="{{ route('product_output.index') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div id="container" class=" col-xs-6"></div>
</div>

@endsection

@section('top')
@endsection
