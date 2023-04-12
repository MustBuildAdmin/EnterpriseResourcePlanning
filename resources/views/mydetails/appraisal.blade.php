@include('new_layouts.header')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                        {{ __('My Details') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="row g-0">
                    @include('new_layouts.usersidebar')
                        <div class="col d-flex flex-column">
                            <div class="card-body">
                                <p>Comming Soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('new_layouts.footer')
