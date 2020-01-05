<?php include_once('include/header.php'); ?>


<?php 
if(!permission_check('company_wise_product_list')){
  ?>
  <script>
    window.location.href = '403.php';
  </script>
  <?php 
}
 ?>
 
<div class="right_col" role="main">
  <div class="row">

    <!-- page content -->

<!-- This div is for selecting Company Name -->
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">

          <!-- form starts form here -->
          <form class="form-horizontal form-bordered" id="select_company_form" action="" method="post">

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Select A Company</label>
              <div class="col-md-6">
               <select class="form-control" id="company_name" name="company_name" required="">
                <option value=""></option>

                <?php 
                include_once('class/Database.php');
                $dbOb = new Database();
                $query = "SELECT distinct company FROM products ORDER BY company";
                $get_company = $dbOb->select($query);

                if ($get_company) {
                 while ($row = $get_company->fetch_assoc()) {
                   ?>

                   <option value="<?php echo $row['company'] ?>"><?php echo strtoupper($row['company']); ?></option>

                   <?php
                 }
               }
               ?>

             </select>
           </div>
         </div>

        <div class="form-group" style="display: none;">
          <label class="col-md-3 control-label" for="inputDefault">Company Name Hidden Field</label>
          <div class="col-md-6">
            <input type="text"class="form-control" id="company_name_hidden" name="company_name_hidden" readonly="">
          </div>
        </div>

       </form>
     </div>
   </div>
 </div>
<!-- end of  div for selecting Company Name -->


<!-- The following div is for showing data into data table  -->
 <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2 style="color: black">Product List <span id="show_company_name" style="color: black"></span></h2>
      <div class="row float-right" align="right">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <table id="datatable-buttons" class="table table-striped table-bordered">
        <thead>

        <tr>
              <th style="width: 12px">#</th>
              <th style="width: 80px">Company</th>
              <th style="width: 70px">ID</th>
              <th style="width: 70px">Name</th>
              <th style="width: 80px">Category</th>
              <th style="width: 35px">Company Price</th>
              <th style="width: 35px">MRP</th>
              <th style="width: 35px">Pack Size</th>
              <th style="width: 35px">Available QTY</th>
              <!-- <th style="width: 80px">Barcode</th> -->
              <th style="width: 210px;text-align: center;">Action</th>
            </tr>
        </thead>


        <tbody id="data_table_body">
          

        </tbody>
      </table>
    </div>
  </div>
</div>


<!-- Modal For Adding and Updating data  -->
<div class="modal fade" id="stock_data_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #006666">
        <h3 class="modal-title" id="ModalLabel" style="color: white">Re-add Product Quantity</h3>
        <div style="float:right;">

        </div>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="background: #f2ffe6">

              <div class="x_content" style="background: #f2ffe6">
                <br />
                <!-- Form starts From here  -->
                <form id="form_stock_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">


                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product ID </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="products_id_no_stock" name="products_id_no_stock" class="form-control col-md-7 col-xs-12" readonly="" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product Name </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="products_name_stock" name="products_name_stock" class="form-control col-md-7 col-xs-12" readonly="" >
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Available Quantity
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" id="available_quantity" name="available_quantity"  class="form-control col-md-7 col-xs-12" readonly="">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">New Quantity<span class="required" style="color: red">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" step="1"  required=""id="new_quantity" name="new_quantity"  class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Total Quantity
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" id="total_quantity" name="total_quantity"  class="form-control col-md-7 col-xs-12" readonly="">
                    </div>
                  </div>

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="reset" class="btn btn-primary" >Reset</button>
                      <button type="submit" class="btn btn-success" id="submit_button_stock">Save New Quantity</button>
                    </div>
                  </div>



                </form>
              </div>
            </div>
          </div>
        </div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> <!-- End of modal for  Adding and Updating data-->


