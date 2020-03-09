

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Edit User Profile</h1>


<div class="row">

            <!-- First Column -->
            <div class="col-lg-12">

              <!-- Custom Text Color Utilities -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Edit User Profile</h6><br>
				  <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error)
        {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error; ?>                    
            </div>
        <?php }
        $success = $this->session->flashdata('success');
        if($success)
        {
            ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $success; ?>                    
            </div>
        <?php } ?>
                </div>
                <div class="card-body">
                 <form class="user" method="post" id="form_iconic_validation" action="<?php echo base_url() ?>users/editProfileSave">
                <div class="form-group row">
                
                  <div class="col-sm-3">
                    <input type="text" class="form-control form-control-user" id="firstName" name="firstName" placeholder="First Name" value="<?php echo $users->first_name;?>">
                  </div>
				   <div class="col-sm-3">
                    <input type="text" class="form-control form-control-user" id="middleName" name="middleName" placeholder="Middle Name" value="<?php echo $users->middle_name;?>">
                  </div>
				  <div class="col-sm-3">
                    <input type="text" class="form-control form-control-user" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $users->last_name;?>">
                  </div>
                </div>

				<div class="form-group row">
                
                  <div class="col-sm-3 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="userName" name="userName"  placeholder="User Name" value="<?php echo $users->username;?>">
                  </div>
				  <div class="col-sm-3">
                    <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email Address" value="<?php echo $users->email;?>">
                  </div>
				   <div class="col-sm-3">
                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" >
                  </div>
                </div>
				  


				<div class="form-group row">
                  <div class="col-sm-3 mb-3 mb-sm-0"> <b>Address Type : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
					<input type="radio" id="addressType" name="addressType" value="shipping">
					<label for="male">Shipping</label>
					<input type="radio" id="addressType" name="addressType" value="billing">
					<label for="female">Billing</label><br>
                  </div>
				   
                </div>
                            
				<div class="form-group row">
             	   <div class="col-sm-9 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="address1" name="address1" placeholder="Address 1" value="<?php echo $users->address_line1;?>">
                  </div>
			    </div>

				<div class="form-group row">
            	   <div class="col-sm-9 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="address2" name="address2" placeholder="Address 2" value="<?php echo $users->address_line2;?>">
                  </div>
			    </div>

				<div class="form-group row">
            	   <div class="col-sm-3 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="city" name="city" placeholder="City" value="<?php echo $users->city;?>">
                  </div>
                  <div class="col-sm-3 mb-3 mb-sm-0">
                  <input type="text" class="form-control form-control-user" id="country" name="country" placeholder="Country" value="<?php echo $users->country;?>">
                  </div>
                </div>
				<div class="form-group row">
                  
				 
			   <div class="col-sm-9 mb-3 mb-sm-0">
                    <button type="submit" class="btn btn-primary btn-user btn-block"><i class="icon-ok"></i> Edit Profile</button>
                  </div>
			    </div>

              </form>
			 </div>
              </div>

             

            </div>

            

            

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <script type="text/javascript" charset="utf-8">
      $(window).on('load', function(){
          var customer_table =  $("#dataTable").dataTable();
      });
    </script>
<script src="<?php echo base_url(); ?>assets/js/user.js" type="text/javascript"></script>