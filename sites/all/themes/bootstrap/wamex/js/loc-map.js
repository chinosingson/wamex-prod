(function ($) {
	
	Drupal.behaviors.projectMap = {
		attach: function (context, settings) {
		jQuery('html:has(body.page-node.node-type-project)', context).once('ready',function(){
      var OpenStreetMap_Mapnik = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      });

      var geosearchControl = new L.Control.GeoSearch({
        provider: new L.GeoSearch.Provider.Google(),
        showMarker: true,
        retainZoomLevel: true,
      }); //.addTo(map);

      var map = L.map('map-canvas',{
        dragging: false,
        layers: [OpenStreetMap_Mapnik],
        scrollWheelZoom: false,
        touchZoom: false,
        doubleClickZoom:  false,
        boxZoom: false,
        zoomControl: false,
        //center: new L.LatLng(10.72, 122.57),
        //zoom: 15,
      });
      
      
      geosearchControl.addTo(map);
      //map.dragging(false);
      //map.setView([10.72, 122.57], 15);
      
      //console.log(Drupal.settings.node.values.field_location);
      var googleGeocodeProvider = new L.GeoSearch.Provider.Google(),
        addressText = Drupal.settings.node.values.field_location;
      console.log(googleGeocodeProvider);
      googleGeocodeProvider.GetLocations( addressText, function(data){
        console.log(data);
      });
            
		});
  }
	}
}(jQuery));		