<!-- Modal For Adding and Updating data  -->
<div class="modal fade" id="add_update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #006666">
        <h3 class="modal-title" id="ModalLabel" style="color: white"></h3>
        <div style="float:right;">

        </div>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="background: #f2ffe6">

              <div class="x_content" style="background: #f2ffe6">
                <br />
                <!-- Form starts From here  -->
                <form id="form_edit_data" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">


                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Company <span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" required="" id="company" name="company" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Products Name<span class="required" style="color: red">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text"  required=""id="products_name" name="products_name"  class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Category  <span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" required="" id="category" name="category" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Weight <span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" required="" id="weight" name="weight" class="form-control col-md-7 col-xs-12" required="">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Color <span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" required="" id="color" name="color" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Company Pirce </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" step="0.01"  id="company_price" name="company_price" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Dealer Price <span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" min="0" step="0.01" required="" id="dealer_price" name="dealer_price" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Marketing Sell Price<span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="number" min="0" step="0.01" required="" id="marketing_sell_price" name="marketing_sell_price" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">MRP Price<span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="number" min="0" step="0.01" required="" id="mrp_price" name="mrp_price" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group" id="quantity_div">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Quantity<span class="required" style="color: red">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="number" min="0" step="1" required="" id="quantity" name="quantity" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Promo Offer </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="text" id="promo_offer" name="promo_offer" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Offer Start Date </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="offer_start_date" name="offer_start_date" class="date-picker form-control col-md-7 col-xs-12 datepicker"   readonly=""  >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Offer End Date </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="offer_end_date" name="offer_end_date" class="date-picker form-control col-md-7 col-xs-12 "   readonly=""  >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" id="photo_label">Product Photo </label>
                    <div id="photo_div" class="col-md-6 col-sm-6 col-xs-12">
                      <input type="file" id="product_photo" name="product_photo" onchange="readURL(this)" class="form-control col-md-7 col-xs-12 ">
                    </div>
                    <img id="output_image"  src="#" alt="">

                  </div>


                  <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="text" id="description" name="description" class="form-control col-md-7 col-xs-12" >
                    </div>
                  </div>


                  <div style="display: none;">
                    <input type="number" id="edit_id" name="edit_id">
                  </div>

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="reset" class="btn btn-primary" >Reset</button>
                      <button type="submit" class="btn btn-success" id="submit_button"></button>
                    </div>
                  </div>


                </form>
              </div>
            </div>
          </div>
        </div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> <!-- End of modal for  Adding and Updating data-->







<!-- Modal For Showing data  -->
<div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " style="width: 700px" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header" style="background: #006666" align="center">
        <h3 class="modal-title" id="ModalLabel" style="color: white">Product Information In Detail</h3>

      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="">

              <div class="x_content" style="">
                <br />

                <div style="margin : 20px; color:black" id="info_table" class="col-md-12 text-dark">
                  <div class="col-md-6">

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Company Name : </h5></div>
                      <div class="col-md-6"><h5 id="company_name_show"></h5></div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Product ID Number : </h5></div>
                      <div class="col-md-6"><h5 id="products_id_no_show"></h5></div>
                    </div>
                    <hr>


                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Products Name : </h5></div>
                      <div class="col-md-6"><h5 id="products_name_show"></h5></div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Category : </h5></div>
                      <div class="col-md-6"><h5 id="category_show"></h5></div>
                    </div>
                    <hr>

                    
                     <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Description : </h5></div>
                      <div class="col-md-6"><h5 id="description_show"> </h5></div>
                    </div>
                    <hr>



                  </div> <!-- end of first row --->

                  <!-- Start of second row --->
                  <div class="col-md-6">


                  
                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Company Price : </h5></div>
                      <div class="col-md-6"><h5 id="company_price_show"> </h5></div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>MRP Price : </h5></div>
                      <div class="col-md-6"><h5 id="mrp_price_show"> </h5></div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Pack Size : </h5></div>
                      <div class="col-md-6"><h5 id="pack_size_show"> </h5></div>
                    </div>
                    <hr>

                    <!-- <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Total Buy Item (QTY) : </h5></div>
                      <div class="col-md-6"><h5 id="total_buy_item"> </h5></div>
                    </div>
                    <hr> -->



                  <!--   <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Total Sell (QTY) : </h5></div>
                      <div class="col-md-6"><h5 id="total_sold_item"> </h5></div>
                    </div>
                    <hr> -->

                    <!-- <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Return From Market (QTY) : </h5></div>
                      <div class="col-md-6"><h5 id="return_from_market"> </h5></div>
                    </div>
                    <hr> -->

                  <!--   <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Return To Company (QTY) : </h5></div>
                      <div class="col-md-6"><h5 id="return_to_company"> </h5></div>
                    </div>
                    <hr>

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>In Stock (QTY): </h5></div>
                      <div class="col-md-6"><h5 id="in_stock"> </h5></div>
                    </div>
                    <hr> -->

                    <div class="row" style="margin-top:10px">
                      <div class="col-md-6"><h5>Product Photo : </h5></div>
                      <div class="col-md-6"><h5 id="product_photo_show"> </h5></div>
                    </div>
                    <hr>

                   



                  </div>
                  <!-- end of second row --->

                </div>   <!-- End of info table  -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> <!-- End of modal for  Showing data-->

