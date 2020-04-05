<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?if($this->session->userdata('username') && $this->session->userdata('userid') ){?>
    <div id="logins">
        <div class="login"><b>Xin chào : <font color="red"><?echo $this->session->userdata('username');?></font> </b><?echo anchor('users/logout','Logout')?></div>
    </div>
<?}else{?>
    <div id="logins">
        <div class="login"><a href="javascript:quick_login();">Đăng nhập</a>/<?echo anchor('users/register','Đăng ký')?></div>
    </div>
    <!-- DANG NHAP NHANH -->
    <div id="mini_login" title="Đăng nhập" style="display: none;">
    	<form id="quick_login" method="POST" action="">
            <div id="quick_login_error"></div>
            <table width="100%">
                <tr>
                    <td class="label">Tên đăng nhập:</td>
                    <td><input id="log_username" type="text" name="log_username" value=""/></td>
                </tr>
                <tr>
                    <td class="label">Mật khẩu:</td>
                    <td><input id="log_username" type="password" name="log_password" value=""/></td>
                </tr>
            </table>
    	</form>
    </div>
<?}?>