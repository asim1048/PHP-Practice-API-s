<?php

if(!empty($this->session->flashdata('success'))){ ?>
	
			<div class="alert alert-success">
					<strong>Well done!</strong> <?php echo $this->session->flashdata('success'); ?>
					
			</div>

<?php } ?>

<?php if(!empty($this->session->flashdata('fail'))){ ?>

	    	  <div class="alert alert-danger">
					<strong>Failed!</strong> <?php echo $this->session->flashdata('fail'); ?>
					
			</div>

<?php } ?>