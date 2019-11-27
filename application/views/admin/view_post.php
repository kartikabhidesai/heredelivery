<?php include("header.php") ; ?>

 <div class="main-panel">

<div class="main-content">
   <div class="content-wrapper"><!--Statistics cards Starts-->
        
      <div class="row">
    <div class="col-12">
        <div class="content-header">    
		 
		 
		 <a class="danger p-0" title="Delete" href="<?php echo base_url('admin/Post_Report/delete_post/'.$view->id); ?>" onClick="return confirm('are you sure you want to delete..?')">
                                    <i class="fa fa-trash font-medium-3 mr-2"></i>   
                                    </a>
            <a href="<?php echo base_url('admin/Post_Report'); ?>">
             
			 <button class="btn btn-success pull-right">Back</button> 
             </a>
			 
       </div>
        
        
    </div>
</div>
<section id="about">
    <div class="row">
        <div class="col-12">
            <div class="content-header">Detail</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Post Information</h5>
                </div>
                <div class="card-body">
                    <div class="card-block">
                        <div class="mb-3">
                            <span class="text-bold-500 primary">post text:</span>
                            <span class="display-block overflow-hidden"><?php echo $view->post_text; ?>
                            </span>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <ul class="no-list-style">
                                    <li class="mb-2">
                                        <span class="text-bold-500 primary"><a><i class="icon-present font-small-3"></i> title:</a></span>
                                        <span class="display-block overflow-hidden"><?php echo $view->title; ?></span>
                                    </li>
                                   
                                    
                                </ul>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <ul class="no-list-style">
                                    <li class="mb-2">
                                        <span class="text-bold-500 primary"><a><i class="ft-map-pin font-small-3"></i> address:</a></span>
                                        <span class="display-block overflow-hidden"><?php echo $view->address; ?></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <ul class="no-list-style">
                                    <li class="mb-2">
                                        <span class="text-bold-500 primary"><a><i class="ft-globe font-small-3"></i>link:</a></span>
                                        <span class="display-block overflow-hidden"><?php echo $view->link; ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                         <div class="mb-3">
                            <span class="text-bold-500 primary">Image:</span>
                             <?php   $images=$view->image;  
                        if(!empty($images))
                        {
                            $images_arr=explode(",",$images);
                       
                            foreach($images_arr as $a){ ?>
                           <img src="<?php echo  base_url($a);?>" height="100" width="100">
                           <?php } } ?>
                            </span>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

  </div>
</div>
 
<?php include("footer.php") ; ?> 





