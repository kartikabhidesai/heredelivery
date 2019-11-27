<?php if(isset($this->session->userdata["admin_user"]["username"])){  }else{ redirect('admin/Login') ; } ?>
<!DOCTYPE html>
<html lang="en" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    
    <?php $ad_name = $this->db->get('admin_user')->row()->username ; 
	$ad_logo = $this->db->get('admin_user')->row()->admin_logo ;   ?>
    <title>Administrator - <?php echo $ad_name ; ?></title>
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url('assets/admin/') ;  ?><?php echo base_url().$ad_logo ;  ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/admin/') ;  ?><?php echo base_url().$ad_logo ;  ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url('assets/admin/') ;  ?><?php echo base_url().$ad_logo ;  ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url('assets/admin/') ;  ?><?php echo base_url().$ad_logo ;  ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/admin/') ;  ?><?php echo base_url().$ad_logo ;  ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/admin/') ;  ?><?php echo base_url().$ad_logo ;  ?>">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/') ;  ?>fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/') ;  ?>fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/') ;  ?>fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/') ;  ?>vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/') ;  ?>vendors/css/prism.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/') ;  ?>vendors/css/chartist.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN Camiony CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/') ;  ?>css/app.css">
    <!-- END Camiony CSS-->
    <!-- BEGIN Page Level CSS-->
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <!-- END Custom CSS-->
  </head>
  <style>
input[type="search"] {
    height: 40px;
    border-radius: 10px;
}
div#mytable_length select {
    height: 40px;
    border-radius: 10px;
}
</style>  

  <body data-col="2-columns" class=" 2-columns ">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <div data-active-color="black" data-background-color="white" data-image="" class="app-sidebar">
        <!-- main menu header-->
        <!-- Sidebar Header starts-->
        <div class="sidebar-header">
          <div class="logo clearfix">
              <a href="<?php echo base_url('admin/Home') ;  ?>" class="logo-text float-left">
              <div class="logo-img">
			  <?php if($ad_logo!=''){ ?>
			  <img src="<?php echo base_url().$ad_logo ; ?>" height="90" width="120" style="margin-top: -15px;margin-left: 27px;"/>
			  <?php }else{ ?>
			  <h5><?php echo $ad_name; ?></h5>
			  <?php } ?>
			  </div>
              </a>
              <a id="sidebarToggle" href="javascript:;" class="nav-toggle d-none d-sm-none d-md-none d-lg-block">
              <i data-toggle="expanded" class="ft-toggle-right toggle-icon"></i>
              </a>
              <a id="sidebarClose" href="javascript:;" class="nav-close d-block d-md-block d-lg-none d-xl-none"><i class="ft-x"></i></a>
           </div>
        </div>
        <!-- Sidebar Header Ends-->
        <!-- / main menu header-->
        <!-- main menu content-->
        <?php include('menu.php') ; ?>
        <!-- main menu content-->
        <div class="sidebar-background"></div>
        <!-- main menu footer-->
        <!-- include includes/menu-footer-->
        <!-- main menu footer-->
      </div>
      <!-- / main menu-->


      <!-- Navbar (Header) Starts-->
      <nav class="navbar navbar-expand-lg navbar-light bg-faded">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
          </div>
          <div class="navbar-container">
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                  <ul class="navbar-nav">
                        <li class="dropdown nav-item">
                             <a id="dropdownBasic3" href="<?php echo base_url('administrator/Home/profile') ?>" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle"><i class="ft-user font-medium-3 blue-grey darken-4"></i>
                                <p class="d-none">User Settings</p>
                            </a>
                                  <div ngbdropdownmenu="" aria-labelledby="dropdownBasic3" class="dropdown-menu dropdown-menu-right">
                                       <!--<a href="<?php echo base_url('administrator/Home/profile') ?>" class="dropdown-item py-1">
                                           <i class="ft-edit mr-2"></i><span>Edit Profile</span>
                                       </a>
                                      <div class="dropdown-divider"></div>-->
                                      <!--<a href="<?php echo base_url('admin/Home/change_password'); ?>" class="dropdown-item"><i class="fa fa-key mr-2"></i><span>Change password</span></a>-->
                                      <a href="<?php echo base_url('admin/Login/logout') ?>" class="dropdown-item">
                                         <i class="ft-power mr-2"></i><span>Logout</span>
                                      </a>
                                  </div>
                        </li>                
                  </ul>
            </div>
          </div>
        </div>
      </nav>
      <!-- Navbar (Header) Ends-->      
       
       
       