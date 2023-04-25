@include('new_layouts.header')
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">

<style>
.table.dataTable.no-footer {
    border-bottom: none !important;
}
.display-none {
    display: none !important;
}
</style>
    <div class="page-wrapper">
@include('construction_project.side-menu',['hrm_header' => "Project Dashboard"])
                        <div class="col d-flex flex-column">
                            <div class="card-body">
                                {{-- <h2 class="mb-4">Project</h2> --}}
                                {{-- ///############################## --}}
                              
                                                    
                                    
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('new_layouts.footer')
