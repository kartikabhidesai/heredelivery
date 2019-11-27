<?php include("header.php") ; ?>
<style>
.new{
  height: 115px !important;
}  
</style>
      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->

<!---->
<div class="row">
	<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-blackberry">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
							<h3 class="font-large-1 mb-0"><?php echo  count($users);?></h3>
							<span>Total Users</span>
						</div>
						<div class="media-right white text-right">
							<i class="fa fa-users" style="font-size: 60px;"></i>
						</div>
					</div>
				</div>
				<div id="Widget-line-chart" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">					
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-ibiza-sunset">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
							<h3 class="font-large-1 mb-0"><?php echo  count($post);?></h3>
							<span>Total Post <span>
						</div>
						<div class="media-right white text-right">
							<i class="fa fa-th-list" style="font-size: 60px;"></i>
							
						</div>
					</div>
				</div>
				<div id="Widget-line-chart1" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">					
				</div>

			</div>
		</div>
	</div>
	
		<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-pomegranate">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
							<h3 class="font-large-1 mb-0"><?php echo  count($is_plus);?></h3>
							<span>Total Plus User <span>
						</div>
						<div class="media-right white text-right">
							<i class="fa fa-plus-square" style="font-size: 60px;"></i>
							
						</div>
					</div>
				</div>
				<div id="Widget-line-chart1" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">					
				</div>

			</div>
		</div>
	</div>
	
	



</div>
<!---->



         </div>
     </div>

<?php include('footer.php') ?>