<!-- /page content -->

</div>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){
  
  var company_name = $("#company_name").val();

  if (company_name != "") {
  $("#company_name_hidden").val(company_name);
  company_name = company_name.toUpperCase()
  $("#show_company_name").html(" Of Company : "+ company_name);
  get_data_table();
}



$(document).on('change','#company_name',function(){
  var company_name = $(this).val();
  $("#company_name_hidden").val(company_name);
  company_name = company_name.toUpperCase()
  $("#show_company_name").html(" Of Company : "+ company_name);
  get_data_table();
});

// showing product information
$(document).on('click','.view_details',function(){
  var products_id_no_view = $(this).attr("id");

  $.ajax({
    url:"ajax_companywise_prosuct_list.php",
    data:{products_id_no_view:products_id_no_view},
    type:"post",
    dataType:"json",
    success:function(data){
      $("#company_name_show").html(data.products_info.company);
          $("#products_id_no_show").html(data.products_info.products_id_no);
          $("#products_name_show").html(data.products_info.products_name);
          $("#category_show").html(data.products_info.category);
          $("#weight_show").html(data.products_info.weight);
          $("#color_show").html(data.products_info.color);
          $("#company_price_show").html(data.products_info.company_price+' ৳');
          $("#dealer_price_show").html(data.products_info.dealer_price);
          $("#mrp_price_show").html(data.products_info.mrp_price+' ৳');
          $("#pack_size_show").html(data.products_info.pack_size+` 's`);
          $("#marketing_sell_price_show").html(data.products_info.marketing_sell_price);
          $("#quantity_show").html(data.products_info.quantity);
          $("#barcode_show").html('<img src="https://barcode.tec-it.com/barcode.ashx?data='+data.products_info.products_id_no+'" alt="Photo Not Available" width="110px" >');
          $("#promo_offer_show").html(data.products_info.promo_offer);
          $("#offer_start_date_show").html(data.products_info.offer_start_date);
          $("#offer_end_date_show").html(data.products_info.offer_end_date);
          $("#product_photo_show").html('<img src="'+data.products_info.product_photo+'" alt="Photo Not Available" width="110px" >');
          $("#description_show").html(data.products_info.description);
          $("#total_buy_item").html(data.buy);
          $("#total_sold_item").html(data.sell);
          $("#return_from_market").html(data.return_from_market);
          $("#return_to_company").html(data.return_to_company);
          $("#in_stock").html(data.in_stock);


    }
  });
});

    $(document).on('click','.edit_data',function(){

      $("#ModalLabel").html("Update Product Information.");
      $("#submit_button").html("Update");
      var serial_no_edit = $(this).attr("id");

      $.ajax({
        url:"ajax_add_product.php",
        data:{serial_no_edit:serial_no_edit},
        type:"POST",
        dataType:'json',
        success:function(data){
          $("#company").val(data.company);
          $("#products_name").val(data.products_name);
          $("#category").val(data.category);
          $("#weight").val(data.weight);
          $("#color").val(data.color);
          $("#company_price").val(data.company_price);
          $("#dealer_price").val(data.dealer_price);
          $("#marketing_sell_price").val(data.marketing_sell_price);
          $("#mrp_price").val(data.mrp_price);
          $("#quantity").val(data.quantity);
          $("#promo_offer").val(data.promo_offer);
          $("#offer_start_date").val(data.offer_start_date);
          $("#offer_end_date").val(data.offer_end_date);
          $("#edit_id").val(data.serial_no);

          $("#photo_div").removeClass();
          $("#photo_div").addClass("col-md-4 col-sm-4 col-xs-8");
          $("#photo_div").css("margin-top","50px");
          $("#photo_label").css("margin-top","50px");

          $("#output_image").show();
          $('#output_image')
          .attr('src', data.product_photo)
          .width(128)
          .height(120);

          $("#quantity_div").hide();
          $("#quantity_div").val("");
          

        }
      });

    });

    $(document).on('click','#add_data',function(){
      $("#ModalLabel").html("Add Product Information.");
      $("#submit_button").html("Save");

      $("#company").val("");
      $("#products_name").val("");
      $("#category").val("");
      $("#weight").val("");
      $("#color").val("");
      $("#company_price").val("");
      $("#dealer_price").val("");
      $("#marketing_sell_price").val("");
      $("#marketing_sell_price").val("");
      $("#mrp_price").val("");
      $("#quantity").val("");
      $("#promo_offer").val("");
      $("#offer_start_date").val("");
      $("#offer_end_date").val("");
      $("#product_photo").val("");
      $("#edit_id").val("");

      $("#photo_div").removeClass();
      $("#photo_div").addClass("col-md-6 col-sm-6 col-xs-12");
      $("#output_image").hide();
      $("#photo_div").css("margin-top","0px");
      $("#photo_label").css("margin-top","0px");
      $("#quantity_div").show();


      

    });

      // now we are going to update and insert data 
      $(document).on('submit','#form_edit_data',function(e){
        e.preventDefault();
        var formData = new FormData($("#form_edit_data")[0]);
        formData.append('submit','submit');

        $.ajax({
          url:'ajax_add_product.php',
          data:formData,
          type:'POST',
          dataType:'json',
          cache: false,
          processData: false,
          contentType: false,
          success:function(data){
            swal({
              title: data.type,
              text: data.message,
              icon: data.type,
              button: "Done",
            });
            if (data.type == 'success') {
              $("#add_update_modal").modal("hide");
              get_data_table();
            }
          }
        });
    }); // end of insert and update 



      // this time we are adding new stock 
      $(document).on('submit','#form_stock_data',function(event){
        event.preventDefault();
        var formDataStock = new FormData($("#form_stock_data")[0]);
        formDataStock.append('submit_stock','submit_stock');

        $.ajax({
          url:'ajax_add_product.php',
          data:formDataStock,
          type:'POST',
          dataType:'json',
          cache: false,
          processData: false,
          contentType: false,
          success:function(data){
            swal({
              title: data.type,
              text: data.message,
              icon: data.type,
              button: "Done",
            });
            if (data.type == 'success') {
              $("#new_quantity").val("");
              $("#stock_data_modal").modal("hide");
              get_data_table();
            }
          }
        });
      });

    //delete data by id 
    $(document).on('click','.delete_data',function(){
      var serial_no_delete = $(this).attr("id");
      swal({
        title: "Are you sure to delete?",
        text: "Once deleted, all related information will be lost!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

          $.ajax({
            url:"ajax_add_product.php",
            data:{serial_no_delete:serial_no_delete},
            type:"POST",
            dataType:'json',
            success:function(data){
              swal({
                title: data.type,
                text: data.message,
                icon: data.type,
                button: "Done",
              });
              get_data_table();
            }
          });

        } 
      });

  }); // end of delete 

    //getting and setting data for adding stock.
    $(document).on('click','.stock_data',function(){
      var get_products_id_no_stock = $(this).attr("id");
      $.ajax({
        url:"ajax_add_product.php",
        data:{get_products_id_no_stock:get_products_id_no_stock},
        type:"post",
        dataType:"json",
        success:function(data){
          $("#products_id_no_stock").val(data.products_id_no);
          $("#products_name_stock").val(data.products_name);
          $("#available_quantity").val(data.quantity);
          $("#total_quantity").val(data.quantity);
        }
      });
    });

  // calculating total number of avaulable product after adding new stock
  $(document).on('keyup blur','#new_quantity',function(){
    var new_quantity = $(this).val();
    var available_quantity = $("#available_quantity").val();
    if (isNaN(new_quantity) || new_quantity == "") {
      new_quantity = 0;
    }
    var total_quantity = parseInt(available_quantity) + parseInt(new_quantity);
    $("#total_quantity").val(total_quantity);  
  });

  }); // end of document ready function 

// the following function is defined for showing data into the table
function get_data_table(){
  var sohag_company = $("#company_name_hidden").val();
  // console.log(sohag_company);
  $.ajax({
    url:"ajax_companywise_prosuct_list.php",
    data:{'sohag_company':sohag_company},
    type:"POST",
    dataType:"text",
    success:function(data_tbl){
      sohag.destroy();
      $("#data_table_body").html(data_tbl);
      init_DataTables();

    }
  });
}
// the following function is for image preview
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#photo_div").removeClass();
      $("#photo_div").addClass("col-md-4 col-sm-4 col-xs-8");
      $("#photo_div").css("margin-top","50px");
      $("#photo_label").css("margin-top","50px");
      $('#output_image')
      .show()
      .attr('src', e.target.result)
      .width(128)
      .height(120);

    };

    reader.readAsDataURL(input.files[0]);
  }
}

</script>

</body>
</html>