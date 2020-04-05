<!-- Trending now -->
<?php echo $this->load->get_block('trending'); ?>
<!-- End trending -->
<section class="container clearfix">
	<section class="container clearfix">
        <div class="row">
            <div id="top_banner" class="col-md-8 col-sm-8 col-xs-8 col-tn-12 mb20">
                <?php echo $this->load->get_block('home_banner'); ?>
            </div>
            <div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12">
            	<div class="category resign_pc">
	                <?php echo DEVICE_ENV == 4 ? $this->load->view("block/contact") : ''; ?>
	            </div>
            </div>
        </div>
    </section>

    <!-- Khóa học trang chủ -->
    <?php echo $this->load->get_block('home_course'); ?>

    <!-- Box tư vấn mobile -->
    <div class="resign_mobile category">
        <?php echo DEVICE_ENV == 1 ? $this->load->view("block/contact") : ''; ?>
    </div>
    <!-- End box tư vấn mobile -->
    
	<div class="row">
		<div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12">
			<?php echo $this->load->get_block('home_content'); ?>
		</div>
		<div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12">
			<?php echo $this->load->get_block('home_right'); ?>
		</div>
	</div>
	
	<?php echo $this->load->get_block('home_center'); ?>
	<div class="row">
		<div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12 mb20">
			<?php echo $this->load->get_block('left_content'); ?>
		</div>
		<div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12">
			<?php echo $this->load->get_block('home_footer_right'); ?>
		</div>
	</div>
	<?php echo $this->load->get_block('home_footer_2'); ?>
	<div class="clearfix"></div>
	<?php if ($arrTags) {?>
	<div class="tag_hot mb20">
		<label>NỔI BẬT</label>
		<div class="warp">
			<?php foreach ($arrTags as $key => $tag) {?>
				<a href="<?php echo $tag['share_url']; ?>" title="<?php echo $tag['name']; ?>"><?php echo $tag['name']; ?></a>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<?php echo $this->load->get_block('home_footer'); ?>
</section>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Aland IELTS",
        "image": "https://www.aland.edu.vn/theme/frontend/default/images/graphics/logo2.png",
        "@id": "https://www.aland.edu.vn",
        "url": "https://www.aland.edu.vn",
        "telephone": "024 6658 4565",
        "priceRange": "3.290.000",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "60-62 Bạch Mai, Cầu Dền, Hai Bà Trưng, Hanoi City 100000",
            "addressLocality": "Hanoi",
            "postalCode": "100000",
            "addressCountry": "VN"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 21.006696,
            "longitude": 105.8490087
        } ,
        "sameAs": [
            "https://www.facebook.com/aland.edu.vn",
            "https://twitter.com/AlandIelts",
            "https://www.instagram.com/alandielts.leader",
            "http://www.youtube.com/c/AlandIELTS",
            "https://soundcloud.com/alandielts",
            "https://www.pinterest.com/alandielts",
            "https://alandielts.tumblr.com"
        ]
    }
</script>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Aland IELTS",
        "alternateName": "Aland IELTS",
        "url": "https://www.aland.edu.vn",
        "logo": "https://www.aland.edu.vn/theme/frontend/default/images/graphics/logo2.png",
        "sameAs": [
            "https://www.facebook.com/aland.edu.vn",
            "https://twitter.com/AlandIelts",
            "https://www.instagram.com/alandielts.leader",
            "http://www.youtube.com/c/AlandIELTS",
            "https://www.linkedin.com/company/alandielts",
            "https://www.pinterest.com/alandielts",
            "https://soundcloud.com/alandielts",
            "https://alandielts.tumblr.com",
            "https://about.me/alandielts",
            "https://500px.com/alandielts",
            "https://www.diigo.com/profile/alandielts",
            "https://www.instapaper.com/p/alandielts",
            "https://www.aland.edu.vn"
        ]
    }
</script>

<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Person",
        "name": "Aaron Smith",
        "url": "https://www.aland.edu.vn/expert/mr-aaron-smith-chuyen-gia-ielts-37572.html",
        "image": "https://www.aland.edu.vn/uploads/images/crop/250x250/su_gia/aaron__chuyen_gia_ielts.jpg",
        "sameAs": [
            "https://www.facebook.com/profile.php?id=100034576098996",
            "https://twitter.com/aaronsm78365949",
            "https://aaronsmithielts.tumblr.com",
            "https://www.instagram.com/flame_fingers/",
            "https://www.aland.edu.vn/expert/mr-aaron-smith-chuyen-gia-ielts-37572.html"
        ],
        "jobTitle": "Expert IELTS",
        "worksFor": {
            "@type": "Organization",
            "name": "Aland IELTS"
        }
    }
</script>
