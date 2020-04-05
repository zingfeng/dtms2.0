<?php $profile = $this->permission->getIdentity(); ?>
<div class="col-2 navigation-top__user">
    <figure class="navigation-top__user">
        <img class="avatar" src="<?php echo $profile['avatar'] ?>">
        <figcaption>
            <strong>Hi</strong>, <?php echo $profile['fullname'];?>
        </figcaption>
    </figure>
</div>