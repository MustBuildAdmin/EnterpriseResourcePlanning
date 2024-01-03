@include('new_layouts.header')
@php
   $user= Auth::user();
    Session::put('ses_user_id',$user->id);
@endphp
<main class="page-wrapper">
   <section>
      {{--
      <aside class="col-2">
         <nav id="sidebar" class="navbar navbar-vertical navbar-transparent">
            <div class="custom-menu">
               <button type="button" id="sidebarCollapse" class="btn btn-primary"> <i class="fa fa-bars"></i> <span class="sr-only">Toggle Menu</span> </button>
            </div>
            <div class="p-4">
               <h1><a href="index.html" class="logo">Portfolic <span>Portfolio Agency</span></a></h1>
               <ul class="list-unstyled components mb-5">
                  <li class="active"> <a href="#"><span class="fa fa-home mr-3"></span> Home</a> </li>
                  <li> <a href="#"><span class="fa fa-user mr-3"></span> About</a> </li>
                  <li> <a href="#"><span class="fa fa-briefcase mr-3"></span> Works</a> </li>
                  <li> <a href="#"><span class="fa fa-sticky-note mr-3"></span> Blog</a> </li>
                  <li> <a href="#"><span class="fa fa-suitcase mr-3"></span> Gallery</a> </li>
                  <li> <a href="#"><span class="fa fa-cogs mr-3"></span> Services</a> </li>
                  <li> <a href="#"><span class="fa fa-paper-plane mr-3"></span> Contacts</a> </li>
               </ul>
            </div>
         </nav>
      </aside>
      --}}
      <article class="col-12">
         <div class="page-header d-print-none">
            <div class="container-fluid">
               <div class="row g-2 align-items-center">
                  <div class="col">
                     <h2 class="page-title">
                        {{__('Welcome')}} {{\Auth::user()->name }}!
                     </h2>
                  </div>
               </div>
            </div>
         </div>
         <div class="page-body">
            <div class="container-fluid">
            
            </div>
         </div>
      </article>
   </section>
</main>
</div>
</div>
</div>
</div>
@include('new_layouts.footer')