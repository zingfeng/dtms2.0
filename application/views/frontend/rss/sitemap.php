<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($rows as $row) { ?>
        <url>
            <loc><?php echo $row ?></loc>
            <priority><?php echo $priority; ?></priority>
        </url>
    <?php } ?>
</urlset>