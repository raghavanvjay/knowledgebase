@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-md-6">
        <p>This page expects Laravel Training sessions!</p>
        <p>Seeing this page means that the home route has been set up correctly.</p>
    </div>
    <div class="col-md-6">
        <p>Map of Sweden - jsmaps</p>
        <div class="map-container">
            <div class="jsmaps-wrapper" id="sweden-map"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('jsmaps/jsmaps/jsmaps-libs.js') }}"></script>
<script src="{{ asset('jsmaps/jsmaps/jsmaps.min.js') }}"></script>
<script src="{{ asset('jsmaps/maps/sweden.js') }}"></script>


<script type="text/javascript">
    $(function() {
        $('#sweden-map').JSMaps({
        map: 'sweden',
        "mapWidth" : 800,
        "mapHeight" : 600,
        "responsive" : true,
        "displayAbbreviations" : false,
        "stateClickAction" : "url",
        "selectElement" : false,
        onReady: function() {
          // The map is fully rendered and ready for interactions
        },
        onStateClick: function(data) {
            console.log(data);
            alert(data.name);
          // A state/region has been clicked, data is passed to the listener which includes all data defined for the state/region in maps/{mapName}.js
        },
        onStateOver: function(data) {
          // The mouse enters a state, data is passed to the listener which includes all data defined for the state/region in maps/{mapName}.js
        },
        onStateOut: function(data) {
          // The mouse leaves a state, data is passed to the listener which includes all data defined for the state/region in maps/{mapName}.js
        }
        });
    });
</script>
@endsection

@section('styles')
<link href="{{ asset('jsmaps/jsmaps/jsmaps.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title')
LaraTrain
@endsection
