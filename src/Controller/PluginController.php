<?php

namespace Rockschtar\WordPress\ColoredAdminPostList\Controller;

use Rockschtar\WordPress\ColoredAdminPostList\Enums\DefaultColor;
use Rockschtar\WordPress\ColoredAdminPostList\Enums\Option;
use Rockschtar\WordPress\ColoredAdminPostList\Enums\Setting;
use Rockschtar\WordPress\ColoredAdminPostList\Utils\PluginVersion;

class PluginController
{
    use Controller;

    private function __construct()
    {
        register_activation_hook(CAPL_PLUGIN_FILE, $this->onActivation(...));
        register_deactivation_hook(CAPL_PLUGIN_FILE, $this->onDeactivation(...));
        register_uninstall_hook(CAPL_PLUGIN_FILE, [__CLASS__, "onUninstall"]);
        add_action('plugins_loaded', $this->pluginsLoaded(...));
        add_action("init", $this->loadPluginTextdomain(...));

        SettingsController::init();
        StyleController::init();
    }

    private function loadPluginTextdomain(): void
    {
        load_plugin_textdomain("colored-admin-post-list", true, CAPL_PLUGIN_RELATIVE_DIR . '/languages/');
    }

    private function pluginsLoaded(): void
    {
        if (get_site_option(Option::VERSION->value) !== PluginVersion::get()) {
            update_site_option(Option::VERSION->value, PluginVersion::get());
        }
    }

    private function onActivation(): void
    {
        if (!get_option(Option::INSTALLED->value)) {
            update_option(Setting::ENABLED, "1");
            update_option(Option::INSTALLED->value, "1");
            update_option(Option::VERSION->value, PluginVersion::get());
        }
    }

    private function onDeactivation(): void
    {
    }

    public static function onUninstall(): void
    {
        delete_option(Option::INSTALLED->value);

        global $wpdb;

        $options = $wpdb->get_results("SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'capl-%'");
        foreach ($options as $option) {
            delete_option($option->option_name);
        }

        foreach (Option::cases() as $option) {
            delete_option($option->value);
        }
    }
}
