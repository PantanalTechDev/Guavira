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
<body>
    <!-- Hero Section -->
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
                        <a href="#about" class="nav-link">Sobre</a>
                    </li>   
                    <li class="nav-item">
                        <a href="{{ route('guavira.map') }}" class="nav-link">Localizar Guavira</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('guavira.create') }}" class="nav-link">Cadastrar Guavira</a>
                    </li>
                    <!--
                    <li class="nav-item">
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
    <main class="main">
        <!-- Hero Section Content -->
        <section class="hero" id="home">
            <div class="box0">
                <div class="box1">
                    <div class="hero-content">
                        <h1 class="cssanimation leFadeIn sequence">MapGuav</h1>
                        <p class="cssanimation leFadeIn sequence">Cadastre e encontre Guaviras!</p>
                    </div>
                    <figure class="guavirinha animate-scale">
                        <img id="guavirinhaimg" src="{{ asset('Map/images/Guavirinha2.png') }}" alt="Guavira Plant">
                    </figure>
                </div>
                <div class="box2">
                    <a href="{{ route('guavira.map') }}">
                        <figure class="mapa animate-scale">
                            <img src="{{ asset('Map/images/mapa.png') }}" alt="Map Location" loading="lazy">
                        </figure>
                    </a>
                </div>
            </div>
        </section>

        <!-- Project Section -->
        <section class="project" id="cadastrar">
            <div class="project-content animated-inleft">
                <h2 class="titulo-section">Projeto MapGuav</h2>
                <p class="texto-section">Estamos desenvolvendo um projeto acadêmico focado na criação de um site que visa salvar a planta Guavira...</p>
                <!--<button class="bt-section">Saiba Mais</button>!-->
            </div>
            <figure class="box-figura animated-inleft">
                <img alt="MapGuav Project" class="project-image animated-inleft" src="{{ asset('Map/images/guavira.jpg') }}" loading="lazy"/>
                <figcaption class="referenciaIMG animated-inleft"></figcaption>
            </figure>
        </section>

        <!-- About Section -->
        <section class="about" id="about">
            <figure class="box-figura animated-inleft">
                <img src="{{ asset('Map/images/guavira2.jpg') }}" alt="Guavira Fruit" class="about-image animated-inleft" loading="lazy">
                <figcaption class="referenciaIMG animated-inleft"></figcaption>
            </figure>
            <div class="about-content animated-inleft">
                <h2 class="titulo-section1 animated-inleft">Conheça a Guavira</h2>
                <p class="texto-section1 animated-inleft">A guavira é um fruto pequeno e exótico encontrado principalmente no Brasil, Bolívia e Paraguai...</p>
                <!--<button class="bt-section">Saiba Mais</button>!-->
            </div>
        </section>

        <!-- Team Section -->
        <section class="team" id="guaviras">
            <h2 class="tiuloTeam animated-intop">Quem Somos</h2>
            <div class="team-members">
                <!-- Team Member 1 -->
                <div class="team-member animated-intop">
                    <img src="{{ asset('Map/images/default-profile.png') }}" alt="Team Member 1" loading="lazy">
                    <h3>Nome 1</h3>
                    <p>Descrição breve do membro da equipe.</p>
                </div>
                <!-- Repeat for other members -->
            </div>
            <!--<button class="button animated-intop">Saiba Mais</button>!-->
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 MapGuav. Todos os direitos reservados.</p>
    </footer>

    <!-- JavaScript Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="{{ asset('Map/js/home.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
    <script src="{{ asset('Map/js/cssanimation-gsap.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/letteranimation.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
