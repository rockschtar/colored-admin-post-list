<?php

namespace Rockschtar\WordPress\ColoredAdminPostList\Controller;

use Rockschtar\WordPress\ColoredAdminPostList\Enums\Option;
use Rockschtar\WordPress\ColoredAdminPostList\Utils\PluginVersion;
use Rockschtar\WordPress\ColoredAdminPostList\Utils\PostStati;

class PluginController
{
    use Controller;

    private function __construct()
    {
        register_activation_hook(CAPL_PLUGIN_FILE, $this->onActivation(...));
        register_deactivation_hook(CAPL_PLUGIN_FILE, $this->onDeactivation(...));
        register_uninstall_hook(CAPL_PLUGIN_FILE, [__CLASS__, "onUninstall"]);
        add_action('plugins_loaded', $this->pluginsLoaded(...));

        SettingsController::init();
        StyleController::init();
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
            update_option(Option::ENABLED->value, "1");
            update_option(Option::INSTALLED->value, "1");
            update_option(Option::VERSION->value, PluginVersion::get());
        }
    }

    private function onDeactivation(): void
    {
    }

    public static function onUninstall(): void
    {
        $postStati = PostStati::get();

        foreach ($postStati as $postStatus) {
            delete_option($postStatus->getOptionKey());
        }

        foreach (Option::cases() as $option) {
            delete_option($option->value);
        }
    }
}
