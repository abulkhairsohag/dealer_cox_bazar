<?php 
include_once("class/Database.php");
$dbOb = new Database();
error_reporting(0);
if (isset($_GET['serial_no'])) {
   $serial_no = $_GET['serial_no'];
}
if ($serial_no) {
    $query_order_details = "SELECT * FROM order_delivery WHERE serial_no = '$serial_no'";
    $result_order_details = $dbOb->select($query_order_details)->fetch_assoc();
// Summery information 
    $order_no =  $result_order_details['order_no'];
    $query = "SELECT * FROM order_summery_shop_info WHERE order_no = '$order_no' ";
    $summery_id = $dbOb->find($query)['summery_id'];

    $payable_amt = $result_order_details['payable_amt'];
    $employee_id = $result_order_details['order_employee_id'];
// order information
    $query = "SELECT * FROM order_delivery_expense WHERE delivery_tbl_serial_no = '$serial_no'";
    $result = $dbOb->select($query);

// Company information
    $query_company = "SELECT * FROM profile ";
    $result_company = $dbOb->select($query_company)->fetch_assoc();
// Employee information
    $query_employee = "SELECT * FROM employee_main_info WHERE id_no = '$employee_id'";
    $result_employee = $dbOb->select($query_employee);
    if($result_employee){
        $result_employee= $result_employee->fetch_assoc();
    }

}else{ ?>
    <script>
        window.location.href = "order_list.php";
    </script>
<?php } ?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Glowing Pharma</title>
    <style>
        body {
            background-image: url();
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .table-one {
            border: solid 1px;
            padding: 10px 0px 10px 20px;
        }



        .legend-pharma {
            /* background-color: dodgerblue; */
            font-size: 36px;
            padding: 10px;
            color: #000;
        }



        .btn {
            border: solid 1px;
            height: 40px;
            width: 120px;
            border-radius: 40px;
            background-image: linear-gradient( 109.6deg,  rgba(61,121,176,1) 11.3%, rgba(35,66,164,1) 91.1% );
            font-size: 22px;
            padding-top: 2px;
            font-weight: bold;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #3e3e3e;
        }

        .table-bordered {
            border: 1px solid #3e3e3e;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #3e3e3e;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #3e3e3e;
        }

        .table-bordered {
            border: 2px solid #3e3e3e;
            border-bottom: solid 1px white;
            border-left: solid 1px white;

        }

        .table-bordered td,
        .table-bordered th {
            border: 1px dotted #3e3e3e;
            border-bottom: 2px solid #000;

        }



        .table-bordered td,
        .table-bordered th {
            border-right: 2px solid #3e3e3e;

        }

        tbody th,td{
            padding: 0px !important;
            
        }

        tbody th{
            font-weight: 500;
            padding-left: 6px !important;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #3e3e3e;
            border-left: solid 2px;
        }

        .table-bordered td, .table-bordered th {
            border-right: 2px solid #3e3e3e;
            border-left: solid 2px;
        }

        td {
            color: #000 !important;
        }

        .table{
            color: #000;
        }

        .bottom-table tbody td{
            text-align: center;
        }

        .border-left {
            border-left: solid 2px #3e3e3e !important;
        }

        @media print{
            .white-border{
                border: 1px solid white;
            }


            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #3e3e3e;
            }

            .table-bordered {
                border: 1px solid #3e3e3e;
            }

            .table-bordered td,
            .table-bordered th {
                border: 1px solid #3e3e3e;
            }

            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #3e3e3e;
            }

            .table-bordered {
                border: 2px solid #3e3e3e;

            }

            .table-bordered td,
            .table-bordered th {
                border: 1px dotted #3e3e3e;
                border-bottom: 2px solid #000;

            }



            .table-bordered td,
            .table-bordered th {
                border-right: 2px solid #3e3e3e;

            }

            tbody th,td{
                padding: 0px !important;

            }

            tbody th{
                font-weight: 500;
                padding-left: 6px !important;
            }

            @media print{
               .table tbody tr th.blank{
                border-width: 0px !important;
                border-style: solid !important;
                border-color: white !important;
                font-size: 22px !important;
                background-color: red;
                padding:0px;
                -webkit-print-color-adjust:exact ;
            }
            .table-bordered {
                border: 2px solid #3e3e3e;
                border-bottom: solid 0px white;
                border-left: solid 0px white;

            }
            .print_none{
                display: none;
            }

            td{

                font-size: 18px;
            }
        }



    </style>
</head>

