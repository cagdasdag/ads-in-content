<div class="wrap">
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2 aic_wrapper">
            <div id="post-body-content">
                <form action="options.php" method="post">
                    <header class="aic_header">
                        <div class="aic_header_left">
                            <div class="aic_header_logo"><?= $heading ?></div>
                            <div class="aic_header_title"><?php _e('Plugin Options', 'ads-in-content') ?></div>
                        </div>
                        <div class="aic_header_right">
                            <div class="aic_header_save">
                                <?php submit_button('Save Changes', 'aic_header_saveButton', 'submit', true, array('class' => 'aic_header_saveButton')); ?>
                            </div>
                        </div>
                    </header>
                    <?php settings_fields($settings_group); ?>
                    <?= $fields ?>
                </form>
            </div>
        </div>
        <br class="clear">
    </div>
</div>
