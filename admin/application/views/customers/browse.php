

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Customers</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Customer Name</th>
                      <th>Customer Type</th>
                      <th>Customer Group</th>
                      <th>Username</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Customer Name</th>
                      <th>Customer Type</th>
                      <th>Customer Group</th>
                      <th>Username</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($customers as $customer) { ?>
                      <tr>
                        <td><?=$customer['customer_name'];?></td>
                        <td><?=$customer['customer_type'];?></td>
                        <td><?=$customer['customer_group'];?></td>
                        <td><?=$customer['username'];?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
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
