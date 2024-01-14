import { Controller } from '@hotwired/stimulus';
import L from 'leaflet';

export default class extends Controller {
    static targets = ['address', 'latitude', 'longitude', 'map'];

    get addressEl() {
        return this.addressTarget;
    }

    get latitudeEl() {
        return this.latitudeTarget;
    }

    get longitudeEl() {
        return this.longitudeTarget;
    }

    get mapEl() {
        return this.mapTarget;
    }

    get markerImg() {
        return this.mapEl.dataset.mapFormMarkerImg;
    }

    get geocoderAddressUrl() {
        return this.mapEl.dataset.mapFormGeocoderAddressUrl;
    }

    get geocoderReverseUrl() {
        return this.mapEl.dataset.mapFormGeocoderReverseUrl;
    }

    connect() {
        if (!this.hasMapTarget) {
            return;
        }

        this.registerEventListeners();
        this.initializeMap();
    }

    registerEventListeners() {
        this.longitudeEl.addEventListener('change', this.updateMarker.bind(this));
        this.longitudeEl.addEventListener('change', this.updateMarker.bind(this));
    }

    initializeMap() {
        L.Icon.Default.prototype.options.iconUrl = this.markerImg;

        this.map = L.map(this.mapEl, {
            center: [this.latitudeEl.value || 53.07944121461473, this.longitudeEl.value || 8.800988261963223],
            zoom: 7,
        });

        this.map.on('click', (event) => this.initializeMarkerAtPoint(event.latlng));

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(this.map);

        this.updateMarker();
    }

    initializeMarkerAtPoint(latlng) {
        if (this.markerInitialized) {
            return;
        }

        this.marker.setLatLng(latlng);
        this.marker.addTo(this.map);
        this.markerInitialized = true;

        this.updateForm();
    }

    updateMarker() {
        if (!this.map) {
            return;
        }

        if (!this.marker) {
            this.marker = L.marker(
                [0, 0],
                {
                    draggable: true,
                }
            );

            this.marker.on('dragend', this.updateForm.bind(this));
        }

        const latitude = parseFloat(this.latitudeEl.value);
        const longitude = parseFloat(this.longitudeEl.value);

        if (isNaN(latitude) || isNaN(longitude)) {
            return;
        }

        this.marker.setLatLng([latitude, longitude]);

        if (!this.map.getBounds().contains(this.marker.getLatLng()) || this.map.getZoom() < 12) {
            this.map.setView(this.marker.getLatLng(), 15);
        }

        if (!this.markerInitialized) {
            this.marker.addTo(this.map);
            this.markerInitialized = true;
        }
    }

    updateForm() {
        const { lat, lng } = this.marker.getLatLng();

        this.latitudeEl.value = lat;
        this.longitudeEl.value = lng;
    }

    geocodeAddress() {
        if (!this.hasAddressTarget) {
            return;
        }

        const address = this.addressEl.value;

        if (address.length === 0) {
            return;
        }

        fetch(this.geocoderAddressUrl + '?search=' + encodeURIComponent(address))
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    return;
                }

                const { latitude, longitude } = data[0];
                this.latitudeEl.value = latitude;
                this.longitudeEl.value = longitude;
                this.updateMarker();
            });
    }

    reverseGeocode() {
        if (!this.hasAddressTarget) {
            return;
        }

        const latitude = parseFloat(this.latitudeEl.value);
        const longitude = parseFloat(this.longitudeEl.value);

        if (isNaN(latitude) || isNaN(longitude)) {
            return;
        }

        fetch(this.geocoderReverseUrl + '?latitude=' + encodeURIComponent(latitude) + '&longitude=' + encodeURIComponent(longitude))
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    return;
                }

                this.addressEl.value = data[0];
            });
    }
}
