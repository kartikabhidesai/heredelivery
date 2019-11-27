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
        <div class="content-header">User
		   <?php /* <a href="<?php echo base_url('admin/User_listing/add'); ?>">
             
			 <button class="btn btn-success pull-right">+ Add New </button> 
             </a> */ ?>
            
			 
       </div>
       
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
                    <div class="card-block">
                        <table class="table table-responsive-md-md hover dataTable display" id="mytable" cellspacing="0"  >
                            <thead>
                                <tr>
                                <th>#</th> 
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Phone Number</th>
                                 <th>Email </th>
                                 <th>Profile</th>
                                 <th>Plus</th>
                                 <th>Action</th>
                    								
                                 </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $i=1;
                            foreach ($view as $vw)
                             {  ?>
                                  <tr>     
                                  <td><?php echo $i; ?></td>
                                   <td><?php echo $vw->frist_name." ".$vw->last_name; ?></td>
                                    <td><?php echo $vw->username; ?></td>
                                    <td><?php echo $vw->phone_number; ?></td>
                                    <td><?php echo $vw->email; ?></td>
                                    <?php if(!empty($vw->profile))
                                    {
                                        $profile=$vw->profile;
                                    }
                                    else
                                    {
                                        $profile="assets/defalt.png";
                                    }
                                    ?>
                                    <td><a href="<?php echo base_url($profile); ?>" target="_blank"><img src="<?php echo base_url($profile); ?>" width="80" height="80"></a></td>
                                    
                                    <td> <?php if($vw->is_plus=="1"){  ?>
                                    <a class="danger p-0" title="Off" href="<?php echo base_url('admin/Users/is_plus/'.$vw->id.'/0'); ?>" >
                                    <i class="fa fa-toggle-on font-medium-3 mr-2" aria-hidden="true" style="color:#0CC27E"></i>   
                                    </a> 
                                    <br/>
                                    Ends in <?php echo $vw->is_plus_enddate; ?>
                                    <?php }else{ ?>
                                    <a class="danger p-0" title="On" href="<?php echo base_url('admin/Users/is_plus/'.$vw->id.'/1'); ?>" >
                                    <i class="fa fa-toggle-off font-medium-3 mr-2" aria-hidden="true"></i>  
                                    </a> 
                                    <?php } ?></td>
                                    <td><a class="danger p-0" title="Delete" href="<?php echo base_url('admin/Users/delete/'.$vw->id); ?>" onClick="return confirm('are you sure you want to delete..?')">
                                    <i class="fa fa-trash font-medium-3 mr-2"></i>   
                                    </a></td>
                                    <?php /*
                                    <td>
                                    <a class="success p-0" title="Edit" href="<?php echo  base_url('admin/User_listing/edit/'.$vw->id); ?>" >
                                    <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                    </a>
                                    <a class="danger p-0" title="Delete" href="<?php echo base_url('admin/User_listing/delete/'.$vw->id); ?>" onClick="return confirm('are you sure want to delete..?')">
                                    <i class="ft-x font-medium-3 mr-2"></i>   
                                    </a>  </td>
                                      */ ?>
                                   </tr>
                                  <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

  </div>
</div>
 
<?php include("footer.php") ; ?> 





