<?php 
$arrBranch = $this->config->item("branch");
$arrBranch = json_decode($arrBranch, TRUE);
//Add other
$arrBranch[] = array(
	'id' => 9,
	'label' => 'Khác',
	'name' => 'Khác'
);

$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash(),
);
?>
	<h2 class="title_bg" style="height: 50px; padding: 10px 20px">
  		<a href="">TƯ VẤN <span style="display: inline;">MIỄN PHÍ</span></a>
	</h2>
	<form class="form_advisory" id="contact_form_support_form" action="<?php echo SITE_URL; ?>/contact/tuvan" style="padding: 20px">
	  <div class="form-group" id="contact_support_fullname">
		<input type="fullname"  name="fullname" placeholder="Họ và tên" class="form-control">
	  </div>
	  <div class="form-group" id="contact_support_phone">
		<input type="phone"  name="phone" placeholder="Số điện thoại" class="form-control">
	  </div>
	  <div class="form-group" id="contact_support_email">
		<input type="email" name="email" placeholder="Email" class="form-control">
	  </div>
	  <div class="form-group">
		<select class="form-control" name="coso">
			<option value="0">Chọn cơ sở</option>
			<?php foreach ($arrBranch as $key => $branch) {?>
			<option value="<?php echo $branch['id']; ?>"><?php echo $branch['label']; ?></option>
			<?php }?>
		</select>
	  </div>
	  <input class="form_csrf" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
	  <button id="contact_form_support" type="button" class="btn btn-default">Đăng ký tư vấn</button>
	</form>
<script type="text/javascript">
	$("#contact_form_support").bind("click",function(e){
		e.preventDefault(); // avoid to execute the actual submit of the form.
	    var form = $("#contact_form_support_form");
	    form.find(".error").remove();
	    var url = form.attr('action');
	    $.ajax({
	           type: "POST",
	           url: url,
	           data: form.serialize(), // serializes the form's elements.
	           success: function(data)
	           {
	           		if (data.status == 'error') {
	           			$.each( data.message, function( key, value ) {
						  	$("#contact_support_" + key).append('<div class="error text-left">' + value + '</div>');
						});
	           		}
	           		else {
	           			alert("Đăng ký thành công");
	           			form.trigger("reset");
	           		}
	           		$(".form_csrf").val(data.csrf_hash);
	           },
	           dataType : 'json'
	         });
	})
</script>