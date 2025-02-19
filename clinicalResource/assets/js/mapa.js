// let map;
// let marker;
//
// function initMap() {
//     // Coordenadas predeterminadas (en este caso, Valencia)
//     const defaultLocation = { lat: 39.4561165, lng: -0.3545661 };
//     map = new google.maps.Map(document.getElementById('map'), {
//         zoom: 12,
//         center: defaultLocation
//     });
//
//     // Inicializar el marcador
//     marker = new google.maps.Marker({
//         position: defaultLocation,
//         map: map,
//         title: "Ubicación seleccionada"
//     });
//
//     // Crear el autocompletado para el campo de dirección
//     const input = document.getElementById('location_address');
//
//     const autocomplete = new google.maps.places.Autocomplete(input);
//     autocomplete.bindTo('bounds', map);
//
//     // Cuando el usuario selecciona una dirección
//     autocomplete.addListener('place_changed', function() {
//         const place = autocomplete.getPlace();
//
//         marker = new google.maps.Marker({
//             position: defaultLocation,
//             map: map,
//             title: "Ubicación seleccionada"
//         });
//
//         if (!place.geometry) {
//             return;
//         }
//
//         // Actualizar el mapa y el marcador con la ubicación seleccionada
//         if (place.geometry.viewport) {
//             map.fitBounds(place.geometry.viewport);
//         } else {
//             map.setCenter(place.geometry.location);
//             map.setZoom(17); // Zoom al nivel adecuado
//         }
//
//         // Actualizar el marcador
//         marker.setPosition(place.geometry.location);
//
//         // Obtener las coordenadas y actualizar el formulario
//         document.getElementById('location_latitude').value = place.geometry.location.lat();
//         document.getElementById('location_longitude').value = place.geometry.location.lng();
//         latitud = Number(document.getElementById('location_latitude').value);
//         latitud = Number(document.getElementById('location_longitude').value)
//         newLocation =  { lat: latitud, lng: latitud };
//
//         // Inicializar el marcador
//
//     });
//
//
// }





let map;
let marker;

function initMap() {
    // Coordenadas predeterminadas (Valencia)
    const defaultLocation = { lat: 39.4561165, lng: -0.3545661 };

    // Inicializar el mapa
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: defaultLocation
    });

    // Inicializar el marcador con AdvancedMarkerElement
    marker = new google.maps.marker.AdvancedMarkerElement({
        position: defaultLocation,
        map: map,
        title: "Init map"
    });

    // Autocompletado de direcciones
    const input = document.getElementById('location_address');
    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    // Evento cuando el usuario selecciona una dirección
    autocomplete.addListener('place_changed', function() {
        const place = autocomplete.getPlace();

        if (!place.geometry) {
            return;
        }

        // Ajustar la vista del mapa
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17); // Zoom al nivel adecuado
        }

        // Actualizar el marcador con la nueva ubicación
        marker.position = place.geometry.location;

        // Obtener y actualizar las coordenadas en el formulario
        document.getElementById('location_latitude').value = place.geometry.location.lat();
        document.getElementById('location_longitude').value = place.geometry.location.lng();
    });
}
