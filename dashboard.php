<?php

session_start();
error_reporting(0);

include 'db.php';
include_once 'dbconfig.php';
$con = GetConn();
if(!isset($con))
{
    die("Database Not Found");
}

   /* $sc=  mysqli_query($con, "select p_tdate from t_purtrans where p_id='PRD0001'");
    $date = date_create($sc);
    echo date_format($date, "d/M/Y");*/
    $date = date("d-M-Y");
    $phid=$_REQUEST["phid"];
    $pname=$_REQUEST["pname"];
    $pdesc=$_REQUEST["pdesc"];
    $pprice=$_REQUEST["pprice"];
    $pbrand=$_REQUEST["pbrand"];
    $pquan=$_REQUEST["pquan"];
    $pemail=$_REQUEST["pemail"];
    $totcst=$pprice * $pquan;

    $phid1=$_REQUEST["phid1"];
    $pname1=$_REQUEST["pname1"];
    $pdesc1=$_REQUEST["pdesc1"];
    $pprice1=$_REQUEST["pprice1"];
    $pbrand1=$_REQUEST["pbrand1"];
    $pquan1=$_REQUEST["pquan1"];
    $pemail1=$_REQUEST["pemail1"];
    $totcst1=$pprice1 * $pquan1;

    
    $mnthsel=$_REQUEST["mnthsel"];
    
    $q=mysqli_query($con,"select c_name from t_category where c_id='".$pname."'");
    $n=  mysqli_fetch_assoc($q);
    $cname= $n['c_name'];
    
    $q1=mysqli_query($con,"select b_name from t_brand where b_id='".$pbrand."'");
    $n1=  mysqli_fetch_assoc($q1);
    $bname= $n1['b_name'];
        
    $q2=mysqli_query($con,"select m_name from t_model where m_id='".$pdesc."'");
    $n2=  mysqli_fetch_assoc($q2);
    $mname= $n2['m_name'];
    
    if(isset($_REQUEST["product-submit"]))
    {

    if($phid == "")
    $phid = PrdctCode();
   
    $sqlcr = "insert into t_product(p_id,p_name,p_desc,p_brand,p_cost,p_quantity,tot_cost) values (";
    $sqlcr.= "'" . $phid . "',";
    $sqlcr.= "'" . $cname . "',";
    $sqlcr.= "'" . $mname . "',";
    $sqlcr.= "'" . $bname . "',";
    $sqlcr.= "'" . $pprice . "',";
    $sqlcr.= "'" . $pquan . "',";
    $sqlcr.= "'" . $totcst . "')";
    
    $sqlcr1 = "insert into t_purtrans(p_id,s_email,p_tdate) values (";
    $sqlcr1.= "'" . $phid . "',";
    $sqlcr1.= "'" . $pemail . "',";
    $sqlcr1.= "'" . $date . "')";
    
    mysqli_query($con,$sqlcr );
   mysqli_query($con,$sqlcr1 );
   
    echo '<script>alert("Product added successfully.")</script>';
    
   }
    
   if(isset($_REQUEST["product-submit1"]))
    {
    
    $chkquan = mysqli_query($con,"select p_quantity from t_product where p_name='$pname1' and p_brand='$pbrand1' and p_desc='$pdesc1'");
    $chkq=  mysqli_fetch_assoc($chkquan);
    $quan= $chkq['p_quantity'];
    
    if($pquan1 <= $quan )
    {
        
    if($phid1 == "")
    $phid1 = PrdctSCode();
    
    $quanup = "update t_product SET p_quantity=p_quantity-$pquan1 where p_name='$pname1' and p_brand='$pbrand1' and p_desc='$pdesc1'";
    
    $sqlcr = "INSERT INTO `t_soldprd`(`p_sid`, `p_sname`, `p_sdesc`, `p_sbrand`, `p_scost`, `p_squantity`, `p_stot_cost`) VALUES (";
    $sqlcr.= "'" . $phid1 . "',";
    $sqlcr.= "'" . $pname1 . "',";
    $sqlcr.= "'" . $pdesc1 . "',";
    $sqlcr.= "'" . $pbrand1 . "',";
    $sqlcr.= "'" . $pprice1 . "',";
    $sqlcr.= "'" . $pquan1 . "',";
    $sqlcr.= "'" . $totcst1 . "')";
    
    $sqlcr1 = "insert into t_saletrans(p_sid,d_email,s_tdate) values (";
    $sqlcr1.= "'" . $phid1 . "',";
    $sqlcr1.= "'" . $pemail1 . "',";
    //$sqlcr1.= "'mona@gmail.com',";
    $sqlcr1.= "'" . $date . "')";
    
    mysqli_query($con,$quanup);
    mysqli_query($con,$sqlcr);
    mysqli_query($con,$sqlcr1);
    //echo $sqlcr;
    //echo $sqlcr1;
    echo '<script>alert("Sales detail added successfully.")</script>';
    }
    
    else
    {
        echo '<script>alert("Shortage of quantity.")</script>';
    }
    
   }
    
    $shid=$_REQUEST["shid"];
    $scom=$_REQUEST["scom"];
    $sph=$_REQUEST["sph"];
    $sph1=$_REQUEST["sph1"];
    $snm=$_REQUEST["snm"];
    $seml=$_REQUEST["seml"];
    
    if(isset($_REQUEST["newsup-submit"]))
    {

    if($shid == "")
    $shid = SupCode();
   
    $sqlcr = "insert into t_supplier(`s_id`, `s_name`, `s_pswd`, `s_email`, `s_comp`, `s_phno`,`s_phno1`, `s_regdate`) values (";
    $sqlcr.= "'" . $shid . "',";
    $sqlcr.= "'" . $snm . "',";
    $sqlcr.= "'123',";
    $sqlcr.= "'" . $seml . "',";
    $sqlcr.= "'" . $scom . "',";
    $sqlcr.= "'" . $sph . "',";
    $sqlcr.= "'" . $sph1 . "',";
    $sqlcr.= "'" . $date . "')";
    
    mysqli_query($con,$sqlcr);
    
    echo '<script>alert("Supplier details added")</script>';
    }
    
     
    $dhid=$_REQUEST["dhid"];
    $dcom=$_REQUEST["dcom"];
    $dph=$_REQUEST["dph"];
    $dph1=$_REQUEST["dph1"];
    $dnm=$_REQUEST["dnm"];
    $deml=$_REQUEST["deml"];
    
    if(isset($_REQUEST["newdea-submit"]))
    {

    if($dhid == "")
    $dhid = DeaCode();
   
    $sqlcr = "insert into t_dealer(`d_id`, `d_name`, `d_pswd`, `d_email`, `d_comp`, `d_phno`, `d_phno1`,`d_regdate`) values (";
    $sqlcr.= "'" . $dhid . "',";
    $sqlcr.= "'" . $dnm . "',";
    $sqlcr.= "'123',";
    $sqlcr.= "'" . $deml . "',";
    $sqlcr.= "'" . $dcom . "',";
    $sqlcr.= "'" . $dph . "',";
    $sqlcr.= "'" . $dph1 . "',";
    $sqlcr.= "'" . $date . "')";
    
    mysqli_query($con,$sqlcr);
    
    echo '<script>alert("Dealer details added")</script>';
    }
    
    
    /* if(isset($_REQUEST['pdel']))
    {
        for($i=0;$i<count($_REQUEST['checkbox']);$i++)
        {
            $del_id=$_REQUEST['checkbox'][$i];
            mysqli_query($con,"DELETE FROM t_purtrans WHERE p_id='$del_id'");
            mysqli_query($con,"DELETE FROM t_product WHERE p_id='$del_id'");
    
        }
    }  */
    
    if(isset($_REQUEST['pdel']))
    {
        $sqldel  = "CREATE TRIGGER trgbdel BEFORE DELETE ON t_product  FOR EACH ROW";
        $sqldel .= "INSERT INTO log_prd_delete(`p_id`, `p_name`, `p_desc`, `p_brand`, `p_cost`, `p_quantity`, `tot_cost`, `audit_action`, `audit_trans`) values (";
        $sqldel .= "OLD.p_id,OLD.p_name,OLD.p_desc,OLD.p_brand,OLD.p_cost,OLD.p_quantity,OLD.tot_cost,'Product details deleted',SYSDATE())";
        for($i=0;$i<count($_REQUEST['checkbox']);$i++)
        {
            $del_id=$_REQUEST['checkbox'][$i];
            mysqli_query($con,"DELETE FROM t_purtrans WHERE p_id='$del_id'");
            mysqli_query($con,"DELETE FROM t_product WHERE p_id='$del_id'");
            mysqli_query($con,$sqldel);
            
        }
    }
  
