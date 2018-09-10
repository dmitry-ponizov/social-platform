<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" id="_token" content="{{ csrf_token() }}">
    <title>@lang('main.global.administration')</title>
    <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"
          type="text/css">
    <!-- Custom styles for this template-->
    <link href="{{mix('css/admin/sb-admin.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.css">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<div id="app_admin" data-lang="{{json_encode(
          ['statement'=> \Lang::get('main.statement')
        ])}}">

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <a class="navbar-brand" href="/admin/dashboard"><img style="width: 200px" src="/uploads/defaults/logo-wide.png"
                                                             alt=""></a>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" style="margin-top: 63px; background: #222d32;" id="exampleAccordion">

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseUsers"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-user" aria-hidden="true"></i>
                        <span class="nav-link-text">@lang('main.global.users')</span>
                    </a>

                    <ul class="sidenav-second-level collapse" id="collapseUsers">
                        <li>
                            <a href="{{route('users')}}">@lang('main.menu.users_list')</a>
                        </li>
                        <li>
                            <a href="{{route('user.show.details',\Auth::id())}}">@lang('main.menu.my_profile')</a>
                        </li>


                        <li>
                            <a href="{{route('roles')}}">@lang('main.global.roles')</a>

                        </li>
                        <li>
                            <a href="{{route('permissions')}}">@lang('main.global.permissions')</a>

                        </li>

                    </ul>

                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#socialService"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-users" aria-hidden="true"></i>
                        <span class="nav-link-text">@lang('main.global.social_services')</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="socialService">
                        <li>
                            <a href="{{route('social_services')}}">@lang('main.menu.social_list')</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#organizations"
                       data-parent="#organizations">
                        <i class="fa fa-fw fa-users" aria-hidden="true"></i>
                        <span class="nav-link-text">@lang('main.global.organizations')</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="organizations">
                        <li>
                            <a href="{{url('admin/organizations')}}">@lang('main.menu.organizations_list')</a>
                        </li>
                        <li>
                            <a href="{{url('admin/organizations/events')}}">@lang('main.menu.events')</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#volunteers"
                       data-parent="#volunteers">
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        <span class="nav-link-text">@lang('main.global.volunteers')</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="volunteers">
                        <li>
                            <a href="{{url('admin/user/volunteers')}}">@lang('main.menu.volunteers_list')</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseCategories"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-list" aria-hidden="true"></i>
                        <span class="nav-link-text">@lang('main.menu.categories')</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseCategories">
                        <li>
                            <a href="{{route('categories')}}">@lang('main.menu.categories_list')</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseRules"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-list-ol" aria-hidden="true"></i>
                        <span class="nav-link-text">@lang('main.menu.rules')</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseRules">
                        <li>
                            <a href="{{route('groups')}}">@lang('main.menu.groups')</a>
                        </li>
                        <li>
                            <a href="{{route('rules')}}">@lang('main.menu.rules_list')</a>

                        </li>

                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseStatements"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-envelope-o" aria-hidden="true"></i>

                        <span class="nav-link-text">@lang('main.menu.statements')</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseStatements">
                        <li>
                            <a href="{{route('statements')}}">@lang('main.menu.statements_list')</a>

                        </li>
                        {{--<li>--}}
                        {{--<a href="{{route('statement.create')}}">Create statements</a>--}}
                        {{--</li>--}}
                    </ul>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseOffers"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-handshake-o" aria-hidden="true"></i>
                        <span class="nav-link-text">@lang('main.menu.offers')</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseOffers">
                        <li>
                            <a href="{{route('offers')}}">@lang('main.menu.offers_list')</a>

                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapsePartners"
                       data-parent="#exampleAccordion">
                        <i class="fa  fa-fw  fa-money" aria-hidden="true"></i>
                        <span class="nav-link-text">@lang('main.menu.partners')</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapsePartners">
                        <li>
                            <a href="{{route('partners')}}">@lang('main.menu.partners_list')</a>

                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-wrench"></i>
                        <span class="nav-link-text">@lang('main.menu.settings')</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseComponents">
                        <li>
                            <a href="{{route('pages')}}">@lang('main.menu.pages')</a>
                        </li>
                    </ul>

                </li>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a class="nav-link text-center" id="sidenavToggler">
                        <i class="fa fa-fw fa-angle-left"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto" >
                <notification
                        :locale="{{ json_encode(\App::getLocale()) }}"
                        :userId="{{ auth()->id() }}"
                        :unreads="{{auth()->user()->unreadNotifications}}"
                />
            </ul>
            <div style="margin-right:100px">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-fw fa-sign-out"></i>@lang('main.global.logout')</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div>
                @yield('content')
            </div>
        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        <footer class="sticky-footer">
            <div class="container">
                <div class="text-center">
                    <small>Copyright © HostZealot 2018</small>
                </div>
            </div>
        </footer>
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fa fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Хотите выйти?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Выберите «Выйти» ниже, если вы готовы завершить текущий сеанс.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Отмена</button>
                        {{--<a class="btn btn-primary" href="{{route('login')}}">Logout</a>--}}
                        <a class="btn btn-primary" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">@lang('main.global.logout')</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->


    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="{{ asset('js/admin/sb-admin.min.js')}}"></script>
<script src="{{ asset('js/app_admin.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.js"></script>
<script>
    @if(Session::has('success'))
    new Noty({
        layout: 'bottomRight',
        type: 'success',
        theme: 'metroui',
        timeout: 2000,
        text: "{{Session::get('success')}}",
        progressBar: false,

    }).show();

    @endif
    @if(Session::has('error'))
    new Noty({
	    layout: 'bottomRight',
	    type: 'error',
	    theme: 'metroui',
	    timeout: 2000,
	    text: "{{Session::get('error')}}",
	    progressBar: false,

    }).show();

    @endif
</script>

</body>

</html>
