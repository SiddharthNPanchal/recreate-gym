
<!--<h1>Forgot Password</h1>-->
	   <head>
      <title>Forgot Password</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>

   <body bgcolor = "#FFFFFF">
   
	
      <div align = "center">
         <div style = "width:400px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Forgot Password</b></div>
				
            <div style = "margin:30px">
	<form action="forgotpass4.php" method="post">
		
	
			
					
					
			
		
			<table>
			<tr>
			<td><label>Email</label></td><td><input type="text" name="email" required</td></tr>
			<tr>
			<td><label>Secrity Question</label></td>
			<td><select name=security_que>
			<option value="what1">what is your favourite color</option>
			<option value="what2">what is your favourite car</option>
			<option value="what3">what is your favourite country</option>
			</select>
			</td>
			</tr>
			<tr>
			<td><label>Answer</label></td><td><input type="text" name="ans" required></td></tr>
			<tr><td colspan="2" align="center"><input type="submit"  value="submit "name="submit" ><td></td>
			</table>
			
	</form>
	</div>
	</div>
	</div>
