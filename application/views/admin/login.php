<?php if(isset($this->session->userdata["admin_user"]["username"])){  redirect('admin/Home') ; }else{  } ?>
<!DOCTYPE html>
<html lang="en" class="loading">
  
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Mushroomapp</title>
   
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/vendors/css/prism.min.css">
   
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/admin/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/admin/css/custom.css">
    
  </head>
  <style>
    iframe {
       margin-left:15px;
    }
    .card .card-block{
        padding: 40px 15px;
        background: #fff;
    }
    .nomrg{
        margin: 0px !important;
    }
    
    .card-block h2{
        color: #000 !important;
    }

  </style>


  <body data-col="1-column" class=" 1-column blank-page blank-page"  style="background:url('<?php echo base_url(); ?>assets/admin/img/bg.jpg'); background-size: cover">
      
    <div class="wrapper">
      <div class="main-panel" style="margin-top: 0px;">
        <div class="main-content">
          <div class="content-wrapper"><!--Login Page Starts-->
     <section id="login">
    <div class="container-fluid">
        <div class="row full-height-vh">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="card gradient-indigo-purple text-center width-400">
                    
                    <div class="card-body">
                        <div class="card-block">
                             <?php if($this->session->flashdata("login_failed")){ ?>
            <div class="alert alert-icon-left alert-danger alert-dismissible mb-2" role="alert" style="margin-top: 15px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php echo $this->session->flashdata("login_failed") ; ?>
            </div>
            <?php } ?> 
            <?php if($this->session->flashdata("message")){ ?>
            <div class="alert alert-icon-left alert-success alert-dismissible mb-2" role="alert" style="margin-top: 15px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php echo $this->session->flashdata("message") ; ?>
            </div>
            <?php } ?>
                            <h2 class="white" style="font-size: 25px; margin-bottom: 30px; font-weight: 500;"> Mushroomapp </h2>
                              
                            <form action="<?php echo base_url();?>admin/Login/log" method="post">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email" required >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">

                                        <input type="password" class="form-control" name="password" id="inputPass" placeholder="Password" required>
                                    </div>
                                </div>

                                <div class="form-group nomrg">
                                    <div class="col-md-12">
                                        <button type="submit" name="userSubmit" value="Submit" class="btn btn-pink btn-block btn-raised nomrg bgChnge">Submit</button>
                                     </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Login Page Ends-->
          </div>
        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url();?>assets/admin/vendors/js/core/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/vendors/js/core/popper.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/vendors/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/vendors/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/vendors/js/prism.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/vendors/js/jquery.matchHeight-min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/vendors/js/screenfull.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/vendors/js/pace/pace.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN APEX JS-->
    <script src="<?php echo base_url();?>assets/admin/js/app-sidebar.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/js/notification-sidebar.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/js/customizer.js" type="text/javascript"></script>
    <!-- END APEX JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- END PAGE LEVEL JS-->

  </body>
  

</html>