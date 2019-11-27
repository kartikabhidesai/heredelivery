<?php include('header.php'); ?>

 <div class="main-panel">
<div class="main-content">
   <div class="content-wrapper">
 
<section class="basic-elements">
    <div class="row">
        <div class="col-sm-12">
            <div class="content-header">Admin Post</div>
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
                                        <label for="basicInput"> text</label>
                                        <input type="text" name="post_text"  class="form-control" id="basicInput" required="">
                                        <input type="hidden" name="post_type" value="text">
                                    </fieldset>
                                </div>
                                
                                
                                      <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        <label for="basicInput">Image</label>
                                        <input type="file" name="image[]"  class="form-control" id="basicInput" required="" multiple>
                                    </fieldset>
                                </div>
                                    
                               
                            </div>
                              
                             <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-1">
                                    <fieldset class="form-group">
                                        
                                        <button class="btn btn-raised btn-primary" name="add" value="save" type="submit" >Save</button>
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

