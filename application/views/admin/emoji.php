<?php include("header.php") ; ?>
<style>
    table#mytable.dataTable tbody tr:hover {
  background-color: #c6d9ec;
}
 
table#mytable.dataTable tbody tr:hover > .sorting_1 {
  background-color: #c6d9ec;
}
}
</style>

 <div class="main-panel">

<div class="main-content">
   <div class="content-wrapper"><!--Statistics cards Starts-->
        
      <div class="row">
    <div class="col-12">
        <div class="content-header">All Emoji 
		  <a href="<?php echo base_url('admin/Emoji/add'); ?>">
             
			 <button class="btn btn-success pull-right">+ Add New </button> 
             </a>
            
			 
       </div>
        <p class="content-sub-header">All Emoji data and Activities.</p>
         <?php if($this->session->flashdata("message")){ ?>
        <div class="alert alert-icon-left alert-success alert-dismissible mb-2" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		   <?php echo  $this->session->flashdata("message") ; ?>
        </div>
       <?php } ?> 
    </div>
</div>
<section id="extended">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"></h4>
                </div>
                <div class="card-body">
                <div class="card-body collapse show">
                                <div class="card-block card-dashboard">
                                    <table class="table table-responsive-md-md hover dataTable display" id="mytable" cellspacing="0" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
												<th>Name </th>
												<th>Image</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									  <?php $i = 1 ; 
									  if(!empty($view)){
									  foreach($view as $vw){ ?>
										<tr>
										    
										    <td><?php echo $i; ?></td>
										    <td><?php echo $vw->name ; ?></td>
											<td><img src="<?php echo base_url($vw->emoji); ?>" height="40" width="40"></td>
										   
											<td>
											  <a title="Edit" href="<?php echo base_url('admin/Emoji/edit/').$vw->id ?>" >
                                                    <i class="ft-edit-2  font-medium-3 mr-2 " style='color:green;'></i>
                                               </a> 
                                               <a class="danger p-0" title="Delete" href="<?php echo base_url('admin/Emoji/delete/'.$vw->id); ?>" onClick="return confirm('Are you sure want to delete..?')">
                                      <i class="ft-x font-medium-3 mr-2"></i> 
                                      </a>
											</td>	
										 </tr>
									  <?php $i++ ; } }?>   
									</tbody>
                                    </table>
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





