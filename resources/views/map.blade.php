<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MapGuav - Cadastre e encontre Guaviras. Saiba mais sobre o projeto de mapeamento da Guavira e participe do movimento.">
    <title>MapGuav</title>
    
    <!-- Link to CSS files -->
    <link rel="stylesheet" href="{{ asset('Map/css/home.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/cssanimation.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body><!-- Set the same background color here -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a href="{{ route('guavira.home') }}" class="navbar-brand d-flex align-items-center">
                <img style="width: 100px; height: 100px;" src="{{ asset('Map/images/guavirinhaResmaster.png') }}" class="h-8 me-2" alt="" />
                <span class="text-2xl font-semibold whitespace-nowrap dark:text-white">MAP GUAV</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('guavira.home') }}" class="nav-link active" aria-current="page">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('guavira.home') }}#about" class="nav-link">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('guavira.map') }}" class="nav-link">Localizar Guavira</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('guavira.create') }}" class="nav-link">Cadastrar Guavira</a>
                    </li>
                    <!--<li class="nav-item">
                        <a href="#" class="nav-link">Guaviras</a>
                    </li>
                    !-->
                </ul>
                @auth
                <div class="d-flex align-items-center ms-3">
                    <button type="button" class="btn dropdown-toggle" id="user-menu-button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="w-8 h-8 rounded-circle" src="{{ asset('Map/images/default-profile.png') }}" alt="user photo" style="width: 2rem; height: 2rem;">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="user-menu-button">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                        <!--<li><a class="dropdown-item" href="#">Guaviras Cadastradas</a></li> !-->
                        <li>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                        </li>
                    </ul>
                </div>
                @endauth
                @guest
                <div class="d-flex align-items-center ms-3">
                    <a href="{{ route('register') }}" class="btn btn-primary">Crie sua conta!</a>
                </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Map Section -->
    <div id="map" style="height: 500px; width: 100%;"></div> <!-- Adjust height and width as needed -->

    <!-- JavaScript Files -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $mapKey }}&callback=initMap" async defer></script>
    <script src="{{ asset('Map/js/map.js') }}"></script>
    <script>
        // Get Guavira data passed from the backend
        var guaviras = @json($guaviras);
        
        // Initialize the map with the Guavira data
        initMap(guaviras);
    </script>   

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
