var MapsGoogle = function () {

    var mapMarker = function () {
        var map = new GMaps({
            div: '#gmap_marker',
            lat: -16.449965, 
            lng: -71.587268,
        });
        map.addMarker({
            lat: -16.449965, 
            lng: -71.587268,
            title: 'Central',
            details: {
                database_id: 42,
                author: 'HPNeo'
            },
            click: function (e) {
                if (console.log) console.log(e);
                alert('You clicked in this marker');
            }
        });
    };
    
    return {
        //main function to initiate map samples
        init: function () {
            mapMarker();
        }

    };

}();

jQuery(document).ready(function() {
    MapsGoogle.init();
});