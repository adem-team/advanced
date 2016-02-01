var app = angular.module('myApp', []);

app.service('Map', function($q) {

    this.init = function() {
        var options = {
            center: new google.maps.LatLng(-6.2238186, 106.6605793),
            zoom: 17,
            disableDefaultUI: true
        }
        this.map = new google.maps.Map(
            document.getElementById("map"), options
        );
        this.places = new google.maps.places.PlacesService(this.map);
    }

    this.search = function(str) {
        var d = $q.defer();
        this.places.textSearch({query: str}, function(results, status) {
            if (status == 'OK') {
                d.resolve(results[0]);
            }
            else d.reject(status);
        });
        return d.promise;
    }

    this.addMarker = function(res) {
        if(this.marker) this.marker.setMap(null);
        this.marker = new google.maps.Marker({
            map: this.map,
            position: res.geometry.location,
            animation: google.maps.Animation.DROP
        });
        this.map.setCenter(res.geometry.location);
    }

});

app.controller('newPlaceCtrl', function($scope, Map) {

    $scope.place = {};

    $scope.search = function() {
        $scope.apiError = false;
        Map.search($scope.searchPlace)
        .then(
            function(res) { // success
                Map.addMarker(res);
                $scope.place.name = res.name;
                $scope.place.lat = res.geometry.location.lat();
                $scope.place.lng = res.geometry.location.lng();
            },
            function(status) { // error
                $scope.apiError = true;
                $scope.apiStatus = status;
            }
        );
    }
       $scope.place = {};

    $scope.submitForm = function() {
        // Posting data to php file
        $http({
          method  : 'POST',
          url     : '/master/customers/create-map',
          data    : $scope.place, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'}
         })
       }

    Map.init();
});
