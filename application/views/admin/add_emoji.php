<?php include('header.php'); ?>

 <div class="main-panel">
<div class="main-content">
   <div class="content-wrapper">
 
<section class="basic-elements">
    <div class="row">
        <div class="col-sm-12">
            <div class="content-header"><?php if(!empty($view)){ echo "Update"; }else{ echo "Add"; } ?> Emoji</div>
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
                      <form class="form" method="post"  enctype= multipart/form-data>
              <div class="form-body">
                            <div class="row">
                                
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput"> Name</label>
                                        <input type="text" name="name" <?php if(!empty($view)){ ?> value="<?php echo $view->name; ?>" <?php } ?> class="form-control" id="basicInput" required="">
                                    </fieldset>
                                </div>
                                
                                
                                      <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput"> Emoji</label>
                                        <!---->
                                         <?php if(!empty($view->emoji)){ ?>
                                         <div class="image-upload"> <label for="file-input"> 
<img src="<?php echo base_url($view->emoji); ?>" height="100" width="100" title="Click on to change" id="blah" alt="your image" width="100" height="100" /> </label>
<input type="file" name="emoji"  id="file-input" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
    <input type="hidden" value="<?php if(!empty($view)){ echo $view->emoji; } ?>" name="old_image"></div>
<style>
.image-upload > input { display: none; }

</style>
               
               <!---->
                <?php }else{ ?>  
                                        <input type="file" name="emoji"  class="form-control" id="basicInput" required="">
                                        <?php } ?>
                                    </fieldset>
                                </div>
                                    
                               
                            </div>
                              
                             <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        
                                        <button class="btn btn-raised btn-primary" name="<?php if(!empty($view)){ echo "update"; }else{ echo "add"; } ?>" value="save" type="submit" >Save</button>
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

