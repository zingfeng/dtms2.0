<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php foreach ($rows as $key => $row) { ?>
	<sitemap>
      <loc><?php echo $row; ?></loc>
      <lastmod><?php echo date('Y-m-d',$times).'T'.date('H:i:s+07:00',$times); ?></lastmod>
   </sitemap>
	<?php } ?>
</sitemapindex>