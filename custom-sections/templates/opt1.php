<h1>I tu działa</h1>
<?php super_var_dump($section); ?>
<div class="" <?php write_iksc_background($section); ?>>
    <?php
    if (check_iksc_field($section, 'link')){
        write_iksc_field($section, 'link');
    }
    ?>
</div>

