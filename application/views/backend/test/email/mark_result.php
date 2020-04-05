<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Chấm điểm bài test writing</title>
    <style type="text/css" media="screen">
        body{
            background-color: #d0d0d0;
        }
    </style>
</head>
<body>
<div style="display: flex; justify-content: center;">
    <table style="max-width:600px;font:400 12px/1.4 Arial,Tahoma,\'Sans-serif\';border-collapse:collapse;color:#333; border-radius: 3em; box-shadow: 0 0 16px 0 rgba(0,0,0,0.16);">
        <tbody>
        <tr>
            <td style="text-align: center;">
                <img src="https://www.aland.edu.vn/theme/frontend/default/images/graphics/logo2.png" style="width: 10rem; padding: 10px 20px">
            </td>
        </tr>
        <tr>
        <td>
            <div style="background-color: #CD191D; width: 100%; height: 2px;"></div>
        </td>           
        </tr>
            <tr>
                <td style="padding: 10px 20px">
                    <div>Chào <strong><?php echo $user['fullname'] ?></strong></div>
                    <p>Aland English xin thông báo kết quả làm bài test writing của <?php echo $user['fullname'] ?> như sau::</p>  
                </td>
            </tr>
            <?php $i = 1; foreach($answer as $key => $item) { ?>
            <tr>
                <td style="padding: 10px 20px">
                    <p style="text-transform: uppercase; color: red">Phần <?php echo $i?></p>
                    <b>Bài làm của bạn:</b> <?php echo $item; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 20px">
                    <b>Điểm bài làm:</b> <b style="color: red"><?php echo $arrReview[$key]['score']; ?></b>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 20px">
                    <b>Giáo viên chữa bài:</b> <?php echo $arrReview[$key]['review']; ?>
                </td>
            </tr>
             <tr>
                <td style="padding: 10px 20px">
                    <b>Nhận xét:</b> <?php echo $arrReview[$key]['summary']; ?>
                </td>
            </tr>
            <?php $i++; } ?>
            <tr>
                <td style="padding: 10px 20px">
                    <p style="text-transform: uppercase; color: red">Tổng kết</p>
                    <b>Điểm trung bình writing:</b> <b style="color: red">4 điểm</span></b>
                </td>
            </tr>
            <tr>
                <td style="padding:10px 20px">
                    <p><?php echo $user['fullname'] ?> có câu hỏi hay thắc mắc gì về bài thi của mình không nhỉ? Nếu có hay Reply Email này cho cô biết nhé. </p>
                    <p>Đừng quên là nếu có vấn đề gì cần được giải đáp thì hãy mạnh dạn gửi vào <a href="https://www.facebook.com/groups/ielts.aland/">Group Động 8IELTS - Aland</a> nhé, cô và các Admin sẽ hỗ trợ em 24/7 nha. </p>
                    <p>Cám ơn <?php echo $user['fullname'] ?>, nếu em muốn thử sức với bài Test khác thì ghé vào <a href="https://www.aland.edu.vn/test/tron-bo-test-ielts-full-4-ky-nang-c3547.html">đường link</a> này nhé </p>
                </td>
            </tr>
            <tr>
        <td>
            <div style="background-color: #CD191D; width: 100%; height: 2px;"></div>
        </td>           
        </tr>
            <tr>
                <td style="padding:10px 20px">
                    <b>Aland IELTS chúc em luôn học tốt!</b>
                </td>               
            </tr>
        </tbody>
    </table>    
</div>
</body>
</html>