<body >
    <div id="print_table">
        <section>
            <div class="container-fulid mx-4">
                <div class="row">
                    <div class="col-md-3 pt-4" style="font-size:20px;">Head office :</span><br><span><?php echo ucwords($result_company['address']); ?></span></div>
                    <div class="col-md-6 pt-3">
                        <div class="text-center">
                            <span class="legend-pharma text-uppercase display-1 font-weight-bold" style="border-radius: 7%"><?php echo $result_company['organization_name']; ?></span>
                            <br>
                            <p class="pt-1 h5 mb-4"> An Ideal Marketing Company</p>
                            <p class="border border-dark py-2 px-4 d-inline h4 font-weight-bold" style="border-radius:30px">  INVOICE </p>
                        </div>
                    </div>
                    <div class="col-md-3 pt-4 text-right">
                        <p class="font-weight-bold"><?php echo date("d/m/Y") ?> <br><?php
                        date_default_timezone_set("Asia/Dhaka");
                        echo date("h:i:s A");
                        ?></p>
                    </div>
                </div>
                <hr>
            </section>
            <section class="mt-5">
                <div class="container-fulid">
                    <div class="table-one">
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-sm table-borderless">
                                    <thead></thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Cust ID</th>
                                            <td>: <?php echo $result_order_details['cust_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Shop</th>
                                            <td>: <?php echo $result_order_details['shop_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Name</th>
                                            <td>: <?php echo $result_order_details['customer_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address</th>
                                            <td>: <?php echo $result_order_details['address']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Phone</th>
                                            <td>: <?php echo $result_order_details['mobile_no']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-sm table-borderless">
                                    <thead></thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Area Name</th>
                                            <td>: <?php echo $result_order_details['area']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Employee ID</th>
                                            <td>: <?php echo $result_employee['id_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Name</th>
                                            <td>: <?php echo $result_employee['name']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Contact No</th>
                                            <td>: <?php echo $result_employee['mobile_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Summery No</th>
                                            <td>: <?php echo $summery_id?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-sm table-borderless">
                                    <thead></thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Category</th>
                                            <td>: General</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Invoice No</th>
                                            <td>: <?php echo $result_order_details['order_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Order Date</th>
                                            <td>: <?php echo $result_order_details['order_date']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Delivery Date</th>
                                            <td>: <?php echo $result_order_details['delivery_date']; ?></td>
                                        </tr>
                                        <tr>
                                            <?php 
                                            if (isset($_GET['aksohagsoftwareengineer'])) {
                                                ?>
                                                <th scope="row">Reprint Date</th>
                                                <td>: <?php echo date('d-m-Y')?></td>
                                                <?php
                                            }
                                            ?>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="mt-5 bottom-table">
                <div class="container-fulid ">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Pack Size</th>
                                <th scope="col">Unit TP</th>
                                <th scope="col">Unit VAT</th>
                                <th scope="col">TP + VAT</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Total TP</th>
                                <th scope="col">Total VAT</th>
                                <th scope="col">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($result) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <th scope="row"><?php echo ucwords($row['products_name']); ?></th>
                                        <td><?php echo round($row['pack_size'], 2); ?>`s</td>
                                        <td><?php echo round($row['unit_tp'], 2); ?></td>
                                        <td><?php echo round($row['unit_vat'], 2); ?></td>
                                        <td><?php echo round($row['tp_plus_vat'], 2); ?></td>
                                        <td><?php echo round($row['quantity'], 2); ?></td>
                                        <td><?php echo round($row['total_tp'], 2); ?></td>
                                        <td><?php echo round($row['total_vat'], 2); ?></td>
                                        <td><?php echo round($row['total_price'],2); ?></td>
                                    </tr>
                                <?php  }
                            }
                            ?>
                            <tr>
                                <th class="dd white-border blank" scope="row" colspan="6"  >  </th>

                                <td class="border-left"><?php echo round($result_order_details['net_total_tp'], 2); ?></td>
                                <td><?php echo round($result_order_details['net_total_vat'], 2); ?></td>
                                <td><?php echo round($result_order_details['net_total'], 2); ?></td>
                            </tr>
                            <tr>
                                <th class="white-border blank" scope="row" colspan="6" >  Note : </th>
                                <td colspan="2">Discount On Tp : <?php echo $result_order_details['discount_on_tp'] ?>%</td>
                                <td>-<?php echo $result_order_details['discount_amount'] ?></td>
                            </tr>
                            <tr>
                                <th scope="row" class="blank" colspan="6"  ></th>
                                <td colspan="2">Payable Amt : </td>
                                <td><?php echo round($result_order_details['payable_without_extra_discount'],2) ?></td>
                            </tr>
                            <tr>
                                <th scope="row" class="blank" colspan="6"  ></th>
                                <td colspan="2">Extra Discount : <?php echo $result_order_details['extra_discount'] ?>%</td>
                                <td>-<?php 
                                $amt = $result_order_details['payable_without_extra_discount']*$result_order_details['extra_discount']/100; 
                                echo round($amt,2); ?></td>
                            </tr>

                            <tr>
                                <?php 
                                function convertNumberToWord($num = false)
                                {
                                    $num = str_replace(array(',', ' '), '' , trim($num));
                                    if(! $num) {
                                        return false;
                                    }
                                    $num = (int) $num;
                                    $words = array();
                                    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
                                        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
                                    );
                                    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
                                    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
                                        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
                                        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
                                    );
                                    $num_length = strlen($num);
                                    $levels = (int) (($num_length + 2) / 3);
                                    $max_length = $levels * 3;
                                    $num = substr('00' . $num, -$max_length);
                                    $num_levels = str_split($num, 3);
                                    for ($i = 0; $i < count($num_levels); $i++) {
                                        $levels--;
                                        $hundreds = (int) ($num_levels[$i] / 100);
                                        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
                                        $tens = (int) ($num_levels[$i] % 100);
                                        $singles = '';
                                        if ( $tens < 20 ) {
                                            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
                                        } else {
                                            $tens = (int)($tens / 10);
                                            $tens = ' ' . $list2[$tens] . ' ';
                                            $singles = (int) ($num_levels[$i] % 10);
                                            $singles = ' ' . $list1[$singles] . ' ';
                                        }
                                        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}

?>
<th class="white-border blank" scope="row" colspan="6" class="border-none text-uppercase"  >IN WORD: <?php echo strtoupper(convertNumberToWord($payable_amt)).' TAKA ONLY'; ?>   </th>
<td colspan="2"><b>Net Payable Amount</b></td>
<td><b><?php echo $payable_amt; ?></b></td>
</tr>

</tbody>
</table>
</div>
</section>

<div class="container mt-5 ">
    <div class="row">
        <div class="col-md-8 mx-auto">

            <?php 
            $query = "SELECT * FROM `invoice_setting`";
            $get_invoice = $dbOb->select($query);
            if ($get_invoice) {
                $show_due = $get_invoice->fetch_assoc()['show_dues'];
                
                if ($show_due == 1) {


                    $customer_id = $result_order_details['cust_id'];
                    $query = "SELECT * FROM `order_delivery` WHERE cust_id = '$customer_id' AND due > 0";
                    $get_dues = $dbOb->select($query);

                    ?>

                    <?php 

                    if ($get_dues) {
                        ?>

                        <p class="font-weight-bold " style="font-size: 20px"> Total Dues (With Previous) </p>
                        <table class="table table-bordered">
                            <thead>
                                <tr align="center">
                                    <th scope="col">Order No</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Due Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_dues = 0 ;
                                while ($dues = $get_dues->fetch_assoc()) {
                                    ?>
                                    <tr align="center">
                                        <td ><?php echo $dues['order_no'] ?></td>
                                        <td><?php echo $dues['delivery_date'] ?></td>
                                        <td><?php echo $dues['due'] ?></td>
                                    </tr>

                                    <?php
                                    $total_dues += $dues['due'] ;
                                }
                                ?>

                                <tr >
                                    <td align="right" colspan="2" class="pr-4">Total Due</td>
                                    <td align="center"><?php echo $total_dues; ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <?php 
                    }

                }
            }

            ?>
        </div>
    </div>

</div>
<section class="" style="margin-top: 170px">
    <div class="container-fulid">
        <div class="text-center">
            <div class="row">
                <div class="col-md-2">
                    <div class="border-top">
                        <p class="font-weight-bold font-italic"> Prepared By </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border-top">
                        <p class="font-weight-bold font-italic"> Authorized by <br> Date.............</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border-top">
                        <p class="font-weight-bold font-italic">Delivered by <br>Delivery Assistant</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border-top">
                        <p class="font-weight-bold font-italic">Collected by</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border-top">
                        <p class="font-weight-bold font-italic">Customer's Signature</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <hr>
    <div class="container-fulid ">
        <p>Warranty <span>: We do hereby give the warranty that product sold under this invoice don't contravene to any provisions of section 18 of the drugs act. 1940</span></p>
        <p>Note <span>: Received the goods in full and good condition</span></p>
    </div>
</div>
<div class="text-center mb-3 print_none">

    <a class=" text-light btn-success btn print_none" onclick="printContent('print_table')"><i class="icon-printer"></i> Print</span> </a>
</div>
<script type="text/javascript">

    function printContent(el){
      var a = document.body.innerHTML;
      var b = document.getElementById(el).innerHTML;
      document.body.innerHTML = b;
      window.print();
      document.body.innerHTML = a;
      
      return window.location.reload(true);

  }

</script>
</section><!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php 

if (Session::get("update_message")) {
  ?>
  <script>
    swal({
      title: "<?php echo(Session::get("update_type")); ?>",
      text: "<?php echo(Session::get("update_message")); ?>",
      icon: "<?php echo(Session::get("update_type")); ?>",
      buttons: "Done",

  })
</script>

<?php
Session::set("update_message",Null);
Session::set("update_type",Null);
}
?>
</body></html>
