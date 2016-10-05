<?php
?>
<html>
<head>
<title>Pay</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<body>
<form name="SendOrder" method="post" action="https://testpay.kkb.kz/jsp/process/logon.jsp">
   <input type="hidden" name="Signed_Order_B64" value="<?php echo $content;?>">
   E-mail: <input type="text" name="email" size=50 maxlength=50  value="test@test.kz">
   <p>
   <input type="hidden" name="Language" value="eng"> <!-- язык формы оплаты rus/eng -->
   <input type="hidden" name="BackLink" value="http://abusport.loc/payment">
   <input type="hidden" name="PostLink" value="http://abusport.loc/postlink">
   Со счетом согласен (-а)<br>
   <input type="submit" name="GotoPay"  value="Да, перейти к оплате" >&nbsp;
</form>
</body>
</html>
