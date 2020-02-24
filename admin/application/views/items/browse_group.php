

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Item Groups</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Item Groups</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Group Name</th>
                      <th>Parent Group</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Group Name</th>
                      <th>Parent Group</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($item_groups as $item_group) { ?>
                      <tr>
                        <td><?=$item_group['item_group_name'];?></td>
                        <td><?=$item_group['parent_item_group'];?></td>
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
          var items_table =  $("#dataTable").dataTable();
      });
    </script>