//change password

    $adold = $_REQUEST["adoldpas"];
$adnew  = $_REQUEST["adnewpas"];
$adcon = $_REQUEST["adconnpas"];
    
if(isset($_REQUEST["adpassub"]))
{
    
    $getad = mysqli_query($con,"select * from t_user where a_email='".$_SESSION['ad']."' and a_pswd='". $adold."'");
    
    if($adnew==$adcon)  
    {
      if(mysqli_num_rows($getad)>0)
      {
         mysqli_query($con,"update t_user set a_pswd='".$adnew."' where a_email ='".$_SESSION['ad']."'");

          echo "<script> alert('Password has been changed successfully');</script>";
      }

    else
       {
          echo "<script> alert('Old password is incorrect. Please try again.');</script>";
       }
    }

   else
   {
      echo "<script> alert('New password and confirm password should match. Please try again');</script>";
   }
}

//change password over
  
    
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Admin's Dashboard</title>
        
        <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="bootstrap/bootstrap-theme.min.css">
        <script src="bootstrap/jquery.min.js"></script>
        <script src="bootstrap/bootstrap.min.js"></script>
        
        <link rel="stylesheet" href="css/div.css">
        <link rel="stylesheet" href="css/dashboard.css">
        
        <!-- Dropdown brand, model -->

        <script type="text/javascript" src="jquery-1.4.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$(".pname").change(function()
	{
		var id=$(this).val();
		var dataString = 'id='+ id;
	
		$.ajax
		({
			type: "POST",
			url: "get_brand.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".pbrand").html(html);
			} 
		});
	});
	
	
	$(".pbrand").change(function()
	{
		var id=$(this).val();
		var dataString = 'id='+ id;
	
		$.ajax
		({
			type: "POST",
			url: "get_model.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".pdesc").html(html);
			} 
		});
	});
	
});


