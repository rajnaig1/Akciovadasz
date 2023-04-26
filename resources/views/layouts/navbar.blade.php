<div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light text-center sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand nav-link disabled" href="#">
                <img src="{{ URL::asset('horseracher.gif') }}" width="50px" height="50px" alt="">
                <strong>AKCIÓVADÁSZ</strong>
            </a>
            <button class="navbar-toggler mb-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex mx-auto">
                    <input class="form-control" id="searchField" type="search" placeholder="Keresés"
                        aria-label="Search">
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="modal" aria-current="page"
                                href="#loginModal">Bejelentkezés</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="modal" aria-current="page"
                                href="#registerModal">Regisztráció</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ url('/getshoppingcart') }}">Kosaram</a>
                        </li>
                        @if (Auth::user()->role_id <= App\Http\Middleware\AuthHelper::ADMIN)
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ url('/admin') }}">Cron Logs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ url('/admin/getpennydatas') }}">Penny
                                    Termékek</a>
                            </li>
                        @endif
                        <x-navbar-dropdown-component buttonText="Bejelentkezve: {{ Auth::user()->name }}">
                            <li><a class="dropdown-item" href="{{ url('/profileModify') }}">Profilom</a></li>
                            <li><a class="dropdown-item" href="{{ url('/getshoppingcart') }}">Bevásárlókosár</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/logout') }}">Kijelentkezés</a></li>
                        </x-navbar-dropdown-component>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <x-login-register-component class="nav-link-active" buttonText="Bejelentkezés" id="loginModal" title="BEJELENTKEZÉS"
        body="" url="/login" method="POST">

        <input type="text" class="form-control" id="emil" name="email" placeholder="E-Mail" required
            style="margin-bottom: 10px;">

        <input type="password" class="form-control" id="jelszo" name="password" placeholder="Jelszó" required
            style="margin-bottom: 10px;">
    </x-login-register-component>
    <x-login-register-component class="nav-link-active" buttonText="Regisztráció" id="registerModal"
        title="REGISZTRÁCIÓ" body="" url="/register" method="POST">

        <input type="text" class="form-control" name="name" placeholder="Név" required
            style="margin-bottom: 10px;">

        <input type="email" class="form-control" name="email" placeholder="E-Mail" required
            style="margin-bottom: 10px;">

        <input type="text" class="form-control" name="password" placeholder="Jelszó" required
            style="margin-bottom: 10px;">

        <input type="text" class="form-control" name="password_confirmation" placeholder="Jelszó Mégegyszer"
            required style="margin-bottom: 10px;">

    </x-login-register-component>
    <script type="text/javascript">
        @if (null != Session::get('loginFailure'))
            $(document).ready(function() {
                $('#loginModal').modal('show');
            });
        @endif
        @if (null != Session::get('registerFailure'))
            $(document).ready(function() {
                $('#registerModal').modal('show');
            });
        @endif
    </script>
