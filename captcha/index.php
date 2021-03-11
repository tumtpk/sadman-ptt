<?php
session_start();
//$_SESSION = array();

include("simple-php-captcha.php");


?>


<pre>

</pre>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

<form action="" method="post" name="form1" id="form1" >
  <table width="400" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
    <?php if(isset($msg)){?>
    <tr>
      <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
    </tr>
    <?php } ?>
    <tr>
      <td align="right" valign="top"> Validation code:</td>
      <td>
        <!-- <img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br> -->
        <div id="here">

            <?php
            //print_r($_SESSION['captcha']);
            $_SESSION['captcha'] = simple_php_captcha();
            //echo  $_SESSION['captcha']['code'];
            ?>

        <?php
        echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';?>
        
        <label for='message'>Enter the code above here :</label>
        <br>

        <input type="text" name="codeCaptcha" value="<?php echo $_SESSION['captcha']['code'];?>">

        </div>
        <input id="captcha_code" name="captcha_code" type="text" >
        <br>
        Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.

<style>
    .capt{
    background-color:grey;
    width: 300px;
    height:100px;
    
}

#mainCaptcha{
    position: relative;
    left : 60px;
    top: 5px;
    
}

#refresh{
    position:relative;
    left:230px;
    width:30px;
    height:30px;
    bottom:45px;
    background-image: url(rpt.jpg);
}

#txtInput, #Button1{
    position: relative;
    left:40px;
    bottom: 40px;
}
</style>

<script>
   function Captcha(){
     var alpha = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
        'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', 
            '0','1','2','3','4','5','6','7','8','9');
     var i;
     for (i=0;i<6;i++){
         var a = alpha[Math.floor(Math.random() * alpha.length)];
         var b = alpha[Math.floor(Math.random() * alpha.length)];
         var c = alpha[Math.floor(Math.random() * alpha.length)];
         var d = alpha[Math.floor(Math.random() * alpha.length)];
         var e = alpha[Math.floor(Math.random() * alpha.length)];
         var f = alpha[Math.floor(Math.random() * alpha.length)];
         var g = alpha[Math.floor(Math.random() * alpha.length)];
                      }
         var code = a + ' ' + b + ' ' + ' ' + c + ' ' + d + ' ' + e + ' '+ f + ' ' + g;
         document.getElementById("mainCaptcha").innerHTML = code
         document.getElementById("mainCaptcha").value = code
       }
function ValidCaptcha(){
     var string1 = removeSpaces(document.getElementById('mainCaptcha').value);
     var string2 =         removeSpaces(document.getElementById('txtInput').value);
     if (string1 == string2){
            return true;
     }else{        
          return false;
          }
}
function removeSpaces(string){
     return string.split(' ').join('');
}
</script>
 <h2 type="text" id="mainCaptcha"></h2>
   <p><input type="button" id="refresh" onclick="Captcha();"/></p>            <input type="text" id="txtInput"/>    
   <input id="Button1" type="button" value="Check" onclick="alert(ValidCaptcha());"/>
   </div>
    </td>
    </tr>
    <tr>
      <td> </td>
      <td><input name="Submit" type="submit" onclick="return validate();" value="Submit" class="button1"></td>
    </tr>
  </table>
</form>

<?php 

if(isset($_POST) & !empty($_POST)){
    if($_POST['captcha_code'] == $_POST['codeCaptcha']){
        echo "correct captcha";
    }else{
        echo "Invalid captcha";
    }
}

?>


<script type='text/javascript'>
    function refreshCaptcha(){
        // $( "#here" ).load(window.location.href + " #here" );
        //var img = document.images['captchaimg'];
        //img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
        $("#here").load(" #here > *");
    }
</script>