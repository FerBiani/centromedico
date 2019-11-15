<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
    
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('js/select2/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('js/chartsjs/Chart.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('js/chartsjs/Chart.css') }}" rel="stylesheet" />
        <link href="{{ asset('font/fontawesome/css/all.css') }}" rel="stylesheet" />
        <style>
            #sidebar {
                background: #303e45;
                position: fixed;
                min-width: 210px;
                min-height: 100vh;
            }
            #sidebar a { color: #cfd8dc }
            #sidebar a:hover { background: #29353d }
            #sidebar a.active {
                color: #fff;
                background: #29353d;
            }
            #module-info {
                color: #fff;
                min-height: 64px;
                padding-left: 10px;
            }
            #module-info i { font-size: 36px; }
            #module-info h1 {
                font-size: 18px;
                margin: 0;
            }
            #workspace {
                width: 100%;
                margin-left: 210px;
                background: #f3f6f7;
            }
            #header {
                z-index: 99;
                width: calc(100% - 210px);
                background: #fff;
                position: fixed;
                padding: 0 16px;
                height: 64px;
                color: #5f6368;
            }
            #content {
                margin-top: 64px;
                padding: 16px;
                min-height: calc(100vh - 128px);
            }
            #footer {
                color: #5f6368;
                height: 64px;
                padding-left: 16px;
                border-top: 1px solid #cfd8dc;
            }
            .btn-circle {
                border-radius: 50%;
                cursor: pointer;
                padding: 10px;
            }
            .btn-circle:hover { background: #ededed; }
        </style>
    </head>
    <body>
        <div class="d-flex">
            <div id="sidebar">
                <div class="shadow-sm d-flex align-items-center" id="module-info">
                    <h1>Centro Médico</h1>
                </div>
                <nav class="nav flex-column">
                    @if(Auth::user()->nivel_id <= 1)
                        <a class="nav-link d-flex align-items-center" href="{{url('usuario')}}">
                            <i class="fas fa-users" style="margin:5px"></i>
                            <span>Usuários</span>
                        </a>
                        <a class="nav-link d-flex align-items-center" href="{{url('logs')}}">
                            <i class="far fa-chart-bar" style="margin:5px"></i>
                            <span>Logs</span>
                        </a>
                        <a class="nav-link d-flex align-items-center" href="{{url('/')}}">
                            <i class="fas fa-folder" style="margin:5px"></i>
                            <span>Relatorios</span>
                        </a>
                    @endif
                    @if(Auth::user()->nivel_id == 2)
                        <a class="nav-link d-flex align-items-center" href="{{url('pacientes/agendamentos')}}">
                            <i class="far fa-calendar-alt" style="margin:5px"></i>
                            <span>Meus Agendamentos</span>
                        </a>
                        <a class="nav-link d-flex align-items-center" href="{{url('pacientes/ficha')}}">
                            <i class="fas fa-clipboard" style="margin:5px"></i>
                            <span>Ficha</span>
                        </a>
                    @endif
                    @if(Auth::user()->nivel_id == 3)
                        <a class="nav-link d-flex align-items-center" href="{{url('medicos/agendamentos')}}">
                            <i class="far fa-calendar-alt" style="margin:5px"></i>
                            <span>Consultas Agendadas</span>
                        </a>
                        <a class="nav-link d-flex align-items-center" href="{{url('medicos/horario')}}">
                            <i class="fas fa-clock" style="margin:5px"></i>
                            <span>Horários</span>
                        </a>
                    @endif
                    @if(Auth::user()->nivel_id == 4)
                        <a class="nav-link d-flex align-items-center" href="{{url('agendamentos')}}">
                            <i class="far fa-calendar-alt" style="margin:5px"></i>
                            <span>Agendamentos</span>
                        </a>
                        <a class="nav-link d-flex align-items-center" href="{{url('atendente/agendamento/create')}}">
                            <i class="fas fa-plus" style="margin:5px"></i>
                            <span>Agendar Consulta</span>
                        </a>
                        <a class="nav-link d-flex align-items-center" href="{{url('usuario')}}">
                            <i class="fas fa-users" style="margin:5px"></i>
                            <span>Usuários</span>
                        </a>
                        <a class="nav-link d-flex align-items-center" href="{{url('lista/')}}">
                            <i class="fas fa-list" style="margin:5px"></i>
                            <span>Lista de Espera</span>
                        </a>
                        <a class="nav-link d-flex align-items-center" href="{{url('atendente/relatorio')}}">
                            <i class="fas fa-folder" style="margin:5px"></i>
                            <span>Relatórios</span>
                        </a>
                    @endif
                </nav>
            </div>
            <div class="d-flex flex-column" id="workspace">
                <div class="shadow-sm d-flex align-items-center justify-content-between" id="header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-bars btn-circle"  onclick="toggleMenu()"></i>
                    </div>
                    <div class="">
                    <ul class="navbar-nav ml-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->nome }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right position-absolute" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Sair
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endauth
                </ul>
                    </div>
                </div>
                <div id="content">
                        @if(Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <p>{{Session::get('success')}}</p>
                        </div>
                        @endif

                        @if(Session::get('warning'))
                        <div class="alert alert-warning" role="alert">
                            <p>{{Session::get('warning')}}</p>
                        </div>
                        @endif

                        @if(Session::get('error'))
                        <div class="alert alert-error" role="alert">
                            <p>{{Session::get('error')}}</p>
                        </div>
                        @endif
                        @yield('content')
                </div>
            </div>
        </div>
        <!-- Bootstrap JS -->
        <script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery-validator/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery-validator/localization/messages_pt_BR.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('js/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/chartsjs/Chart.min.js') }}"></script>
        <script src="{{ asset('js/chartsjs/Chart.bundle.min.js') }}"></script>

        <script> var main_url="{{url('')}}"; </script>
        @auth
        <script>
            var socket  = io('http://localhost:8888', { query: "id={{Auth::user()->id}}" });
        </script>
        @endauth
        <!-- Toggle Menu Script -->
        <script>
            function toggleMenu() {
                var sidebar = document.getElementById('sidebar');
                var workspace = document.getElementById('workspace');
                var header = document.getElementById('header');
                var displaySidebar = sidebar.style.display === "none" ? "block" : "none";
                var marginLeftWorkspace = workspace.style.marginLeft === "0px" ? "210px" : "0px";
                var widthHeader = header.style.width === "100%" ? "calc(100% - 210px)" : "100%";
                sidebar.style.display = displaySidebar;
                workspace.style.marginLeft = marginLeftWorkspace;
                header.style.width = widthHeader;
            }
        </script>
        @yield('js')
    </body>
</html>