$(document).ready(function()
{
	$(".pname1").change(function()
	{
		var id=$(this).val();
		var dataString = 'id='+ id;
	
		$.ajax
		({
			type: "POST",
			url: "get_brand_1.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".pbrand1").html(html);
			} 
		});
	});
	
	
	$(".pbrand1").change(function()
	{
		var id=$(this).val();
		var dataString = 'id='+ id;
	
		$.ajax
		({
			type: "POST",
			url: "get_model_1.php",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$(".pdesc1").html(html);
			} 
		});
	});
	
});
</script>
        <style>
            
            form
            {
                margin-left:3%;
            }
            
            input[type="search"]
            {
                width: 90%;
            }
            input[type="text"]:focus,input[type="search"]:focus,input[type="search"]:focus,select:focus,input[type="email"]:focus,input[type="password"]:focus
            
            {
                border: #000;
                box-shadow: 0 0 10px  #000;
                
            }   
            
            input[type="text"],input[type="search"],input[type="search"],select,input[type="email"],input[type="password"]
            {
                width:60%;
            }
            input[type="submit"]
            {
                width:20%;
                background-color:#000;
                border:#000;
                color:#fff;
            }
            
            input[type="submit"]:hover
            {
                width:20%;
                background-color:  #b0acac;
                border:#000;
                color:#000;
            }
            
            
            hr
            {
                height:7px;
                border:0;
                box-shadow: 0 10px 10px -10px #cccccc inset;
            }
            
        </style>
        
        <script>
          $(document).ready(function(){
              $("#orderby").click(function(){
                  $("#cat").show();
                  $("#brn").hide();
                  $("#cst").hide();
                  $("#qun").hide();
                  $("#tcst").hide();
              });
              $("#orderby1").click(function(){
                  $("#brn").show();
                  $("#cat").hide();
                  $("#cst").hide();
                  $("#qun").hide();
                  $("#tcst").hide();
             }); 
             $("#orderby2").click(function(){
                 $("#cst").show();
                 $("#brn").hide();
                  $("#cat").hide();
                  $("#qun").hide();
                  $("#tcst").hide();
             }); 
             $("#orderby3").click(function(){
                 $("#qun").show();
                 $("#brn").hide();
                  $("#cat").hide();
                  $("#cst").hide();
                  $("#tcst").hide();
             }); 
             $("#orderby4").click(function(){
                 $("#tcst").show();
                 $("#brn").hide();
                  $("#cat").hide();
                  $("#qun").hide();
                  $("#cst").hide();
             }); 
          });
         </script>
        
    </head>
    <body>
        
        <center>
        <div class="container">
            <a href='logout.php'>
                             LOGOUT
                            </a>
          <img src="images/catergory-banner-electronics.png">
        </div>
       </center> <br>
        
        <div class="container">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a data-toggle="tab" href="#npe">Home</a></li>
                <li><a data-toggle="tab" href="#sup">Suppliers</a></li>
                <li><a data-toggle="tab" href="#dea"> Dealers</a></li>
                <li><a data-toggle="tab" href="#tran">Transaction</a></li>
                <li><a data-toggle="tab" href="#chpas">Change Password</a></li>
            </ul>
        
            <div class="tab-content" style="margin-top: 30px;">
                <div class="tab-pane fade in active" id="npe">
                    <div class="container">
                              <div class="panel-group">
                                 <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#coo1"><center>NEW PURCHASE DETAIL</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="coo1" class="panel-collapse collapse">
                                          <div class="panel-body">Enter the details of the purchased product</div>
                                            <div class="panel-footer">
                                                <form class='form-horizontal'  id="productentry" method="post" action="">
                                                    <div class='form-group'>
                                                         <div class='col-sm-5'>
                                                             <label class='control-label' for='pname' > Product's Category :</label>  
                                                         </div>
                                                         <div class='col-sm-7'>

                                                               <select id='pname' name="pname" class="pname">
                                                                 <option selected="selected">--Select Category--</option>
                                                                 <?php
                                                                         $stmt = $DB_con->prepare("SELECT * FROM t_category");
                                                                         $stmt->execute();
                                                                         while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                                                                         {
                                                                                 ?>
                                                                         <option value="<?php echo $row['c_id']; ?>"><?php echo $row['c_name']; ?></option>
                                                                         <?php
                                                                         } 
                                                                 ?>
                                                                 </select>

                                                         </div>
                                                     </div>

                                                     <div class='form-group'>
                                                          <div class='col-sm-5'>
                                                             <label class='control-label ' for='pbrand'> Product's Brand :</label>  
                                                          </div>
                                                         <div class='col-sm-7'>

                                                                <select class="pbrand" id='pbrand' name='pbrand'>
                                                                 <option selected="selected">--Select Brand--</option>
                                                                 </select>

                                                         </div>
                                                     </div>

                                                      <div class='form-group'>
                                                          <div class='col-sm-5'>
                                                             <label class='control-label ' for='pdesc'> Product's Model No. :</label>  
                                                         </div>
                                                         <div class='col-sm-7'>
                                                              <select  class="pdesc" id='pdesc' name='pdesc'>
                                                                 <option selected="selected">--Select Model No.--</option>
                                                              </select>
                                                         </div>
                                                     </div>


                                                     <div class='form-group'>
                                                         <div class='col-sm-5'>
                                                             <label class='control-label ' for='pprice'> Product's Cost:</label>  
                                                         </div>
                                                         <div class='col-sm-7'>
                                                              <input type='text' class="form-control" id='pprice' name='pprice'>
                                                         </div>
                                                     </div>

                                                     <div class='form-group'>
                                                         <div class='col-sm-5'>
                                                             <label class='control-label ' for='pquan'> Product's Quantity :</label>  
                                                         </div>
                                                         <div class='col-sm-7'>
                                                              <input type='text' class="form-control" id='pquan' name='pquan'>
                                                         </div>
                                                     </div>

                                                     <div class='form-group'>
                                                         <div class='col-sm-5'>
                                                             <label class='control-label ' for='pemail' > Supplier's Email :</label>  
                                                         </div>
                                                         <div class='col-sm-7'>

                                                             <input type='text' class="form-control" id='pemail' name='pemail' >
                                                             <input type='hidden' class="form-control" id='phid' name='phid' >
                                                         </div>
                                                     </div>

                                                     <div class='form-group'>
                                                         <div class='col-sm-10'>
                                                             <center><input type="submit" name="product-submit" id="product-submit" 
                                                                     class="form-control btn btn-login" value="Submit"></center>
                                                         </div>
                                                     </div>
                                                  </form>
                                            </div>
                                      </div>
                                  </div>
                              </div>
                    </div>
                      
                    
                    <div class="container">
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#coo2"><center>NEW SALES DETAIL</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="coo2" class="panel-collapse collapse">
                                          <div class="panel-body">Enter the details of the sold product</div>
                                            <div class="panel-footer">
                                                <form class='form-horizontal'  id="productsold" method="post" action="dashboard.php">
                                                    <div class='form-group'>
                                                         <div class='col-sm-5'>
                                                             <label class='control-label' for='pname1' > Product's Category :</label>  
                                                         </div>
                                                         <div class='col-sm-7'>

                                                               <select  id='pname' name="pname1" class="pname1">
                                                                 <option selected="selected">--Select Category--</option>
                                                                 <?php
                                                                         $stmt1 = $DB_con->prepare("SELECT DISTINCT(p_name) FROM t_product");
                                                                         $stmt1->execute();
                                                                         while($row=$stmt1->fetch(PDO::FETCH_ASSOC))
                                                                         {
                                                                                 ?>
                                                                         <option value="<?php echo $row['p_name']; ?>"><?php echo $row['p_name']; ?></option>
                                                                         <?php
                                                                         } 
                                                                 ?>
                                                                 </select>

                                                         </div>
                                                     </div>

                                                     <div class='form-group'>
                                                          <div class='col-sm-5'>
                                                             <label class='control-label ' for='pbrand1'> Product's Brand :</label>  
                                                          </div>
                                                         <div class='col-sm-7'>

                                                                <select class="pbrand1" id='pbrand1' name='pbrand1'>
                                                                 <option selected="selected">--Select Brand--</option>
                                                                 </select>

                                                         </div>
                                                     </div>

                                                      <div class='form-group'>
                                                          <div class='col-sm-5'>
                                                             <label class='control-label ' for='pdesc1'> Product's Model No. :</label>  
                                                         </div>
                                                         <div class='col-sm-7'>
                                                              <select  class="pdesc1" id='pdesc1' name='pdesc1'>
                                                                 <option selected="selected">--Select Model No.--</option>
                                                              </select>
                                                         </div>
                                                     </div>


                                                     <div class='form-group'>
                                                         <div class='col-sm-5'>
                                                             <label class='control-label ' for='pprice1'> Product's Cost:</label>  
                                                         </div>
                                                         <div class='col-sm-7'>
                                                              <input type='text' class="form-control" id='pprice1' name='pprice1'>
                                                         </div>
                                                     </div>

                                                     <div class='form-group'>
                                                         <div class='col-sm-5'>
                                                             <label class='control-label ' for='pquan1'> Product's Quantity :</label>  
                                                         </div>
                                                         <div class='col-sm-7'>
                                                              <input type='text' class="form-control" id='pquan1' name='pquan1'>
                                                         </div>
                                                     </div>

                                                     <div class='form-group'>
                                                         <div class='col-sm-5'>
                                                             <label class='control-label ' for='pemail1' > Dealer's Email :</label>  
                                                         </div>
                                                         <div class='col-sm-7'>

                                                             <input type='text' class="form-control" id='pemail1' name='pemail1' >
                                                             <input type='hidden' class="form-control" id='phid1' name='phid1' >
                                                         </div>
                                                     </div>

                                                     <div class='form-group'>
                                                         <div class='col-sm-10'>
                                                             <center><input type="submit" name="product-submit1" id="product-submit1" 
                                                                     class="form-control btn btn-login" value="Submit"></center>
                                                         </div>
                                                     </div>
                                                  </form>
                                            </div>
                                      </div>
                                  </div>
                              </div>
                        
                        
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#coo8"><center>PRODUCTS SHORT OF QUANTITY</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="coo8" class="panel-collapse collapse">
                                          <div class="panel-body">These products are falling short of quantity</div>
                                            <div class="panel-footer">
                                                <table class="table table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Category</th>
                                                            <th>Brand</th>
                                                            <th>Model Details</th>
                                                            <th>Cost per Item</th>
                                                            <th>Quantity</th>
                                                            <th>Total Cost</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                       <?php

                                                                $shrtpr= mysqli_query($con, "SELECT * FROM `t_product` WHERE p_quantity<=5");
                                                                while($shrtp = mysqli_fetch_array($shrtpr))              
                                                                {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $shrtp[1] ?></td>
                                                            <td><?php echo $shrtp[3] ?></td>
                                                            <td><?php echo $shrtp[2] ?></td>
                                                            <td><?php echo $shrtp[4] ?></td>
                                                            <td><?php echo $shrtp[5] ?></td>
                                                            <td><?php echo $shrtp[6] ?></td>
                                                         </tr>

                                                       <?php
                                                                }
                                                        ?>
                                                        <tr>
                                                            <td colspan="7">
                                                                 <center><a href="shrtquandnld.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>  
                                                            </td> 
                                                        </tr>
                                                    </tbody>
                                                </table> 
                                            </div>
                                      </div>
                                  </div>
                              </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading"> 
                                <h5 class="panel-title">
                                    <center>MONTHLY PURCHASES</center>
                                </h5>
                            </div>
                            <form action="dashboard.php" method="post">
                            <div class="panel-body">
                                
                                    <div class="row">
                                        <div class="col-sm-6">
                                            Select a particular month : 
                                            <select  name="mnthsel" id="mnthsel" style="width:30%">
                                                <option>----MONTH----</option>
                                                <option>Jan</option>
                                                <option>Feb</option>
                                                <option>Mar</option>
                                                <option>Apr</option>
                                                <option>May</option>
                                                <option>Jun</option>
                                                <option>Jul</option>
                                                <option>Aug</option>
                                                <option>Sep</option>
                                                <option>Oct</option>
                                                <option>Nov</option>
                                                <option>Dec</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="submit"  name="showmprd" id="showmprd" value="Show">
                                        </div>
                                    </div>
                                    <hr>
                                   <!-- <div class="row">
                                        <div class="col-sm-6">
                                            From : <input type="date" name="dfprd">
                                            To : <input type="date" name="dtprd">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="submit"  name="dateprd" id="dateprd" value="Show">
                                        </div>
                                  </div>-->
                            </div>
                            <div class="panel-footer">
                                
                                <?php
                                    $mthch= mysqli_query($con, "SELECT t_product.p_name,t_product.p_desc,t_product.p_brand, t_product.p_cost,t_product.p_quantity FROM
                                    t_purtrans INNER JOIN t_product ON t_purtrans.p_id=t_product.p_id WHERE p_tdate LIKE '%$mnthsel%'");
                                    
                                    echo "<hr>" ;
                                           
                                    if(isset($_REQUEST["showmprd"]))
                                    {
                                          echo "<table class='table table-bordered'>";
                                          echo "<th>Category</th>";
                                           echo "<th>Brand</th>";
                                           echo "<th>Model Details</th>";
                                           echo "<th>Cost per Item</th>";
                                           echo "<th>Quantity</th>";
                                           while($mthc = mysqli_fetch_array($mthch))              
                                           {
                                              echo "<tr>";
                                              echo "<td>". $mthc[0]."</td>";
                                              echo "<td>". $mthc[1]."</td>";
                                              echo "<td>". $mthc[2]."</td>";
                                              echo "<td>". $mthc[3]."</td>";
                                              echo "<td>". $mthc[4]."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              //echo '<center><a href="mnthlyrcd.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                        }
                                  
                                ?>
                               </div>
                             </form>    
                        </div>
                      
                            
                        
                        
                        <div class="panel panel-default">
                            <div class="panel-heading"> 
                                <center><h4>STOCKS AVAILABLE</h4></center>
                            </div>
                            <div class="panel-body">
                        Arrange according to :
                        <input type="button" name="orderby" id="orderby" value="Category" class="btn btn-link">
                        <input type="button" name="orderby1" id="orderby1" value="Brand" class="btn btn-link">
                        <input type="button" name="orderby2" id="orderby2" value="Cost per Item" class="btn btn-link">
                        <input type="button" name="orderby3" id="orderby3" value="Quantity" class="btn btn-link">
                        <input type="button" name="orderby4" id="orderby4" value="Total Cost" class="btn btn-link">
                     </div>
                    <form class='form-horizontal' id="stockav" method="post"> 
                    <span>
                                <?php
                                     $av= mysqli_query($con, "select COUNT(*) AS rows from t_product");
                                     $res=  mysqli_fetch_assoc($av);
                                     $row=$res['rows'];
                                     echo "<center>Total No. of rows fetched <b>: $row</b></center>";
                                 ?>
                            </span>
                        
                           <div class="panel-footer" id="cat">
                               
                              <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>

                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $avpr= mysqli_query($con, "select * from t_product ORDER BY `t_product`.`p_name` ASC");
                                             while($avprr = mysqli_fetch_array($avpr))              
                                             {
                                     ?>
                                     <tr>
                                         <td><?php echo $avprr[1] ?></td>
                                         <td><?php echo $avprr[3] ?></td>
                                         <td><?php echo $avprr[2] ?></td>
                                         <td><?php echo $avprr[4] ?></td>
                                         <td><?php echo $avprr[5] ?></td>
                                         <td><?php echo $avprr[6] ?></td>
                                         <td><input name="checkbox[]" type="checkbox" id="checkbox[]" 
                                             value="<?php echo  $avprr[0] ; ?>"></td>
                                     </tr>
                                     
                                     
                                    
                                    <?php
                                             }
                                     ?>
                                     <tr>
                                         <td colspan="7">
                                              <center><a href="stockscategory.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>  
                                         </td> 
                                     </tr>
                                 </tbody>
                             </table>     
                           </div>



                          <div class="panel-footer" id="brn" hidden>
                              <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>
                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $avpr1= mysqli_query($con, "select * from t_product ORDER BY `t_product`.`p_brand` ASC");
                                                             while($avprr1 = mysqli_fetch_array($avpr1))              
                                             {
                                     ?>

                                     <tr>                                             
                                         <td><?php echo $avprr1[1] ?></td>
                                         <td><?php echo $avprr1[3] ?></td>
                                         <td><?php echo $avprr1[2] ?></td>
                                         <td><?php echo $avprr1[4] ?></td>
                                         <td><?php echo $avprr1[5] ?></td>
                                         <td><?php echo $avprr1[6] ?></td>
                                         <td><input name="checkbox[]" type="checkbox" id="checkbox[]" 
                                          value="<?php echo  $avprr1[0] ; ?>"></td>
                                     </tr>
                                    <?php
                                             }
                                     ?>
                                     <tr>
                                         <td colspan="7">
                                              <center><a href="stocksbrand.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>  
                                         </td> 
                                     </tr>
                                 </tbody>
                             </table>     
                           </div> 


                           <div class="panel-footer" id="cst" hidden>
                              <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>

                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $avpr2= mysqli_query($con, "select * from t_product ORDER BY `t_product`.`p_cost` ASC");
                                             while($avprr2 = mysqli_fetch_array($avpr2))              
                                             {
                                     ?>
                                     <tr>
                                         <td><?php echo $avprr2[1] ?></td>
                                         <td><?php echo $avprr2[3] ?></td>
                                         <td><?php echo $avprr2[2] ?></td>
                                         <td><?php echo $avprr2[4] ?></td>
                                         <td><?php echo $avprr2[5] ?></td>
                                         <td><?php echo $avprr2[6] ?></td>
                                         <td><input name="checkbox[]" type="checkbox" id="checkbox[]" 
                                             value="<?php echo  $avprr2[0] ; ?>"></td>
                                     </tr>
                                    <?php
                                             }
                                     ?>
                                     <tr>
                                         <td colspan="7">
                                              <center><a href="stockscostpi.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>  
                                         </td> 
                                     </tr>
                                 </tbody>
                             </table>     
                           </div>



                           <div class="panel-footer" id="qun" hidden>
                              <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>

                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $avpr3= mysqli_query($con, "select * from t_product ORDER BY `t_product`.`p_quantity` ASC");
                                             while($avprr3 = mysqli_fetch_array($avpr3))              
                                             {
                                     ?>
                                     <tr>
                                         <td><?php echo $avprr3[1] ?></td>
                                         <td><?php echo $avprr3[3] ?></td>
                                         <td><?php echo $avprr3[2] ?></td>
                                         <td><?php echo $avprr3[4] ?></td>
                                         <td><?php echo $avprr3[5] ?></td>
                                         <td><?php echo $avprr3[6] ?></td>
                                         <td><input name="checkbox[]" type="checkbox" id="checkbox[]" 
                                             value="<?php echo  $avprr3[0] ; ?>"></td>
                                     </tr>
                                    <?php
                                             }
                                     ?>
                                     <tr>
                                         <td colspan="7">
                                              <center><a href="stocksquantity.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>  
                                         </td> 
                                     </tr>
                                 </tbody>
                             </table>     
                           </div>


                           <div class="panel-footer" id="tcst" hidden>
                              <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>

                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $avpr4= mysqli_query($con, "select * from t_product ORDER BY `t_product`.`tot_cost` ASC");
                                             while($avprr4 = mysqli_fetch_array($avpr4))              
                                             {
                                     ?>
                                     <tr>
                                         <td><?php echo $avprr4[1] ?></td>
                                         <td><?php echo $avprr4[3] ?></td>
                                         <td><?php echo $avprr4[2] ?></td>
                                         <td><?php echo $avprr4[4] ?></td>
                                         <td><?php echo $avprr4[5] ?></td>
                                         <td><?php echo $avprr4[6] ?></td>
                                         <td><input name="checkbox[]" type="checkbox" id="checkbox[]" 
                                             value="<?php echo  $avprr4[0] ; ?>"></td>
                                     </tr>
                                    <?php
                                             }
                                     ?>
                                     <tr>
                                         <td colspan="7">
                                              <center><a href="stockstotcost.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>  
                                         </td> 
                                     </tr>
                                 </tbody>
                             </table>     
                           </div>
                        
                        
                            
                       <center><input type="submit" name="pdel" value ="Remove" onclick="return validate();"></center>
                      </form>
                </div>
               
                        
                        <div class="panel panel-default">
                            <div class="panel-heading"> 
                                <center><h4>DELETED LOG</h4></center>
                            </div>
                            <div class="panel-body">
                                
                            </div>
                            <div class="panel-footer">
                                <table class="table table-striped" style="width:100%">
                                 <thead >
                                     <tr>
                                         <th>Category</th>
                                         <th>Brand</th>
                                         <th>Model Details</th>
                                         <th>Cost per Item</th>
                                         <th>Quantity</th>
                                         <th>Total Cost</th>
                                         <th>Audit Action</th>
                                         <th>Date</th>

                                     </tr>
                                 </thead>
                                 <tbody>

                                    <?php

                                             $lprdel= mysqli_query($con, "select * from log_prd_delete ORDER BY `log_prd_delete`.`audit_trans` ASC");
                                             while($lprde = mysqli_fetch_array($lprdel))              
                                             {
                                     ?>
                                     <tr>
                                         <td><?php echo $lprde[1] ?></td>
                                         <td><?php echo $lprde[2] ?></td>
                                         <td><?php echo $lprde[3] ?></td>
                                         <td><?php echo $lprde[4] ?></td>
                                         <td><?php echo $lprde[5] ?></td>
                                         <td><?php echo $lprde[6] ?></td>
                                         <td><?php echo $lprde[7] ?></td>
                                         <td><?php echo $lprde[8] ?></td>
                                        
                                     </tr>
                                    <?php
                                             }
                                     ?>
                                     
                                 </tbody>
                             </table>     
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            
        
                <div id="sup" class="tab-pane fade" >
                    <div class="container">
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#co1"><center>ADD A NEW SUPPLIER</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="co1" class="panel-collapse collapse">
                                          <div class="panel-body">Enter the details of the new supplier</div>
                                            <div class="panel-footer">
                                                <form id="addsup" class="form-horizontal"  action=""  method="post">
                        
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="snm">Name : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='snm' name='snm' placeholder="Enter Supplier's Name">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="seml">Email : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='email' class="form-control" id='seml' name='seml' placeholder="Enter Supplier's Email">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="sph">Contact : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='sph' name='sph'  placeholder="Enter Supplier's 1st Contact">
                                                            <br>    <input type='text' class="form-control" id='sph1' name='sph1' placeholder="Enter Supplier's 2nd Contact">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="scom">Company : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='scom' name='scom' placeholder="Enter Supplier's Company">
                                                            <input type='hidden' class="form-control" id='shid' name='shid' >
                                                        </div>
                                                    </div>

                                                    <div class='form-group'>
                                                        <div class='col-sm-10'>
                                                            <center><input type="submit" name="newsup-submit" id="newsup-submit" 
                                                                    class="form-control btn btn-login" value="Submit"></center>
                                                        </div>
                                                    </div>


                                                 </form>
                                            </div>
                                      </div>
                                  </div>
                              </div>
                    </div>
                    
                          <div class="container" >
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#col1"><center>LIST OF SUPPLIERS</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="col1" class="panel-collapse collapse">
                                          <div class="panel-body"></div>
                                          <div class="panel-footer">
                                             <table class="table table-striped" style="width:100%">
                                                <thead >
                                                    <tr>
                                                        <th>ID.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Contact</th>
                                                        <th>Company</th>
                                                       <!-- <th>Total Cost</th>-->
                                                        <th>Registered On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sup= mysqli_query($con, "select * from t_supplier ORDER BY `t_supplier`.`s_id` ASC");
                                                        while($supp = mysqli_fetch_array($sup))              
                                                        {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $supp[0] ?></td>
                                                        <td><?php echo $supp[1] ?></td>
                                                        <td><?php echo $supp[3] ?></td>
                                                        <td><?php echo $supp[4]; echo " , "; echo $supp[5] ?></td>
                                                        <td><?php echo $supp[6] ?></td>
                                                        <td><?php echo $supp[7] ?></td>
                                                        <!--<td>rs.getString("s_regdate")</td>-->
                                                    </tr>
                                                        <?php } ?>
                                                </tbody>
                                            </table> 
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>     
                      </div>
                            
                            
                            
                       
                     <div id="dea" class="tab-pane fade" >
                         <div class="container">
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#co2"><center>ADD A NEW DEALER</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="co2" class="panel-collapse collapse">
                                          <div class="panel-body">Enter the details of the new dealer</div>
                                          <div class="panel-footer">
                                              <form id="adddlr" class="form-horizontal" action="dashboard.php"  method="post">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="snm">Name : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='dnm' name='dnm' placeholder="Enter Dealer's Name">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="deml">Email : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='email' class="form-control" id='deml' name='deml' placeholder="Enter Dealer's Email">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="dph">Contact : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='dph' name='dph'  placeholder="Enter Dealer's 1st Contact">
                                                            <br>    <input type='text' class="form-control" id='dph1' name='dph1' placeholder="Enter Dealer's 2nd Contact">
                                                          </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="dcom">Company : </label> 
                                                        <div class="col-sm-10">
                                                            <input type='text' class="form-control" id='dcom' name='dcom' placeholder="Enter Dealer's Company">
                                                            <input type='hidden' class="form-control" id='dhid' name='dhid'>
                                                        </div>
                                                    </div>

                                                    <div class='form-group'>
                                                        <div class='col-sm-10'>
                                                            <center><input type="submit" name="newdea-submit" id="newdea-submit" 
                                                                    class="form-control btn btn-login" value="Submit"></center>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         
                        
                        <div class="container">
                              <div class="panel-group">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          <h5 class="panel-title">
                                              <a data-toggle="collapse" href="#col2"><center>LIST OF DEALERS</center></a>
                                          </h5>
                                      </div>
                                      
                                      <div id="col2" class="panel-collapse collapse">
                                          <div class="panel-body"></div>
                                          <div class="panel-footer">
                                             <table class="table table-striped" style="width:100%">
                                                <thead >
                                                    <tr>
                                                        <th>ID.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Company</th>
                                                        <th>Contact</th>
                                                        
                                                        <!--<th>Total Cost</th>-->
                                                        <th>Registered On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                   <?php
                                                        $dea= mysqli_query($con, "select * from t_dealer ORDER BY `t_dealer`.`d_id` ASC");
                                                        while($deal = mysqli_fetch_array($dea))              
                                                        {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $deal[0] ?></td>
                                                        <td><?php echo $deal[1] ?></td>
                                                        <td><?php echo $deal[3] ?></td>
                                                        <td><?php echo $deal[4];?></td>
                                                        <td><?php echo $deal[6];  echo " , "; echo $deal[5] ?></td>
                                                        <td><?php echo $deal[7] ?></td>
                                                        <!--<td>rs.getString("s_regdate")</td>-->
                                                    </tr>
                                                        <?php } ?>
                                                   
                                                </tbody>
                                            </table>     
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>      
                        </div>
            
                  <div id="tran" class="tab-pane fade" >
                    <form id="viewtran">
                        <div class="container">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                        <center><h4>TOTAL PURCHASE TRANSACTION</h4></center>
                                    </div>
                                    <div class="panel-body">
                                         <?php 
                                           $totpur = mysqli_query($con,"SELECT SUM(tot_cost) FROM `t_product`");
                                          
                                         
                                           while($purval=mysqli_fetch_array($totpur))
                                           {
                                           echo "<h4>Total purchase price till date :<b> Rs. ". $purval['SUM(tot_cost)']."</b></h4>";
                                           }
                                           echo '<br>';
                                           
                                           $namepur = mysqli_query($con,"SELECT Ucase(p_name), SUM(tot_cost),AVG(tot_cost),MAX(tot_cost),
                                               MIN(tot_cost) FROM `t_product` group by p_name");
                                           echo "<br><center>TOTAL PURCHASE TILL DATE (ACCORDING TO PRODUCT'S CATEGORY)</center>";
                                            ?>
                                           
                                           <?php       
                                           echo "<hr>" ;
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Product's Category </th>";
                                           echo "<th> Total Cost (Rs.)</th>";
                                           echo "<th> Average Cost (Rs.)</th>";
                                           echo "<th> Maximum Cost (Rs.)</th>";
                                           echo "<th> Minimum Cost (Rs.)</th>";
                                           while($nameval=mysqli_fetch_array($namepur))
                                           {
                                              echo "<tr>";
                                              echo "<td>". $nameval['Ucase(p_name)'] . "</td>";
                                              echo "<td>". $nameval['SUM(tot_cost)']."</td>";
                                              echo "<td>". $nameval['AVG(tot_cost)']."</td>";
                                              echo "<td>". $nameval['MAX(tot_cost)']."</td>";
                                              echo "<td>". $nameval['MIN(tot_cost)']."</td>";
                                              echo "</tr>";
                                              
                                           }
                                           
                                          
                                              echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="tpurtrans.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                              echo "</table>";
                                           
                                           $datepur = mysqli_query($con,"SELECT substring(p_tdate,4,3), SUM(tot_cost),AVG(tot_cost),
                                               MAX(tot_cost),MIN(tot_cost) FROM t_purtrans INNER JOIN t_product ON 
                                               t_purtrans.p_id=t_product.p_id group by substring(p_tdate,4,3)");
                                           echo "<br><hr><center>TOTAL PURCHASE TILL DATE(ACCORDING TO MONTHS)</center>" ;
                                                  
                                           echo "<hr>" ;
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Month </th>";
                                           echo "<th> Total Cost (Rs.)</th>";
                                           echo "<th> Average Cost (Rs.)</th>";
                                           echo "<th> Maximum Cost (Rs.)</th>";
                                           echo "<th> Minimum Cost (Rs.)</th>";
                                           while($dateval=mysqli_fetch_array($datepur))
                                           {
                                              echo "<tr>";
                                              echo "<td>". $dateval['substring(p_tdate,4,3)'] . "</td>";
                                              echo "<td>". $dateval['SUM(tot_cost)']."</td>";
                                              echo "<td>". $dateval['AVG(tot_cost)']."</td>";
                                              echo "<td>". $dateval['MAX(tot_cost)']."</td>";
                                              echo "<td>". $dateval['MIN(tot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="tpurtrm.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                          ?>
                                      </div>
                                </div><br>
                                <div class="panel panel-default">
                                    <div class="panel-heading"> <center><h4>TOTAL SALES TRANSACTION</h4></center></div>
                                    <div class="panel-body">
                                        <?php 
                                           $totsal = mysqli_query($con,"SELECT SUM(p_stot_cost) FROM `t_soldprd`");
                                           
                                           while($salval=mysqli_fetch_array($totsal))
                                           {
                                           echo "<h4>Total sales till date :<b> Rs. ". $salval['SUM(p_stot_cost)']."</b></h4>";
                                           }
                                           echo '<br>';
                                                                                  
                                           $namesal = mysqli_query($con,"SELECT Ucase(p_sname), SUM(p_stot_cost),AVG(p_stot_cost),MAX(p_stot_cost),MIN(p_stot_cost) FROM `t_soldprd` group by p_sname");
                                           echo "<br><center>TOTAL PURCHASE TILL DATE(ACCORDING TO PRODUCT'S CATEGORY)</center>" ;
                                            ?>
                                           
                                           <?php
                                           echo "<hr>" ;
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Product's Category </th>";
                                           echo "<th> Total Cost (Rs.)</th>";
                                           echo "<th> Average Cost (Rs.)</th>";
                                           echo "<th> Maximum Cost (Rs.)</th>";
                                           echo "<th> Minimum Cost (Rs.)</th>";
                                           while($nameva=mysqli_fetch_array($namesal))
                                           {
                                              echo "<tr>";
                                              echo "<td>". $nameva['Ucase(p_sname)'] . "</td>";
                                              echo "<td>". $nameva['SUM(p_stot_cost)']."</td>";
                                              echo "<td>". $nameva['AVG(p_stot_cost)']."</td>";
                                              echo "<td>". $nameva['MAX(p_stot_cost)']."</td>";
                                              echo "<td>". $nameva['MIN(p_stot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="tsaletrans.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                           
                                           $datesal = mysqli_query($con,"SELECT substring(s_tdate,4,3), SUM(p_stot_cost),AVG(p_stot_cost),MAX(p_stot_cost),MIN(p_stot_cost) FROM t_saletrans INNER JOIN t_soldprd ON t_saletrans.p_sid=t_soldprd.p_sid group by substring(s_tdate,4,3)");
                                           echo "<br><hr><center>TOTAL SALES TILL DATE (ACCORDING TO MONTHS)</center>" ;
                                           ?>
                                          
                                           <?php       
                                           echo "<hr>" ;
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Month </th>";
                                           echo "<th> Total Cost (Rs.)</th>";
                                           echo "<th> Average Cost (Rs.)</th>";
                                           echo "<th> Maximum Cost (Rs.)</th>";
                                           echo "<th> Minimum Cost (Rs.)</th>";
                                           while($datesa=mysqli_fetch_array($datesal))
                                           {
                                              echo "<tr>";
                                              echo "<td>". $datesa['substring(s_tdate,4,3)'] . "</td>";
                                              echo "<td>". $datesa['SUM(p_stot_cost)']."</td>";
                                              echo "<td>". $datesa['AVG(p_stot_cost)']."</td>";
                                              echo "<td>". $datesa['MAX(p_stot_cost)']."</td>";
                                              echo "<td>". $datesa['MIN(p_stot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center> <a href="tsalem.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                           
                                            ?>
                                    </div>
                                </div><br>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><center><h4> BEST SUPPLIER</h4></center>   </div>
                                    <div class="panel-body">
                                    <?php 
                                           $bestsp = mysqli_query($con,"SELECT s_email, SUM(tot_cost),MAX(tot_cost),MIN(tot_cost) FROM t_purtrans INNER JOIN t_product ON t_purtrans.p_id=t_product.p_id group by (s_email) order by sum(tot_cost) DESC");
                                           $trcount=0;                                           
                                           echo "<br><center>PURCHASES FROM THE SUPPLIERS</center>" ;
                                           ?>
                                           
                                           <?php       
                                           echo "<hr>";
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Rank </th>";
                                           echo "<th> Supplier's Name</th>";
                                           echo "<th> Total Purchase(Rs.)</th>";
                                           echo "<th> Maximum Purchase Price (Rs.)</th>";
                                           echo "<th> Minimum Purchase Price (Rs.)</th>";
                                          
                                           while($bests=mysqli_fetch_array($bestsp))
                                           {
                                               $s2=mysqli_query($con,"select s_name from t_supplier where s_email='".$bests['s_email']."'");
                                               $ss2=  mysqli_fetch_assoc($s2);
                                               $spname= $ss2['s_name'];
                                              echo "<tr>";
                                              echo "<td>". ++$trcount .".</td>";
                                              echo "<td>". $spname . "</td>";
                                              echo "<td>". $bests['SUM(tot_cost)']."</td>";
                                              echo "<td>". $bests['MAX(tot_cost)']."</td>";
                                              echo "<td>". $bests['MIN(tot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="tsupl.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                           
                                            ?>
                                    
                                    </div>
                                </div><br>
                                <div class="panel panel-default">
                                    <div class="panel-heading"> <center><h4>BEST DEALER </h4></center></div>
                                    <div class="panel-body">
                                        <?php 
                                           $bestdl = mysqli_query($con,"SELECT d_email, SUM(p_stot_cost),MAX(p_stot_cost),MIN(p_stot_cost) FROM t_saletrans INNER JOIN t_soldprd ON t_saletrans.p_sid=t_soldprd.p_sid group by (d_email) order by sum(p_stot_cost) DESC");
                                           $dlcount=0;                                           
                                           echo "<br><hr><center> SALES TO THE DEALERS</center>" ;
                                           ?>
                                           
                                           <?php       
                                           echo "<hr>";
                                           echo "<table class='table table-bordered'>";
                                           echo "<th> Rank </th>";
                                           echo "<th> Dealer's Name</th>";
                                           echo "<th> Total Sales(Rs.)</th>";
                                           echo "<th> Maximum Sales Price (Rs.)</th>";
                                           echo "<th> Minimum Sales Price (Rs.)</th>";
                                          
                                           while($bestd=mysqli_fetch_array($bestdl))
                                           {
                                               $d2=mysqli_query($con,"select d_name from t_dealer where d_email='".$bestd['d_email']."'");
                                               $dd2=  mysqli_fetch_assoc($d2);
                                               $dlname= $dd2['d_name'];
                                              echo "<tr>";
                                              echo "<td>". ++$dlcount .".</td>";
                                              echo "<td>". $dlname . "</td>";
                                              echo "<td>". $bestd['SUM(p_stot_cost)']."</td>";
                                              echo "<td>". $bestd['MAX(p_stot_cost)']."</td>";
                                              echo "<td>". $bestd['MIN(p_stot_cost)']."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="tdeal.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                           
                                            ?>
                                    
                                    </div>
                                </div><br>
                             </div>
                        </div>
                    </form>
                </div>            
                
                
                <div id="chpas" class="tab-pane fade" >
                    <div class="jumbotron">
                       <center>   
                            <div class="container-fluid">    
                                <div class="row">
                                   <div class="col-sm-12">
                                        <p style="color: #999999 ;font-family:Verdana; font-weight: bold;margin-top:2px; font-size: xx-large ">
                                           Get a new password !
                                       </p>
                                    </div> 
                                </div>    

                                   <div class="row">
                                        <div class="col-sm-12">
                                           <input type="password" class="form-control" name="adoldpas" placeholder="What's The Old Password ?">
                                        </div>
                                    </div><br>

                                    <div class="row">
                                        <div class="col-sm-12">
                                           <input type="password" class="form-control" name="adnewpas" placeholder="Enter your new password">
                                        </div>
                                    </div><br>


                                   <div class="row">
                                        <div class="col-sm-12">
                                           <input type="password" name="adconnpas" class="form-control" placeholder="Confirm New Password">
                                        </div>
                                    </div><br>

                                    <div class="row">
                                        <div class="col-sm-12">
                                       <input type="submit" name="adpassub" class="form-control" value="Change" > 
                                        </div>
                                    </div>
                                 </div>
                           </center>
                    </div>
                </div>
            
            </div>                     
        </div>
    </body>
</html>
