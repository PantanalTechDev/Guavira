// Initialize the map
function initMap(guaviras) {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -20.459110289527487, lng: -54.6540373110798 },
        zoom: 12
    });

    // Handle the case where there are no Guaviras
    if (!guaviras || guaviras.length === 0) {
        console.log("No Guaviras found.");
        // Optionally, display a message to the user
        document.getElementById('map').innerHTML = '<p>There are currently no Guaviras registered.</p>';
    } else {
        // Process the Guavira data
        guaviras.forEach(function (guavira) {
            var marker = new google.maps.Marker({
                position: { lat: parseFloat(guavira.latitude), lng: parseFloat(guavira.longitude) },
                map: map,
                title: guavira.descricao,
                icon: {
                    url: '/Map/map-icons/guav-icon.png', // Ensure the correct path is set
                    scaledSize: new google.maps.Size(70, 70),
                }
            });

            // Add an info window for each marker
            var infowindow = new google.maps.InfoWindow({
                content: `
                    <div class="map-card">
                        <div class="card-img">
                            <img src="${guavira.imagem ? '/storage/' + guavira.imagem : '/path/to/default/image.png'}" alt="Guavira Image" />
                        </div>
                        <div class="card-details">
                            <strong>Criado por:</strong> ${guavira.user ? guavira.user.name : 'Unknown'}<br>
                            <strong>CNPJ:</strong> ${guavira.cnpj ? guavira.cnpj : 'Não é um ponto comercial'}<br>
                            <p class="card-description"><strong>Descrição:</strong> ${guavira.descricao}</p>
                        </div>
                    </div>
                `
            });
            
            // Add a click listener to show the info window when a marker is clicked
            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });
        });
    }
}

function openSidebar() {
    document.getElementById('sidebar').style.transform = 'translateX(0)';
}

function closeSidebar() {
    document.getElementById('sidebar').style.transform = 'translateX(-100%)';
}

// Export functions if needed
window.initMap = initMap;
window.openSidebar = openSidebar;
window.closeSidebar = closeSidebar;
