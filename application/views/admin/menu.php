<div class="sidebar-content">
          <div class="nav-container">
            <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
              <li class=" nav-item <?php if($this->uri->segment(2) == "Home"){ echo "active" ; } ?>">
                 <a href="<?php echo base_url('admin/Home') ;  ?>"><i class="fa fa-home"></i><span data-i18n="" class="menu-title">Dashboard</span></a>
              </li>
               <li class=" nav-item <?php if($this->uri->segment(2) == "Users"){ echo "active" ; } ?>">
               <a href="<?php echo base_url('admin/Users/') ;  ?>"><i class="fa fa-users"></i><span data-i18n="" class="menu-title">Users</span></a>
              </li>
              <li class=" nav-item <?php if($this->uri->segment(2) == "Post"){ echo "active" ; } ?>">
               <a href="<?php echo base_url('admin/Post/') ;  ?>"><i class="fa fa-list"></i><span data-i18n="" class="menu-title">Post</span></a>
              </li>
			 
              	 <li class=" nav-item <?php if($this->uri->segment(2) == "Emoji"){ echo "active" ; } ?>">
               <a href="<?php echo base_url('admin/Emoji/') ;  ?>"><i class="fa fa-smile-o"></i><span data-i18n="" class="menu-title">Emoji</span></a>
              </li>
              <li class=" nav-item <?php if($this->uri->segment(2) == "About_us"){ echo "active" ; } ?>">
               <a href="<?php echo base_url('admin/About_us/') ;  ?>"><i class="fa fa-info-circle"></i><span data-i18n="" class="menu-title">About us</span></a>
              </li>
              <li class=" nav-item <?php if($this->uri->segment(2) == "Contact_us"){ echo "active" ; } ?>">
               <a href="<?php echo base_url('admin/Contact_us/') ;  ?>"><i class="fa fa-phone-square"></i><span data-i18n="" class="menu-title">Contact us</span></a>
              </li>
              <li class=" nav-item <?php if($this->uri->segment(2) == "Privacy"){ echo "active" ; } ?>">
               <a href="<?php echo base_url('admin/Privacy/') ;  ?>"><i class="fa fa-file-text"></i><span data-i18n="" class="menu-title">Privacy</span></a>
              </li>
               <li class=" nav-item <?php if($this->uri->segment(2) == "Terms"){ echo "active" ; } ?>">
               <a href="<?php echo base_url('admin/Terms/') ;  ?>"><i class="fa fa-file-text"></i><span data-i18n="" class="menu-title">Terms</span></a>
              </li>
               <li class=" nav-item <?php if($this->uri->segment(2) == "Post_Report"){ echo "active" ; } ?>">
               <a href="<?php echo base_url('admin/Post_Report/') ;  ?>"><i class="fa fa-list"></i><span data-i18n="" class="menu-title">Post Reports</span></a>
              </li>
               <li class=" nav-item <?php if($this->uri->segment(2) == "Comment_report"){ echo "active" ; } ?>">
               <a href="<?php echo base_url('admin/Comment_report/') ;  ?>"><i class="fa fa-commenting"></i><span data-i18n="" class="menu-title">Comment Report</span></a>
              </li>
            </ul>
          </div>
</div>