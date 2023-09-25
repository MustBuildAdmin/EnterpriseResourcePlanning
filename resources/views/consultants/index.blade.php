@include('new_layouts.header')
<style>
    #create {
        height: 35px !important;
        width: 12% !important;
    }

    #invite {
        height: 35px !important;
        width: 12% !important;
    }

    #reset {
        width: 12% !important;
    }

    #search_button {
        height: 35px !important;
        width: 12% !important;
    }

    .dropdown-toggle::after {
        display: none;
        position: absolute;
        top: 50%;
        right: 20px;
    }

    .avatar.avatar-xl.mb-3.user-initial {
        border-radius: 50%;
        color: #FFF;
    }

    .avatar-xl {
        --tblr-avatar-size: 6.2rem;
    }

    html,
    body {
        height: 100%;
        padding: 0px;
        margin: 0px;
        overflow: scroll;
    }

    .ts-dropdown {
        z-index: 2000;
    }

    .user-card-dropdown::after {
        display: none;
    }
</style>

@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
@endphp
<div class="container-fluid ">
    <div class="modal modal-blur fade" id="create-consultant" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create a Consultant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="row row-cards">
                            <div class="col-sm-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" placeholder="Company" value="Chet">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" placeholder="Last Name" value="Faker">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email address</label>
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <select class="form-control form-select">
                                        <option value="">Male</option>
                                        <option value="">Female</option>
                                        <option value="">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Country</label>
                                    <select class="form-control form-select">
                                        <option value="">Male</option>
                                        <option value="">Female</option>
                                        <option value="">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <select class="form-control form-select">
                                        <option value="">Male</option>
                                        <option value="">Female</option>
                                        <option value="">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" placeholder="City" value="Melbourne">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Postal Code</label>
                                    <input type="test" class="form-control" placeholder="ZIP Code">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" name="input-mask" class="form-control"
                                        data-mask="(00) 0000-0000" data-mask-visible="true"
                                        placeholder="(00) 0000-0000"autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Profile Picture</label>
                                    <input type="file" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 mb-0">
                                    <label class="form-label">Address</label>
                                    <textarea rows="5" class="form-control" placeholder="Here can be your Address" value="Mike"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        data-bs-dismiss="modal">{{ __('Create a Member') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="info-consultant" tabindex="-1" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Information about Creation of Consultant') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>{{ __('Creation of Consultant') }}</h3>
                    @switch(Lang::locale())
                        @case('ar')
                            <!--arabic-->
                            {{ __('وفقًا لـ "إنشاء المستشارين"، فإننا نقوم بإنشائها
                            	   على مستوى العالم ولكن يتم دفع الدعوة فقط لوصول شركاتك إلى المشروع الذي تقدمه لهم بمعرفتك
                            						ولا نشاركهم أي نوع من المعلومات الأخرى حول المشاريع سرًا أو في الأماكن العامة أو في وسائل النقل.') }}
                        @break

                        @case('da')
                            <!--Danish-->
                            {{ __("I henhold til Create of Consultant opretter vi dem globalt, men invitationsbetalingen sker
                            					kun for dine virksomheders adgang til projektet, som du giver dem med din viden, og vi deler ikke
                            					nogen form for anden information til dem om projekterne i secert eller offentligt eller ved overførsel.") }}
                        @break

                        @case('de')
                            <!--German-->
                            {{ __("Gemäß Create of Consultant erstellen wir sie global, aber die Einladungszahlung erfolgt nur für den
                            						 Zugriff Ihres Unternehmens auf das Projekt, das Sie ihm mit Ihrem Wissen gewähren, und wir geben ihnen keine
                            						anderen Informationen über die Projekte im Geheimen weiter oder in der Öffentlichkeit oder im Medium der
                            						Übertragung.") }}
                        @break

                        @case('en')
                            <!--English-->
                            {{ __("As per Create of Consultant ,we are creating them
                            						globally but the invite payment is done only for your companies access over
                            						the project which you provide to them with your knowledge and we are not
                            						sharing any kind of other information to them about the projects in secert
                            						or in public or in mediuim of transfer.") }}
                        @break

                        @case('es')
                            <!--Danish-->
                            {{ __("Según Create of Consultant, los estamos creando globalmente, pero el pago de la invitación
                            					 se realiza solo para que sus empresas accedan al proyecto que usted les proporciona con su conocimiento
                            					  y no les compartimos ningún otro tipo de información sobre los proyectos en secreto. o en público
                            					   o en medio de transferencia.") }}
                        @break

                        @case('fr')
                            <!--French-->
                            {{ __("Conformément à Create of Consultant, nous les créons globalement, mais le paiement de
                            						l'invitation est effectué uniquement pour l'accès de votre entreprise au projet que
                            						vous leur fournissez avec vos connaissances et nous ne leur partageons aucune autre
                            						information sur les projets en secret. ou en public ou en milieu de transfert.") }}
                        @break

                        @case('it')
                            <!--French-->
                            {{ __("Secondo Create of Consultant, li stiamo creando a livello globale ma il pagamento dell'invito
                            					 viene effettuato solo per consentire alle tue aziende di accedere al progetto che fornisci loro
                            					  con le tue conoscenze e non condividiamo con loro alcun tipo di altra informazione sui progetti
                            					   in segreto o in pubblico o nel mezzo di trasferimento.") }}
                        @break

                        @case('ja')
                            <!--japanese-->
                            {{ __("Create of Consultant に従って、私たちはグローバルにそれらを作成していますが、
                            						招待の支払いは、あなたが知識を持って提供したプロジェクトに対する貴社のアクセスに対してのみ行われ、
                            						プロジェクトに関するその他の情報を秘密裏に共有することはありません。または公共の場で、または転送の媒体で。") }}
                        @break

                        @case('nl')
                            <!--dutch-->
                            {{ __("Volgens Create of Consultant maken we ze wereldwijd, maar de uitnodigingsbetaling wordt alleen gedaan voor
                            					 de toegang van uw bedrijf tot het project dat u hen met uw kennis verstrekt en we delen geen enkele
                            					  andere informatie met hen over de projecten in secert of in het openbaar of tijdens de overdracht.") }}
                        @break

                        @case('pl')
                            <!--polish-->
                            {{ __("Zgodnie z Create of Consultant tworzymy je globalnie, ale płatność za zaproszenie jest dokonywana tylko
                            				 za dostęp Twoich firm do projektu, który im przekazujesz za swoją wiedzą i nie udostępniamy im żadnych innych
                            				  informacji na temat projektów w tajemnicy lub w miejscu publicznym lub w trakcie przenoszenia.") }}
                        @break

                        @case('pt')
                            <!--polish-->
                            {{ __("De acordo com a Criação do Consultor, estamos criando-os globalmente, mas o pagamento do convite é
                            				 feito apenas para o acesso de suas empresas ao projeto que você fornece a elas com seu conhecimento e não
                            				  estamos compartilhando nenhum tipo de outra informação sobre os projetos em segredo. ou em público ou em
                            				   meio de transferência.") }}
                        @break

                        @case('ru')
                            <!--polish-->
                            {{ __("Согласно Create of Consultant, мы создаем их по всему миру, но оплата за приглашение производится только
                            			 для доступа ваших компаний к проекту, который вы им предоставляете со своими знаниями, и мы не передаем им никакой
                            			  другой информации о проектах в секрете. или публично, или в процессе передачи.") }}
                        @break

                        @default
                            {{ __("As per Create of Consultant ,we are creating them
                            						globally but the invite payment is done only for your companies access over
                            						the project which you provide to them with your knowledge and we are not
                            						sharing any kind of other information to them about the projects in secert
                            						or in public or in mediuim of transfer.") }}
                    @endswitch

                    <hr />
                    <h3>{{ __('Invite a existing Consultant') }}</h3>
                    <p>
                        {{ __('As per the Inviting exiting Consultant which is already in the
                        				          platform gloabally invite payment done only for your companies access over the
                        				          project which you provide to them with your knowledge and we are not sharing
                        				          any kind of other information to them about the projects in secert or in
                        				          public or in mediuim of transfer.') }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-5 p-4">
        <div class="card-header">
            <h3>{{ __('Consultants of the Organisation') }}</h3>
            <div class="card-actions w-50">
                <div class="row">
                    <div class="col-5">
                        <div class="mb-3">
                            <div class="row g-2">
                                <form action="{{ route('consultants.index') }}" method="GET">
                                    <div class="input-group">
                                        {{ Form::text('search', isset($_GET['search']) ? $_GET['search'] : '', [
                                            'class' => 'form-control d-inline-block w-9 me-3 mt-auto',
                                            'id' => 'search',
                                            'placeholder' => __('Search by Name'),
                                        ]) }}
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-icon" aria-label="Button">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <a class="btn btn-primary" data-bs-toggle="modal" data-size="lg"
                            data-url="{{ route('consultant.invite_consultant') }}" data-ajax-popup="true"
                            data-bs-toggle="tooltip" title="{{ __('Invite Consultant') }}"
                            data-bs-original-title="{{ __('Invite Consultant') }}">
                            {{ __('Invite a Consultant') }}
                        </a>
                    </div>
                    <div class="col-3">
                        <a class="btn btn-primary w-100" data-bs-toggle="modal" data-size="lg"
                            data-url="{{ route('consultants.create') }}" data-ajax-popup="true"
                            data-bs-toggle="tooltip" title="{{ __('Create New Consultant') }}"
                            data-bs-original-title="{{ __('Create a Consultant') }}">
                            {{ __('Create a Consultant') }}
                        </a>
                    </div>
                    <div class="col-1 mt-1">
                        <a href="#" class="badge bg-yellow text-yellow-fg" title="click to know information"
                            data-bs-toggle="modal" data-bs-target="#info-consultant">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-hexagon"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555
						  -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225
						   0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33
						    2.33 0 0 1 2.25 0l6.75 3.98h-.033z">
                                </path>
                                <path d="M12 8v4"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            @forelse($users as $user)
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="ms-auto lh-1  p-4">
                            @if ($user->color_code != null || $user->color_code != '')
                                @php $color_co=$user->color_code; @endphp
                            @else
                                @php $color_co =Utility::rndRGBColorCode(); @endphp
                            @endif
                            <div class="dropdown">
                                <a class="dropdown-toggle user-card-dropdown text-secondary" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-menu-2" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 6l16 0"></path>
                                        <path d="M4 12l16 0"></path>
                                        <path d="M4 18l16 0"></path>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item active" href="#" data-size="lg"
                                        data-url="{{ route('consultants.edit.new', [$user->id, $color_co]) }}"
                                        data-ajax-popup="true" class="dropdown-item"
                                        data-bs-original-title="{{ __('Edit Consultant') }}">{{ __('Edit') }}</a>
                                    <a data-url="{{ route('consultants.reset', \Crypt::encrypt($user->id)) }}"
                                        data-ajax-popup="true" data-size="md" class="dropdown-item"
                                        data-bs-original-title="{{ __('Reset Password') }}">{{ __('Reset Password') }}</a>

                                </div>
                            </div>
                        </div>
                        @php $short=substr($user->name, 0, 1); @endphp
                        @php $short_lname=substr($user->lname, 0, 1); @endphp
                        <div class="card-body p-4 text-center">
                            @if (!empty($user->avatar))
                                <img src="{{ !empty($user->avatar) ? $profile . $user->avatar : asset(Storage::url(' uploads/avatar/avatar.png ')) }}"
                                    class="avatar avatar-xl mb-3 rounded" alt="">
                            @else
                                <div class="avatar avatar-xl mb-3 user-initial"
                                    style='background-color:{{ $color_co }}'>
                                    {{ strtoupper($short) }}{{ strtoupper($short_lname) }}
                                </div>
                            @endif
                            @php $name=strlen($user->name) > 20 ? substr($user->name,0,19)."..." : $user->name; @endphp
                            @php $lname=strlen($user->lname) > 20 ? substr($user->lname,0,19)."..." : $user->lname; @endphp
                            <h3 class="m-0 mb-1"><a href="#">{{ $name }} {{ $lname }}</a></h3>
                            {{-- <div class="text-secondary">UI Designer</div> --}}
                            <div class="mt-3">
                                <span class="badge bg-purple-lt">{{ $user->type }}</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a data-bs-toggle="tooltip" data-copy_email="{{ $user->email }}"
                                title="{{ $user->email }}" href="#" class="card-btn"
                                onclick="copyToClipboard(this)">
                                <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z">
                                    </path>
                                    <path d="M3 7l9 6l9 -6"></path>
                                </svg>
                                {{ __('Email') }}
                            </a>
                            <a data-bs-toggle="tooltip" data-copy_phone="{{ $user->phone }}"
                                title="{{ $user->phone }}" class="card-btn" onclick="copyToClipboardphone(this)">
                                <!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1
						  -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                                    </path>
                                </svg>
                                {{ __('Call') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty">
                    <p class="empty-title"> {{ __('Invite a Consultant') }}</p>
                    <p class="empty-subtitle text-secondary">
                        {{ __('No Consultant are available for the project,please click below to invite consultant') }}
                    </p>
                    <div class="empty-action">
                        <a class="btn btn-primary" data-bs-toggle="modal" data-size="lg"
                            data-url="{{ route('consultant.invite_consultant') }}" data-ajax-popup="true"
                            data-bs-toggle="tooltip" title="{{ __('Invite Consultant') }}"
                            data-bs-original-title="{{ __('Invite Consultant') }}">
                            {{ __('Invite a Consultant') }}
                        </a>
                    </div>
                </div>
            @endforelse
            <div class="d-flex mt-4">
                <ul class="pagination ms-auto">
                    {!! $users->links() !!}
                </ul>
            </div>

        </div>
    </div>
</div>
</div>
</div>
@include('new_layouts.footer')



<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        copy_email = $(element).data('copy_email');
        $temp.val(copy_email).select();
        document.execCommand("copy");
        $temp.remove();
        toastr.info("{{ __('Email copying to clipboard was successfull!') }}");
    }

    function copyToClipboardphone(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        copy_phone = $(element).data('copy_phone');
        $temp.val(copy_phone).select();
        document.execCommand("copy");
        $temp.remove();
        toastr.info("{{ __('Mobile copying to clipboard was successfull!') }}");
    }

    $(document).on('keypress',
        function(e) {
            if (e.which == 13) {
                swal.closeModal();
            }
        });

    $(document).on('change', '.document_setup',
        function() {
            var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'gif'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                $(".show_document_file").hide();
                $(".show_document_error").html("Upload only pdf, jpeg, jpg, png");
                $('input[type="submit"]').prop('disabled', true);
                return false;
            } else {
                $(".show_document_file").show();
                $(".show_document_error").hide();
                $('input[type="submit"]').prop('disabled', false);
                return true;
            }
        });
</script>
