<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Google-Style Form</title>
    <link rel="stylesheet" href="{{ asset('Map/css/home.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .main-container {
            display: flex;
            width: 100%;
            height: 100vh;
            padding: 0;
        }
        .form-container {
            flex: 1;
            background-color: #fff;
            padding: 2rem;
            border-right: 2px solid #e0e0e0;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }
        #map {
            flex: 1;
            height: 100vh;
            border-left: 2px solid #e0e0e0;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a href="{{ route('guavira.home') }}" class="navbar-brand d-flex align-items-center">
            <img style="width: 100px; height: 100px;" src="{{ asset('Map/images/guavirinhaResmaster.png') }}" alt="Logo">
            <span class="text-2xl font-semibold">MAP GUAV</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="{{ route('guavira.home') }}" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ route('guavira.home') }}#about" class="nav-link">Sobre</a></li>
                <li class="nav-item"><a href="{{ route('guavira.map') }}" class="nav-link">Localizar Guavira</a></li>
                <li class="nav-item"><a href="{{ route('guavira.create') }}" class="nav-link">Cadastrar Guavira</a></li>
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

<div class="main-container">
    <div class="form-container">
        <h2 class="form-header">Enhanced Google-Style Form</h2>
        <p class="form-description">Please complete the form below with the required information.</p>

        <form action="{{ route('guavira.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Registration Type Selection -->
            <div class="mb-4">
                <label for="registration_type" class="form-label form-section-title">Registration Type</label>
                <select id="registration_type" name="registration_type" class="form-control" required>
                    <option value="simples" {{ old('registration_type') == 'simples' ? 'selected' : '' }}>Cadastro simples</option>
                    <option value="comerciante" {{ old('registration_type') == 'comerciante' ? 'selected' : '' }}>Comerciante/Venda/Distribuidor</option>
                </select>
                @error('registration_type')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- CNPJ Field (only for Comerciante/Venda/Distribuidor) -->
            <div id="cnpj-field" class="mb-4 {{ old('registration_type') == 'comerciante' ? '' : 'd-none' }}">
                <label for="cnpj" class="form-label form-section-title">CNPJ</label>
                <input type="text" id="cnpj" name="cnpj" class="form-control" value="{{ old('cnpj') }}" placeholder="CNPJ">
                @error('cnpj')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description Field -->
            <div class="mb-4">
                <label for="descricao" class="form-label form-section-title">Description</label>
                <textarea id="descricao" name="descricao" class="form-control" required maxlength="150">{{ old('descricao') }}</textarea>
                @error('descricao')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image Upload Field -->
            <div class="mb-4">
                <label for="imagem" class="form-label form-section-title">Image (optional)</label>
                <input type="file" id="imagem" name="imagem" class="form-control-file">
                @error('imagem')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Location Type Selection -->
            <div class="mb-4">
                <label for="location_type" class="form-label form-section-title">Location Type</label>
                <select id="location_type" name="location_type" class="form-control" required>
                    <option value="manual" {{ old('location_type') == 'manual' ? 'selected' : '' }}>Manual Coordinates</option>
                    <option value="endereco" {{ old('location_type') == 'endereco' ? 'selected' : '' }}>Address</option>
                </select>
                @error('location_type')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Manual Coordinates Fields -->
            <div id="manual-coordinates" class="mb-4 {{ old('location_type') == 'manual' ? '' : 'd-none' }}">
                <label for="latitude" class="form-label form-section-title">Latitude</label>
                <input type="text" id="latitude" name="latitude" class="form-control" value="{{ old('latitude') }}" placeholder="Latitude">
                @error('latitude')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="longitude" class="form-label form-section-title">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="form-control" value="{{ old('longitude') }}" placeholder="Longitude">
                @error('longitude')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Address Fields -->
            <div id="address-fields" class="mb-4 {{ old('location_type') == 'endereco' ? '' : 'd-none' }}">
                <label for="cidade" class="form-label form-section-title">Cidade</label>
                <input type="text" id="cidade" name="cidade" class="form-control" value="{{ old('cidade') }}" placeholder="Cidade" maxlength="100">
                @error('cidade')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="rua" class="form-label form-section-title">Rua</label>
                <input type="text" id="rua" name="rua" class="form-control" value="{{ old('rua') }}" placeholder="Rua" maxlength="150">
                @error('rua')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="numero" class="form-label form-section-title">Número</label>
                <input type="text" id="numero" name="numero" class="form-control" value="{{ old('numero') }}" placeholder="Número" maxlength="10">
                @error('numero')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn submit-button w-100">Submit</button>
        </form>
    </div>
    <div id="map"></div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key={{ $mapKey }}&callback=initMap" async defer></script>
<script src="{{ asset('Map/js/map.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('registration_type').addEventListener('change', function() {
        document.getElementById('cnpj-field').classList.toggle('d-none', this.value !== 'comerciante');
    });
    document.getElementById('location_type').addEventListener('change', function() {
        document.getElementById('manual-coordinates').classList.toggle('d-none', this.value !== 'manual');
        document.getElementById('address-fields').classList.toggle('d-none', this.value !== 'endereco');
    });

    document.querySelector('form').addEventListener('submit', function(event) {
        let isValid = true;
        const descricao = document.getElementById('descricao').value.trim();
        const cnpj = document.getElementById('cnpj').value.trim();

        if (descricao.length > 255) {
            alert('Description must be 255 characters or less.');
            isValid = false;
        }
        
        if (document.getElementById('registration_type').value === 'comerciante') {
            if (cnpj.length !== 14 || !/^\d{14}$/.test(cnpj)) {
                alert('CNPJ must be exactly 14 digits and contain only numbers.');
                isValid = false;
            }
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    const fields = ['descricao', 'cidade', 'rua', 'numero'];

    fields.forEach(field => {
        const inputField = document.getElementById(field);
        inputField.addEventListener('input', function() {
            const maxLength = parseInt(inputField.getAttribute('maxlength'));
            const currentLength = inputField.value.length;

            if (currentLength > maxLength) {
                inputField.value = inputField.value.slice(0, maxLength); // Truncate the input
                alert(`You can only enter up to ${maxLength} characters.`);
            }
        });
    });

    // Get Guavira data passed from the backend
    var guaviras = @json($guaviras);
        
    // Initialize the map with the Guavira data
    initMap(guaviras);
</script>
</body>
</html>
