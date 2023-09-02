@extends('layouts.auth')
<style>
    .error{
        width: 100%;
    margin-top: 0.25rem;
    font-size: 85.714285%;
    color: #d63939;
    }
    .page{
        min-height:auto !important;
    }
    .topheader {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        align-items:center;
    }
    li.nav-item {
        list-style: none;
    }
    .font_size{
        font-size: 11px !important;
    }
    .backgroundimge{
        width: 150px;
        height: 80;
        object-fit: contain;
    }
    .navbar-brand-autodark,img.backgroundimge{
        display:flex !important;
        margin-left:auto !important;
        margin-right:auto !important;
    }
    li.nav-item {
        display: flex;
        position: absolute;
        right: 10px;
    }
    .form-control.is-invalid, .was-validated .form-control:invalid {
        background-image: unset !important;
    }
</style>

@section('content')
<div class="page page-center">
  <div class="container container-tight py-4">
 		<div class="topheader">
			<p>Welcome</p>
    	</div>
	</div>
</div>
@endsection
