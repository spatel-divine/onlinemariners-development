<!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Designed BY: </b> Divine Infosys
    </div>
    <strong>Copyright &copy; {{ date('Y') }} <a href="https://onlinemariners.com/">Online Mariners</a>.</strong> All rights
    reserved.
  </footer>

  <!-- jQuery 3 -->
<!-- <script src="{{ asset('public/adminassets/bower_components/jquery/dist/jquery.min.js') }}"></script> -->
<!-- jQuery UI 1.11.4 -->
<!-- <script src="{{ asset('public/adminassets/bower_components/jquery-ui/jquery-ui.min.js') }}"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  // $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<!-- <script src="{{ asset('public/adminassets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script> -->
<!-- DataTables -->
<script src="{{ asset('public/adminassets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminassets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('public/adminassets/bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('public/adminassets/bower_components/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('public/adminassets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('public/adminassets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('public/adminassets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('public/adminassets/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('public/adminassets/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('public/adminassets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('public/adminassets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('public/adminassets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('public/adminassets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('public/adminassets/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/adminassets/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('public/adminassets/dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/adminassets/dist/js/demo.js') }}"></script>
<!-- Map Script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfDqf_FB1kdwhjUeTPsUViVuzaamCrHwU&libraries=places&callback=initMap">
</script>

<script type="text/javascript">
function initialize() {
        var address = (document.getElementById('my-address'));
        var autocomplete = new google.maps.places.Autocomplete(address, { types: ['geocode','establishment'], componentRestrictions : { country: ['in'] }});
        autocomplete.setTypes(['geocode']);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
      }

      
      
      document.getElementById("lat").value = place.geometry.location.lat();
      document.getElementById("long").value = place.geometry.location.lng();
      
      initMap(place.geometry.location.lat(),place.geometry.location.lng());

      coordinates_to_address(place.geometry.location.lat(),place.geometry.location.lng());

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
    }
    
    


      });
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfDqf_FB1kdwhjUeTPsUViVuzaamCrHwU&libraries=places"   async defer>
        </script>


        <script>

function initMap(lat,long) {

  

  if((lat == '' || long == '') || (lat == undefined || long == undefined))
  {
    var myLatLng = {lat: 23.022505, lng: 72.5713621};
  }
  else
  {
    var myLatLng = {lat: lat, lng: long};
  }
    
  
  

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: myLatLng
  });

  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    draggable: true,
    title: 'Hello World!'
  });

  var lat = marker.getPosition().lat();
  var lng = marker.getPosition().lng();

  document.getElementById("lat").value = marker.getPosition().lat();
      document.getElementById("long").value = marker.getPosition().lng();

      google.maps.event.addListener(marker, 'dragend', function (event) {
    document.getElementById("lat").value = this.getPosition().lat();
  document.getElementById("long").value = this.getPosition().lng();
  coordinates_to_address(this.getPosition().lat(), this.getPosition().lng());
});


  }

  function coordinates_to_address(lat, lng) {
    debugger

    var geocoder = new google.maps.Geocoder();


    var latlng = new google.maps.LatLng(lat, lng);

    geocoder.geocode({'latLng': latlng}, function(results, status) {
    
        if(status == google.maps.GeocoderStatus.OK) {
            if(results[0]) {
        $('#my-address').val(results[0].formatted_address);
        var add= results[0].formatted_address ;
        var  value=add.split(",");

                    count=value.length;
                    country=value[count-1];
                    state=value[count-2];
          city=value[count-3];

          var pincode  = state.split(" ");
          var lastVar = pincode.pop();
          var restVar = pincode.join(" ");

          $('#country').val(country);
          $('#state').val(restVar);
          $('#city').val(city);
          // $('#pincode').val(lastVar);
          

            } else {
                alert('No results found');
            }
        } else {
            var error = {
                'ZERO_RESULTS': 'Kunde inte hitta adress'
            }

            // alert('Geocoder failed due to: ' + status);
            $('#my-address').html('<span class="color-red">' + error[status] + '</span>');
        }
    });
}
</script> 
  

  <!-- Map end -->
<script>

  //Date picker
    // $('#available_from').datepicker({
    //   autoclose: true
    // })

    
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>