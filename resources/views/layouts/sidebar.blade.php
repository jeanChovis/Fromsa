<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel" style="height: 80px;">
            <div class="pull-left image" style="margin-top: 12px;">
                <img src="{{ asset('user-profile.png') }} " class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">                
                <p>{{ \Auth::user()->name  }}</p>
                <p>{{ \Auth::user()->headquarters }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> En Línea</a> 
            </div>
        </div>
        
        <!-- search form (Optional) -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- <li class="header">Functions</li> -->
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('/panel') }}"><i class="fa fa-dashboard"></i> <span>Panel</span></a></li>
            <li><a href="{{ route('category.index') }}"><i class="fa fa-list"></i> <span>Categoría</span></a></li>
            <li><a href="{{ route('product.index') }}"><i class="fa fa-cubes"></i> <span>Producto</span></a></li>
            <li><a href="{{ route('customer.index') }}"><i class="fa fa-users"></i> <span>Cliente</span></a></li>
            <li><a href="{{ route('supplier.index') }}"><i class="fa fa-truck"></i> <span>Proveedor</span></a></li>
            <li><a href="{{ route('product_entry.index') }}"><i class="fa fa-cart-plus"></i> <span>Comprar productos</span></a></li>
            <li><a href="{{ route('product_output.index') }}"><i class="fa fa-minus"></i> <span>Venta de productos</span></a></li>
            <li><a href="{{ route('user.index') }}"><i class="fa fa-user-secret"></i> <span>Usuario</span></a></li> 
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
