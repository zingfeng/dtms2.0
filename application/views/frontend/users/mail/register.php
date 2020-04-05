<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Register Successfully</title>
	<style type="text/css" media="screen">
		body{
			background-color: #dfdfdf;
		}
	</style>
</head>
<body>
    <table style="width:100%;max-width:600px;font:400 12px/1.4 Arial,Tahoma,\'Sans-serif\';border-collapse:collapse;color:#333;border:1px solid #ccc">
    	<tbody>
    		<tr style="background-color:#f4f4f4">
    			<td style="padding: 10px 20px">
    				<div>Chào <strong><?php echo $fullname ?></strong></div>
    				<p>Cảm ơn bạn đã đăng ký làm thành viên của Aland English. Bạn hãy Click vào liên kết dưới đây để kích hoạt tài khoản:</p>  
    			</td>
    		</tr>
            <tr style="background-color:#f4f4f4">
                <td style="padding: 10px 20px">
                    <a href="<?php echo $link; ?>"><?php echo $link; ?></a>
                </td>
            </tr>
            <tr style="background-color:#f4f4f4">
                <td style="padding: 10px 20px">
                    Mã kích hoạt: <b><?php echo $code; ?></b>
                </td>
            </tr>
            <tr style="background-color:#f4f4f4">
                <td style="padding: 10px 20px">
                    <p>(Nếu click vào liên kết không được, bạn vui lòng copy liên kết trên và dán vào thanh địa chỉ trình duyệt)</p>
                </td>
            </tr>
    		<tr style="background-color:#fff">
    			<td style="padding:10px 20px">
    				Nếu bạn không gửi bất kỳ yêu cầu nào đến chúng tôi, hãy bỏ qua email này.
    			</td>
    		</tr>
    	</tbody>
    </table>
</body>
</html>