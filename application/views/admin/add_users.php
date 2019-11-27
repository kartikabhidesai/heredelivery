<?php include('header.php'); ?>
<style>
    #cke_1_contents
    {
        height: 378px !important; 
    }
</style>
 <div class="main-panel">
<div class="main-content">
   <div class="content-wrapper">
 
<section class="basic-elements">
    <div class="row">
        <div class="col-sm-12">
            <div class="content-header"><?php if(!empty($view)){ echo "Update"; }else{ echo "Add"; } ?> Users/Listing</div>
            <!--  -->
            <?php if($this->session->flashdata("errmessage")){ ?>
<div class="alert alert-icon-left alert-danger alert-dismissible mb-2" role="alert" style="margin-top: 15px;">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
<?php echo $this->session->flashdata("errmessage") ; ?>
</div>
<?php } ?> 
<?php if($this->session->flashdata("message")){ ?>
<div class="alert alert-icon-left alert-success alert-dismissible mb-2" role="alert" style="margin-top: 15px;">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
<?php echo $this->session->flashdata("message") ; ?>
</div>
<?php } ?>
            <!--  -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-body">
                    <div class="px-3">
                      <form class="form" method="post"  enctype="multipart/form-data">
              <div class="form-body">
                            <div class="row">
                                 <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Company Name</label>
                                        <input type="text" name="company_name" <?php if(!empty($view)){ ?> value="<?php echo $view->company_name; ?>" <?php } ?> class="form-control" id="basicInput" required="">
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Select Main Category</label>
                                        <select class="form-control" name="category_id"  required>
                                            <option value="">--Select Category--</option>
                                            <?php foreach($category as $mn){ ?>
                                            <option value="<?php echo $mn->id;?>" <?php if(!empty($view)){ if($mn->id==$view->category_id){ echo "selected"; }  } ?> ><?php echo $mn->name;?></option>
                                            <?php } ?>
                                        </select>
                                        
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Telephone 1</label>
                                        <input type="number" name="telephone1" <?php if(!empty($view)){ ?> value="<?php echo $view->telephone1; ?>" <?php } ?> class="form-control" id="basicInput" required="">
                                       
                                    </fieldset>
                                </div>
                                 <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Telephone 2</label>
                                        <input type="number" name="telephone2" <?php if(!empty($view)){ ?> value="<?php echo $view->telephone2; ?>" <?php } ?> class="form-control" id="basicInput" >
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Email Address</label>
                                        <input type="email" name="email" <?php if(!empty($view)){ ?> value="<?php echo $view->email; ?>" <?php } ?> class="form-control" id="basicInput" required="">
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Website URL</label>
                                        <input type="text" name="url" <?php if(!empty($view)){ ?> value="<?php echo $view->url; ?>" <?php } ?> class="form-control" id="basicInput" >
                                    </fieldset>
                                </div>
                                </div>
                                <div class="row">
                                 <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Whatsapp</label>
                                        <input type="text" name="whatapp" <?php if(!empty($view)){ ?> value="<?php echo $view->whatapp; ?>" <?php } ?> class="form-control" id="basicInput" >
                                    </fieldset>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Image 1 Name</label>
                                       
                                        <input type="text" name="image1name" <?php if(!empty($view)){ ?> value="<?php echo $view->image1name; ?>" <?php } ?> class="form-control" id="basicInput" >
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Image 2 Name</label>
                                        <input type="text" name="image2name" <?php if(!empty($view)){ ?> value="<?php echo $view->image2name; ?>" <?php } ?> class="form-control" id="basicInput" >
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Image 3 Name</label>
                                        <input type="text" name="image3name" <?php if(!empty($view)){ ?> value="<?php echo $view->image3name; ?>" <?php } ?> class="form-control" id="basicInput">
                                    </fieldset>
                                </div>
                                
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Image1</label>
                                         <?php if(!empty($view->image1)){ ?>
            <div class="image-upload1"> <label for="file-input1"> 
            <img src="<?php echo base_url($view->image1); ?>" height="100" width="100" title="Click on to change" id="blah1" alt="your image" width="100" height="100" />
            </label>
            <input type="file" name="image1" id="file-input1" onchange="document.getElementById('blah1').src = window.URL.createObjectURL(this.files[0])">
            <input type="hidden" value="<?php if(!empty($view)){ echo $view->image1; } ?>" name="old_image1"></div>
            <style>
            .image-upload1 > input { display: none; }
            
            </style>
            <!---->
            <?php }else{ ?>
             <input type="file" name="image1"  class="form-control" id="basicInput" >
             <?php } ?>
                                    </fieldset>
                                </div>
                                
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">image2</label>
                                         <?php if(!empty($view->image2)){ ?>
            <div class="image-upload2"> <label for="file-input2"> 
            <img src="<?php echo base_url($view->image2); ?>" height="100" width="100" title="Click on to change" id="blah2" alt="your image" width="100" height="100" />
            </label>
            <input type="file" name="image2" id="file-input2" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
            <input type="hidden" value="<?php if(!empty($view)){ echo $view->image2; } ?>" name="old_image2"></div>
            <style>
            .image-upload2 > input { display: none; }
            
            </style>
            <!---->
            <?php }else{ ?>
             <input type="file" name="image2"  class="form-control" id="basicInput" >
             <?php } ?>
                                       
                                    </fieldset>
                                </div>
                                
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">image3</label>
                                         <?php if(!empty($view->image3)){ ?>
            <div class="image-upload3"> <label for="file-input3"> 
            <img src="<?php echo base_url($view->image3); ?>" height="100" width="100" title="Click on to change" id="blah3" alt="your image" width="100" height="100" />
            </label>
            <input type="file" name="image3" id="file-input3" onchange="document.getElementById('blah3').src = window.URL.createObjectURL(this.files[0])">
            <input type="hidden" value="<?php if(!empty($view)){ echo $view->image3; } ?>" name="old_image3"></div>
            <style>
            .image-upload3 > input { display: none; }
            
            </style>
            <!---->
            <?php }else{ ?>
             <input type="file" name="image3"  class="form-control" id="basicInput" >
             <?php } ?>
                                        
                                    </fieldset>
                                </div>
                                
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Company Logo</label>
                                         <?php if(!empty($view->logo)){ ?>
            <div class="image-upload"> <label for="file-input"> 
            <img src="<?php echo base_url($view->logo); ?>" height="100" width="100" title="Click on to change" id="blah" alt="your image" width="100" height="100" />
            </label>
            <input type="file" name="logo" id="file-input" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
            <input type="hidden" value="<?php if(!empty($view)){ echo $view->logo; } ?>" name="old_logo"></div>
            <style>
            .image-upload > input { display: none; }
            
            </style>
            <!---->
            <?php }else{ ?>
             <input type="file" name="logo"  class="form-control" id="basicInput" >
             <?php } ?>
                                        
                                    </fieldset>
                                </div>
                                <!---->
                                
                                
                               
                            </div>
                                <div class="row">
                                
                                <div class="col-xl-6 col-lg-12 col-sm-12">
                        <div class="card">
                          
                          <div class="card-body">
                             <div class="card-block">
                                <fieldset class="form-group">
                                   <label for="basicInput">Address</label>
                                   <input type="text" class="form-control" <?php if(!empty($view)){ ?> value="<?php echo $view->address; ?>" <?php } ?>  name="address" id="pac-input" placeholder="Address">
                                    
                                    <br>
                                    <div id="map" class="height-400"></div>
                                </fieldset>
                              <!-- <div class="card-body">
                                        <div class="card-block">
                                        
                                           
                                        </div>
                                    </div> -->
                             </div>
                          </div>
                       </div>
                    </div>
                                <!---->
                               <div class="col-xl-6 col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label >About  company</label>
                                        <textarea type="text"  name="about_company" rows="5" id="descriptions"  class="form-control"  required=""><?php if(!empty($view)){ echo $view->about_company; } ?></textarea>
                                    </div>
                                    
                                 </div>
                                 
                                 
                                   </div>
                              
                             <div class="row">
                                <div class="col-xl-12 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        
                                       <center> <button class="btn btn-raised btn-primary" name="<?php if(!empty($view)){ echo "update"; }else{ echo "add"; } ?>" value="save" type="submit" >Save</button>
                                       </center>
                                    </fieldset>
                                </div> 
                            </div>
                        </div>
            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
    </div>
<?php  include('footer.php'); ?>
<script src="https://cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
<script>

CKEDITOR.replace( 'descriptions', {

} );
</script>  
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChbIrcGbwTkKU1TmuyB0WCOaj_jAJmuWk&libraries=places&callback=initAutocomplete" async defer></script>
	
     <script>
    $(document).ready( function () {
        $('#mytable').DataTable();
    } );   
	</script> 
	
<script type="text/javascript">
   function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });
       

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              // icon: icon,
              icon: 'https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png',
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      
<?php if(!empty($view)){ ?>
var add='<?php echo $view->address; ?>';
var lati='<?php echo $view->latitude; ?>';
var logi='<?php echo $view->longitude; ?>';
<?php }else{ ?>
var add="Centurion, Pretoria";
var lati="-25.872170";
var logi="28.195612";
<?php } ?>

         var locations = [ [add, lati, logi, 1], ];

                  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(lati, logi),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
       google.maps.event.addListener(map, "click", function (e) {

    //lat and lng is available in e object
    var latLng = e.latLng;
    //alert(latLng);
   
// 

});
    }
      }
</script>


