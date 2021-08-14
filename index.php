<?php
   error_reporting(1);
   // set API Access Key
   $access_key = '37691171ebe05af6adf38fa0f80acc8c';


   $country_key='fb63481b56a919a5f35eb6590113a7eb';
   
   // set phone number
   $phone_number = $_POST['mobileno'];
   
   $countrycode=$_POST["countrycode"];

   //for getting country
   
     // Initialize CURL:
   
   $ch = curl_init('http://apilayer.net/api/countries?access_key='.$country_key); 
   
   
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   
   // Store the data:
   $json = curl_exec($ch);
   curl_close($ch);
   
   // Decode JSON response:
   $validationCountryResult = json_decode($json, true);
   
  
   if ($_POST['mobileno'] !="") {
   
     $number=$countrycode.$phone_number;

   // Initialize CURL:
   
   $chs = curl_init('http://apilayer.net/api/validate?access_key='.$access_key.'&number='.$number.''); 
   
   
   curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
   
   // Store the data:
   $jsons = curl_exec($chs);
   curl_close($chs);
   
   // Decode JSON response:
   $validationNumResult = json_decode($jsons, true);
   
  
   // Access and use your preferred validation result objects
   $validationNumResult['valid'];
   $validationNumResult['country_code'];
   $validationNumResult['carrier'];

   if ($validationNumResult['error']['info'] !="") {
                

               $KeyExist=$validationNumResult['error']['info'] ;


   } else if ($validationNumResult['valid']==false) {
           
           $valid="no";
   }
   
   }
   
   
    ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Mobile Number Validation</title>
      <link href="style.css" rel="stylesheet">
   </head>
   <body>
      <h2>Mobile Number Validation</h2>
      <p class="text"><?php echo $KeyExist;?></p>
      <div class="cont">
         <div class="form">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
               <div class="mt-5">
                   <label>Country </label>
                  <select class="user" required="" name="countrycode">
                     <option value="">Selcet Country</option>
                     <?php foreach ($validationCountryResult as $key => $value) { ?>
                     <option value="<?php echo $value['dialling_code'] ?>" ><?php echo $value['country_name'] ?> </option>
                     <?php }  ?>
                  </select>
                  <label>Mobile No</label>
                  <input type="text" 
                     class="user"
                     placeholder="Mobile No" name="mobileno" required=""  />
                  <?php if ($valid=="no") {?>
                  <span class="error">Please Enter Valid Number</span>
                  <?php } ?>
                  <button  class="login" type="submit'">Validate</button>
                  <?php if($validationNumResult['location'] !=""){ ?>
                  <p class="success">Location: &nbsp;<?php echo $validationNumResult['location']; ?></p>
                  </h4>
                  <?php  } ?>
                  <?php if($validationNumResult['carrier'] !=""){ ?>
                  <p class="success">Carrier &nbsp;&nbsp;: &nbsp;<?php echo $validationNumResult['carrier']; ?></span></p>
                  <?php  } ?>
               </div>
            </form>
         </div>
      </div>
   </body>
</html>
