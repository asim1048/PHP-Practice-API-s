
<?php require_once("head.php"); ?>

<body class="page-body  page-fade gray">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->	
	<?php require_once("siderbar.php"); ?>
	
	<div class="main-content">
		
<div class="row">
	
	<!-- Profile Info and Notifications -->
	<div class="col-md-6 col-sm-8 clearfix">
		
		<ul class="user-info pull-left pull-none-xsm">
		
						<!-- Profile Info -->
			<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
				
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="assets/images/thumb-1@2x.png" alt="" class="img-circle" width="44" />
					<?php echo ucwords($user->name); ?>
				</a>
				
			</li>
		
		</ul>
<?php
// $con['conditions']= array("c_id" => $this->session->userdata['companyid']);
// $notifications = $this->common->get_single_row("company",$con)->notification;

?>	

<script type="text/javascript">
	$(document).on('click','.noti',function(){ 
		
			$.ajax({
			  
			   url:"<?php echo SURL;?>Category/update_notification",  
			   method:"POST",  
			   // data:{id:id},  
			   dataType:"text",  
			   success:function(data){
			   		
					$(".count_noti").hide();
			   				
				}
			});
		
	});
</script>	

				
		<ul class="user-info pull-left pull-right-xs pull-none-xsm">
			
			<!-- Raw Notifications -->
			<li class="notifications dropdown">
				
				<a href="#" class="dropdown-toggle noti" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="entypo-attention"></i>
					<span class="badge badge-info count_noti"><?php if($notifications > 0){ echo $notifications; } ?></span>
				</a>
				
				<ul class="dropdown-menu">
					<li class="top">
						<?php //if($notifications > 0){ ?>
						<style type="text/css">
						.status_line{color:black;}
						</style>	
						<p class="small">
							You have <strong><?php //echo $notifications;?></strong> new notifications.
						</p>
						<?php //} ?>
					</li>

					<?php
						//$con['conditions'] = array("company_id" => $this->session->userdata['companyid']);
						// $query = $this->common->get_rows_by_limit("activity", $con,'act_id','5','DESC');
						// foreach($query as $key => $value){
					
					 ?>
				 

					<li>
						<ul class="dropdown-menu-list scroller">
							<li class="unread notification-success">
								<a href="javascript:void(0)">
									<i class="entypo-user-add pull-right"></i>
									
									<span class="line status_line">
										<?php //echo $value['caption'];?>
									</span>
									
									<span class="line small">
										<?php

										 //echo ucfirst($this->check->timeAgo(strtotime($value['act_date']." ".$value['time']))); 
										?>
										ago
									</span>
								</a>
							</li>
							
							
						</ul>
					</li>
					<?php //} ?>

					<li class="external">
						<a href="Activity/">View all notifications</a>
					</li>				
				</ul>
				
			</li>
						
		
		
		</ul>
	
	</div>
	
	
	
	
</div>

<hr />
<script type="text/javascript">
jQuery(document).ready(function($) 
{
	// Sample Toastr Notification
	setTimeout(function()
	{			
		var opts = {
			"closeButton": true,
			"debug": false,
			"positionClass": rtl() || public_vars.$pageContainer.hasClass('right-sidebar') ? "toast-top-left" : "toast-top-right",
			"toastClass": "black",
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};

		// toastr.success("You have been awarded with 1 year free subscription. Enjoy it!", "Account Subcription Updated", opts);
	}, 3000);
	
	// Sparkline Charts
	$(".top-apps").sparkline('html', {
	    type: 'line',
	    width: '50px',
	    height: '15px',
	    lineColor: '#ff4e50',
	    fillColor: '',
	    lineWidth: 2,
	    spotColor: '#a9282a',
	    minSpotColor: '#a9282a',
	    maxSpotColor: '#a9282a',
	    highlightSpotColor: '#a9282a',
	    highlightLineColor: '#f4c3c4',
	    spotRadius: 2,
	    drawNormalOnTop: true
	 });

	$(".monthly-sales").sparkline([1,5,6,7,10,12,16,11,9,8.9,8.7,7,8,7,6,5.6,5,7,5,4,5,6,7,8,6,7,6,3,2], {
		type: 'bar',
		barColor: '#ff4e50',
		height: '55px',
		width: '100%',
		barWidth: 8,
		barSpacing: 1
	});	
	
	$(".pie-chart").sparkline([2.5,3,2], {
	    type: 'pie',
	    width: '95',
	    height: '95',
	    sliceColors: ['#ff4e50','#db3739','#a9282a']
	});
    
    
	$(".daily-visitors").sparkline([1,5,5.5,5.4,5.8,6,8,9,13,12,10,11.5,9,8,5,8,9], {
	    type: 'line',
	    width: '100%',
	    height: '55',
	    lineColor: '#ff4e50',
	    fillColor: '#ffd2d3',
	    lineWidth: 2,
	    spotColor: '#a9282a',
	    minSpotColor: '#a9282a',
	    maxSpotColor: '#a9282a',
	    highlightSpotColor: '#a9282a',
	    highlightLineColor: '#f4c3c4',
	    spotRadius: 2,
	    drawNormalOnTop: true
	 });


	$(".stock-market").sparkline([1,5,6,7,10,12,16,11,9,8.9,8.7,7,8,7,6,5.6,5,7,5], {
	    type: 'line',
	    width: '100%',
	    height: '55',
	    lineColor: '#ff4e50',
	    fillColor: '',
	    lineWidth: 2,
	    spotColor: '#a9282a',
	    minSpotColor: '#a9282a',
	    maxSpotColor: '#a9282a',
	    highlightSpotColor: '#a9282a',
	    highlightLineColor: '#f4c3c4',
	    spotRadius: 2,
	    drawNormalOnTop: true
	 });

	 
	 $("#calendar").fullCalendar({
		header: {
			left: '',
			right: '',
		},
		
		firstDay: 1,
		height: 200,
	});
});


function getRandomInt(min, max) 
{
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
</script>

<style type="text/css">
	.error{color: red;}
</style>

<div class="row">
	<div class="col-md-12">
		
		<div class="panel panel-primary" data-collapsed="0">