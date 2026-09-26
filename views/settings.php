<?php

defined( 'ABSPATH' ) || exit;

use Rockschtar\WordPress\ColoredAdminPostList\Enums\Setting;

?>
<style>
    .capl-settings { display: flex; gap: 20px; align-items: flex-start; }
    .capl-settings-main { flex: 1; min-width: 0; }
    .capl-settings-sidebar { flex: 0 0 280px; margin-top: 20px; }
    .capl-settings-sidebar .postbox { margin-bottom: 0; }
    .capl-settings-sidebar h2 { margin: 0; padding: 12px; font-size: 14px; border-bottom: 1px solid #c3c4c7; }
    @media screen and (max-width: 960px) {
        .capl-settings { flex-direction: column; }
        .capl-settings-sidebar { flex-basis: auto; width: 100%; }
    }
</style>
<div class="wrap">
    <div id="icon-themes" class="icon32"><br></div>
    <h2><?php echo __("Colored Admin Post List Settings", "colored-admin-post-list") ?></h2>
    <div class="capl-settings">
        <div class="capl-settings-main">
            <form method="post" action="options.php">
                <?php settings_fields(Setting::PAGE_DEFAULT); ?>
                <?php do_settings_sections(Setting::PAGE_DEFAULT); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <div class="capl-settings-sidebar">
            <div class="postbox">
                <h2><?php esc_html_e("Enjoying this plugin?", "colored-admin-post-list"); ?></h2>
                <div class="inside">
                    <p><?php esc_html_e("Colored Admin Post List is free and developed in my spare time. If it makes your daily work a little easier, I'd be happy about a small donation.", "colored-admin-post-list"); ?></p>
                    <p>
                        <a class="button button-primary" href="<?php echo esc_url(CAPL_DONATE_URL); ?>" target="_blank" rel="noopener noreferrer">
                            <?php esc_html_e("Buy me a coffee", "colored-admin-post-list"); ?> &#9749;
                        </a>
                    </p>
                    <p>
                        <a href="https://wordpress.org/support/plugin/colored-admin-post-list/reviews/#new-post" target="_blank" rel="noopener noreferrer">
                            <?php esc_html_e("Or leave a review on WordPress.org", "colored-admin-post-list"); ?>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
