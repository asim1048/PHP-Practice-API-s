<div class="sidebar-menu">
		
			
		<header class="logo-env">
			
			<!-- logo -->
			<div class="logo">
				<a href="<?php echo SURL;?>">
					<img src="assets/images/logo@2x.png" width="120" alt="" />
				</a>
			</div>
			
						<!-- logo collapse icon -->
						
			<div class="sidebar-collapse">
				<a href="#" class="sidebar-collapse-icon with-animation1">
					<i class="entypo-menu"></i>
				</a>
			</div>
			
									
			
			<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
			<div class="sidebar-mobile-menu visible-xs">
				<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
					<i class="entypo-menu"></i>
				</a>
			</div>
			
		</header>
				
				
		<ul id="main-menu" class="">

			<?php 
				
				$user_status = $this->db->query("select user_status from users where '".$this->session->userdata('user')."'")->row()->user_status;
				//var_dump($user_status);
				 		$query = $this->db->query("select * from main_menu");
				


				foreach ($query->result() as $key => $value) { 
					//echo $value->pagename;
					//echo "<br>";
					
					if($this->router->fetch_class() == $value->pagename){
						$activepage =  "opened active";
					}else{
						$activepage = "";
					}


			?>	
				<li class="active opened<?php //echo $activepage; ?>"> 
					<a href="<?php if($value->pagename == "Dashboard"){echo base_url();}else{}?>">
						<i class="<?php echo $value->icon; ?>"></i>
						<span><?php echo $value->pagename;?></span>
					</a>

					<?php
					$activepage=""; 
						$query = $this->db->query("select * from submenu where parentid='".$value->id."'");
						// echo "<pre>";var_dump($query->result());
						if($query->num_rows() > 0){
							foreach ($query->result() as $key => $value) { 	

								if($this->router->fetch_class() == $value->subpagename){
									$activepage =  "active";
								}else{
									$activepage = "";
								}
								
								if($user->user_status == "2"){
									$hide = 0;	
									$con['conditions'] = array("u_id"=>$this->session->userdata('user'),"page_id"=>$value->id);
									$page_access = $this->common->count_record("user_rights",$con);
									if($page_access > 0){
										$hide = 1;
									}	

								}else{
									$hide = 1;
								}
								
								if($hide == 1){
					?>	

					<ul>
						<li class="<?php echo $activepage; ?>">
							<a href="<?php echo $value->pageurl;?> ">
								<span><?php echo $value->subpagename; ?></span>
							</a>
						</li>				
						
					</ul>

				    <?php }}} ?>
					
				</li>

			<?php } ?>
			
	
			
		
			<li>
				<a href="<?php echo SURL;?>Logout">
					<i class="entypo-chart-bar"></i>
					<span>Logout</span>
				</a>
			</li>
		</ul>
				
	</div>	