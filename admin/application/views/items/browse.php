

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Items</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Items</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Item Name</th>
                      <th>Item Group</th>
                      <th>Standard Rate</th>
                      <th>Image</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Item Name</th>
                      <th>Item Group</th>
                      <th>Standard Rate</th>
                      <th>Image</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($items as $item) { ?>
                      <tr>
                        <td><?=$item['item_name'];?></td>
                        <td><?=$item['item_group'];?></td>
                        <td style="text-align:right;"><?=$item['standard_rate'];?></td>
                        <td>
                          <?php if($item['image'] != NULL){ ?>
                          <img style="max-width:100px;max-height:100px;" src="<?="http://vmmadairy.ribox.me".$item['image'];?>"/>
                        <?php } ?>
                        </td>
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
