@include('new_layouts.header')
<main class="page-wrapper">
	<section class="row"> {{--
		<aside class="col-2">
			<nav id="sidebar">
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
		</aside> --}}
		<article class="col-12">
			<div class="page-header d-print-none">
				<div class="container-xl">
					<div class="row g-2 align-items-center">
						<div class="col">
							<h2 class="page-title">
								{{__('Welcome')}} {{\Auth::user()->name }}!
                                </h2> </div>
					</div>
				</div>
			</div>
			<div class="page-body">
				<div class="container-xl">
					<div class="row row-cards">
						<div class="col-md-6 col-xl-2">
							<a class="card card-link" href="#">
								<div class="card-body">
									<div class="row">
										<div class="col-auto">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
												<path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
												<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
												<path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
											</svg>
										</div>
										<div class="col">
											<div class="font-weight-medium">{{__('Users')}}</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-6 col-xl-2">
							<a class="card card-link" href="#">
								<div class="card-body">
									<div class="row">
										<div class="col-auto">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
												<path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
												<path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"> </path>
											</svg>
										</div>
										<div class="col">
											<div class="font-weight-medium">{{__('Roles')}}</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-6 col-xl-2">
							<a class="card card-link" href="{{route('hrm_main')}}">
								<div class="card-body">
									<div class="row">
										<div class="col-auto">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tower" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M5 3h1a1 1 0 0 1 1 1v2h3v-2a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v2h3v-2a1 1 0 0 1 1 -1h1a1 1 0 0 1 1 1v4.394a2 2 0 0 1 -.336 1.11l-1.328 1.992a2 2 0 0 0 -.336 1.11v7.394a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1v-7.394a2 2 0 0 0 -.336 -1.11l-1.328 -1.992a2 2 0 0 1 -.336 -1.11v-4.394a1 1 0 0 1 1 -1z"> </path>
												<path d="M10 21v-5a2 2 0 1 1 4 0v5"></path>
											</svg>
										</div>
										<div class="col">
											<div class="font-weight-medium">{{__('Human Resource')}}</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-6 col-xl-2">
							<a class="card card-link" href="{{route('construction_main')}}">
								<div class="card-body">
									<div class="row">
										<div class="col-auto">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
												<path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
												<path d="M15 19l2 2l4 -4"></path>
											</svg>
										</div>
										<div class="col">
											<div class="font-weight-medium">{{__('Construction')}}</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-6 col-xl-2">
							<a class="card card-link" href="#">
								<div class="card-body">
									<div class="row">
										<div class="col-auto">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-wrecking-ball" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M19 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
												<path d="M4 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
												<path d="M13 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
												<path d="M13 19l-9 0"></path>
												<path d="M4 15l9 0"></path>
												<path d="M8 12v-5h2a3 3 0 0 1 3 3v5"></path>
												<path d="M5 15v-2a1 1 0 0 1 1 -1h7"></path>
												<path d="M19 11v-7l-6 7"></path>
											</svg>
										</div>
										<div class="col">
											<div class="font-weight-medium">{{__('Clients')}}</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-6 col-xl-2">
							<a class="card card-link" href="#">
								<div class="card-body">
									<div class="row">
										<div class="col-auto">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-headset" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M4 14v-3a8 8 0 1 1 16 0v3"></path>
												<path d="M18 19c0 1.657 -2.686 3 -6 3"></path>
												<path d="M4 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z"> </path>
												<path d="M15 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z"> </path>
											</svg>
										</div>
										<div class="col">
											<div class="font-weight-medium">{{__('Support System')}}</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-6 col-xl-2">
							<a class="card card-link" href="{{ route('systemsettings') }}">
								<div class="card-body">
									<div class="row">
										<div class="col-auto">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"> </path>
												<path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
											</svg>
										</div>
										<div class="col">
											<div class="font-weight-medium"> {{__('System Settings')}}</div>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div class="container-xl mt-5">
					<div class="row g-2 align-items-center">
						<div class="col">
							<h2 class="page-title">
                                    Activity
                                </h2> </div>
					</div>
				</div>
				<div class="page-body">
					<div class="container-xl">
						<div class="row ">
							<div class="col-12">
								<div class="card">
									<div class="card-body">
										<div class="divide-y" style="max-height: 200px;overflow-y: scroll;">
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar">JL</span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Jeffie Lewzey</strong> commented on your <strong>"I'm not a witch."</strong> post. </div>
														<div class="text-muted">yesterday</div>
													</div>
													<div class="col-auto align-self-center">
														<div class="badge bg-primary"></div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/002m.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> It's <strong>Mallory Hulme</strong>'s birthday. Wish him well! </div>
														<div class="text-muted">2 days ago</div>
													</div>
													<div class="col-auto align-self-center">
														<div class="badge bg-primary"></div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/003m.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Dunn Slane</strong> posted <strong>"Well, what
                                                                    do you want?"</strong>. </div>
														<div class="text-muted">today</div>
													</div>
													<div class="col-auto align-self-center">
														<div class="badge bg-primary"></div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/000f.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Emmy Levet</strong> created a new project <strong>Morning alarm clock</strong>. </div>
														<div class="text-muted">4 days ago</div>
													</div>
													<div class="col-auto align-self-center">
														<div class="badge bg-primary"></div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/001f.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Maryjo Lebarree</strong> liked your photo. </div>
														<div class="text-muted">2 days ago</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar">EP</span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Egan Poetz</strong> registered new client as <strong>Trilia</strong>. </div>
														<div class="text-muted">yesterday</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/002f.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Kellie Skingley</strong> closed a new deal on project <strong>Pen Pineapple Apple Pen</strong>. </div>
														<div class="text-muted">2 days ago</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/003f.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Christabel Charlwood</strong> created a new project for <strong>Wikibox</strong>. </div>
														<div class="text-muted">4 days ago</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar">HS</span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Haskel Shelper</strong> change status of <strong>Tabler Icons</strong> from <strong>open</strong> to <strong>closed</strong>. </div>
														<div class="text-muted">today</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/006m.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Lorry Mion</strong> liked <strong>Tabler UI
                                                                    Kit</strong>. </div>
														<div class="text-muted">yesterday</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/004f.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Leesa Beaty</strong> posted new video. </div>
														<div class="text-muted">2 days ago</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/007m.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Perren Keemar</strong> and 3 others followed you. </div>
														<div class="text-muted">2 days ago</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar">SA</span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Sunny Airey</strong> upload 3 new photos to category <strong>Inspirations</strong>. </div>
														<div class="text-muted">2 days ago</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/009m.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Geoffry Flaunders</strong> made a <strong>$10</strong> donation. </div>
														<div class="text-muted">2 days ago</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/010m.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Thatcher Keel</strong> created a profile. </div>
														<div class="text-muted">3 days ago</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/005f.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Dyann Escala</strong> hosted the event <strong>Tabler UI Birthday</strong>. </div>
														<div class="text-muted">4 days ago</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar" style="background-image: url(./static/avatars/006f.jpg)"></span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Avivah Mugleston</strong> mentioned you on <strong>Best of 2020</strong>. </div>
														<div class="text-muted">2 days ago</div>
													</div>
												</div>
											</div>
											<div>
												<div class="row">
													<div class="col-auto"> <span class="avatar">AA</span> </div>
													<div class="col">
														<div class="text-truncate"> <strong>Arlie Armstead</strong> sent a Review Request to <strong>Amanda Blake</strong>. </div>
														<div class="text-muted">2 days ago</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
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
