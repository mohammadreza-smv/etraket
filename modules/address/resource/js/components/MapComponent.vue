<template>
    <div id="map" style="width:100%;height:400px">
        <l-map :center="center" ref="myMap" zoom="16">
            <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"></l-tile-layer>
            <l-marker :latLng="marker_position"></l-marker>
        </l-map>


    </div>
</template>

<script>
    import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';

    import { Icon } from 'leaflet';

    delete L.Icon.Default.prototype._getIconUrl
    Icon.Default.mergeOptions({
        iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
        iconUrl: require('leaflet/dist/images/marker-icon.png'),
        shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
    });
    export default {
        name: "MapComponent",
        components: {
            LMap,
            LTileLayer,
            LMarker,
        },
    }
</script>

