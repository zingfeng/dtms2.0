<?php 
require_once 'TechAPI/bootstrap.php';

// include các đối tượng cần thiết
use TechAPI\Api\SendBrandnameOtp;
use TechAPI\Exception as TechException;
use TechAPI\Auth\AccessToken;

class SMSApi {

    function __construct($params = array()){
        $CI = &get_instance();
        $this->_instance = $CI;
    }

    public function send_sms($arrMessage){
        // Khởi tạo đối tượng API với các tham số phía trên.
        $apiSendBrandname = new SendBrandnameOtp($arrMessage);

        try
        {
            // Lấy đối tượng Authorization để thực thi API
            $oGrantType      = getTechAuthorization();
            
            // Thực thi API
            $arrResponse     = $oGrantType->execute($apiSendBrandname);

            // kiểm tra kết quả trả về có lỗi hay không
            if (! empty($arrResponse['error']))
            {
                // Xóa cache access token khi có lỗi xảy ra từ phía server
                AccessToken::getInstance()->clear();
                
                // quăng lỗi ra, và ghi log
                throw new TechException($arrResponse['error_description'], $arrResponse['error']);
            }
            
            echo '<pre>';
            print_r($arrResponse);
            echo '</pre>';
        }
        catch (\Exception $ex)
        {
            echo sprintf('<p>Có lỗi xảy ra:</p>');
            echo sprintf('<p>- Mã lỗi: %s</p>', $ex->getCode());
            echo sprintf('<p>- Mô tả lỗi: %s</p>', $ex->getMessage());
        }


    }
}
?>