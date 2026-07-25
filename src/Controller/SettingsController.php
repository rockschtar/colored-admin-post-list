<?php

namespace Rockschtar\WordPress\ColoredAdminPostList\Controller;

use Rockschtar\WordPress\ColoredAdminPostList\Enums\AdminPage;
use Rockschtar\WordPress\ColoredAdminPostList\Enums\Option;
use Rockschtar\WordPress\ColoredAdminPostList\Enums\Setting;
use Rockschtar\WordPress\ColoredAdminPostList\Models\PostStatus;
use Rockschtar\WordPress\ColoredAdminPostList\Utils\PluginVersion;
use Rockschtar\WordPress\ColoredAdminPostList\Utils\PostStati;

class SettingsController
{
    use Controller;

    private function __construct()
    {
        add_action("admin_init", $this->registerSettings(...));
        add_action("admin_menu", $this->adminMenu(...));
        add_action('admin_print_scripts-settings_page_' . AdminPage::ADMIN_PAGE_OPTIONS, $this->adminPrintScriptsSettings(...));
        add_action('admin_print_scripts-posts_page_' . AdminPage::ADMIN_PAGE_OPTIONS, $this->adminPrintScriptsSettings(...));
        add_filter("plugin_action_links_" . CAPL_PLUGIN, $this->pluginActionLinks(...));
    }

    private function adminMenu(): void
    {
        add_options_page(
            "Colored Post List",
            "Colored Post List",
            "manage_options",
            AdminPage::ADMIN_PAGE_OPTIONS,
            $this->viewSettings(...),
        );
    }

    private function adminPrintScriptsSettings(): void
    {
        wp_enqueue_style("wp-color-picker");

        $pluginVersion = PluginVersion::get();
        $version = $pluginVersion === 'develop' ? time() : $pluginVersion;

        wp_enqueue_script("capl-settings", CAPL_PLUGIN_URL . "scripts/settings.js", ["jquery", "wp-color-picker"], $version, ['in_footer' => true]);
    }

    private function pluginActionLinks(array $links): array
    {
        $settingsLink = '<a href="' . esc_url(admin_url('options-general.php?page=' . AdminPage::ADMIN_PAGE_OPTIONS)) . '">' . __("Settings", "colored-admin-post-list") . '</a>';
        array_unshift($links, $settingsLink);
        return $links;
    }

    private function registerSettings(): void
    {
        register_setting(
            Setting::PAGE_DEFAULT,
            Option::ENABLED->value,
            ['type' => 'string', 'default' => '', 'sanitize_callback' => static fn($value) => $value === '1' ? '1' : '']
        );

        add_settings_section(
            Setting::SECTION_GENERAL,
            __("General", "colored-admin-post-list"),
            static fn() => '',
            Setting::PAGE_DEFAULT
        );

        add_settings_section(
            Setting::SECTION_COLORS_DEFAULT,
            __("Default Post Statuses", "colored-admin-post-list"),
            static fn() => '',
            Setting::PAGE_DEFAULT
        );

        add_settings_field(
            Option::ENABLED->value,
            __("Enabled", "colored-admin-post-list"),
            $this->settingEnabled(...),
            Setting::PAGE_DEFAULT,
            Setting::SECTION_GENERAL
        );

        $defaultPostStati = PostStati::getDefault();

        $registerSettingPostStati = function (PostStatus $postStatus, string $section) {
            add_settings_field(
                $postStatus->getOptionKey(),
                $postStatus->getLabel(),
                static function () use ($postStatus) {
                    printf(
                        '<input class="capl-wp-color-picker" type="text" id="%1$s" name="%1$s" class="regular-text" value="%2$s" />',
                        esc_attr($postStatus->getOptionKey()),
                        esc_attr(get_option($postStatus->getOptionKey()))
                    );
                },
                Setting::PAGE_DEFAULT,
                $section
            );

            register_setting(
                Setting::PAGE_DEFAULT,
                $postStatus->getOptionKey(),
                ['type' => 'string', 'default' => $postStatus->getDefaultColor(), 'sanitize_callback' => 'sanitize_hex_color']
            );
        };

        foreach ($defaultPostStati as $defaultPostStatus) {
            $registerSettingPostStati($defaultPostStatus, Setting::SECTION_COLORS_DEFAULT);
        }

        $customPostStati = PostStati::getCustom();

        foreach ($customPostStati as $customPostStatus) {
            $registerSettingPostStati($customPostStatus, Setting::SECTION_COLORS_CUSTOM);
        }

        if (count($customPostStati) > 0) {
            add_settings_section(
                Setting::SECTION_COLORS_CUSTOM,
                __("Custom Post Statuses", "colored-admin-post-list"),
                static fn() => '',
                Setting::PAGE_DEFAULT
            );
        }
    }

    private function settingEnabled(): void
    {
        printf(
            '<input type="checkbox" name="%s" value="1" %s />',
            esc_attr(Option::ENABLED->value),
            checked(get_option(Option::ENABLED->value) === '1', true, false)
        );
    }

    private function viewSettings(): void
    {
        include(CAPL_PLUGIN_DIR . "/views/settings.php");
    }
}
