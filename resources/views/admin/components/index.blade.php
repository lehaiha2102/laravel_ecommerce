<!doctype html>
<html lang="en">

<!-- head -->
@include('admin.components.Head');
<!-- end head -->

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <!-- page header -->
        @include('admin.components.PageHeader')
        <!-- end page header -->
        <div class="app-main">
            <!-- sidebar -->
            @include('admin.components.Sidebar')
            <!-- end sidebar -->
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-car icon-gradient bg-mean-fruit">
                                    </i>
                                </div>
                                <div>
                                    @yield('title')
                                </div>
                            </div>
                        </div>
                    </div>
                    @yield('content')
                </div>
                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner">
                            <div class="app-footer-left">
                                <ul class="nav">
                                    <li class="nav-item">
                                       
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:void(0);" class="nav-link">
                                            Footer Link 2
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   @include('admin.components.footer')
</body>

</html>