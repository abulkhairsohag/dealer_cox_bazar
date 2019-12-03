<?php 
ini_set('display_errors', 'on');
ini_set('error_reporting', 'E_ALL');

include_once("class/Session.php");
Session::init();
Session::checkSession();
error_reporting(1);
include_once ('helper/helper.php');
?>

<?php 

include_once('class/Database.php');
$dbOb = new Database();

if (isset($_POST['serial_no'])) {
	$serial_no = $_POST['serial_no'] ;
         
    $company_profile = '';
    $query = "SELECT * FROM profile";
    $get_profile = $dbOb->select($query);
    if ($get_profile) {
        $company_profile = $get_profile->fetch_assoc();
    }


    $receipt_info = '';
    $query = "SELECT * FROM money_receipt_main_tbl WHERE serial_no = '$serial_no'";
    $get_receipt = $dbOb->select($query);
    if ($get_receipt) {
        $receipt_info = $get_receipt->fetch_assoc();

        if ($receipt_info['from_date'] == $receipt_info['to_date']) {
            $show_date = 'Date :'.$receipt_info['from_date'] ;
        }else{
            $show_date = 'Date : '.$receipt_info['from_date'].' <span class="badge bg-red"> TO </span> '.$receipt_info['to_date'];
        }
        $table = ' <div  id="print_table" style="color:black">
        <span class="text-center">
            <h3><b>'.strtoupper($company_profile['organization_name']).'</b></h3>
            <h5>'.$company_profile['address'].', '.$company_profile['mobile_no'].'</h5>
            <h5>'.$show_date.'</h5>
            </span>
                <table class="table table-responsive">
                    <tbody>
                        <tr>
                            <td>
                                <h5 style="margin:0px ; margin-top: -8px;"><b>Receipt No : <span>'.$receipt_info['receipt_no'].'</span></b> </h5>
                                <h5 style="margin:0px ; margin-top: -8px;">Employee ID: <span>'.$receipt_info['employee_id'].'</span></h5>
                                <h5 style="margin:0px ; margin-top: -8px;">Name:<span> '.$receipt_info['employee_name'].'</span></h5>
                            </td>
                            <td class="text-center">
                                <h4 style="margin:0px ; margin-top: 5px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"><b>MONEY RECEIPT</b></h4>
                            </td>
                            <td class="text-right">
                                <h5 style="margin:0px ; margin-top: -8px;">Printing Date : <span></span>'.$receipt_info['printing_date'].'</span></h5>
                                <h5 style="margin:0px ; margin-top: -8px;">Time : <span></span>'.$receipt_info['printing_time'].'</span></h5>
                                <h5 style="margin:0px ; margin-top: -8px;">Reprint Date: <span></span>'.date('d F, Y').'</span></h5>  
                                <h5 style="margin:0px ; margin-top: -8px;"> Time: <span></span>'.date('h:i:s A').'</span></h5>
                            </td>
                        </tr>
                    
                    </tbody>
                </table>
            <!--     
            <hr> -->
            <table class="table table-bordered table-responsive">
                <thead style="background:#4CAF50; color:white" >
                    <tr>
                        <th>Sl No</th>
                        <th>Order No</th>
                        <th>Order Date</th>
                        <th>Shop Name</th>
                        <th>Area</th>
                        <th>Payment Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>'; 

        
        $query = "SELECT * FROM money_receipt_info_tbl WHERE receipt_tbl_serial_no = '$serial_no'";
        $get_details = $dbOb->select($query);
        if ($get_details) {
            while ($row = $get_details->fetch_assoc()) {
                $i++;
                      $table .= ' <tr>
                                <td>'.$i.'</td>
                                <td>'.$row['order_no'].'</td>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['shop_name'].'</td>
                                <td>'.$row['area'].'</td>
                                <td>'.$row['payment_date'].'</td>
                                <td>'.$row['payment_amt'].'</td>
                            </tr>';
            }
        }
        if ($i>0) {
            $table .= '<tr>
            <td colspan="6" class="text-right">Total Amount</td>
            <td>'.$receipt_info['total_amount'].'</td>
        </tr>';
        }else{
            $table .= '<tr style="color:red" class="text-center">
                         <td colspan="7" class="text-center">No Payment Found</td>
                      </tr>';
        }
    
        $table .= '</tbody>
                </table>';
    
        $print_table = 'print_table';
    
        $table .='<div class="container-fulid"> 
                        <div class="row">
                            <div class="col-md-12">';
        if ($i>0) {
            # code...
    $table .='<h5>IN WORD: '.$receipt_info['in_word'].' (TAKA ONLY).</h5>';
        }
        $table .='</div>
                            <br>
                            
                        </div>
                        <table class="table table-responsive text-center" style="margin-top:100px">
                                <tbody>
                                    <tr>
                                        <td>
                                        <b> MPO/SR </b>
                                        </td>
                                        <td>
                                        <b> Accounts</b>
                                        </td>
                                    
                                    </tr>
                            
                                </tbody>
                            </table>
                        
                    </div>
                    </div>
                    <br>
                    <br>
                    <div class="mt-3 text-center" >
                    
    
                    <a class="text-light btn-success btn" onclick="printContent(\''.$print_table.'\')" name="print" id="print_receipt">Print</a>
                    
                    </div>
                    ';
                    echo json_encode($table);
                    exit();

    } // end of main info query execution

    


     


}



 ?>