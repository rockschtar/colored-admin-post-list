<?php

namespace Rockschtar\WordPress\ColoredAdminPostList\Controller;

use Rockschtar\WordPress\ColoredAdminPostList\Enums\Option;
use Rockschtar\WordPress\ColoredAdminPostList\Enums\Setting;
use Rockschtar\WordPress\ColoredAdminPostList\Utils\PostStati;

class StyleController
{
    use Controller;

    private function __construct()
    {
        add_action('admin_footer-edit.php', [$this, "addStyles"]);
    }

    public function addStyles(): void
    {
        $isEnabled = get_option(Option::ENABLED->value) === '1';

        if (!$isEnabled) {
            return;
        }

        $postStati = PostStati::get();

        $style = '';

        foreach ($postStati as $postStatus) {
            $backgroundColor = get_option($postStatus->getOptionKey());

            if (!$backgroundColor || !preg_match('/^#[0-9a-fA-F]{3,6}$/', $backgroundColor)) {
                continue;
            }

            $cssClass = "status-" . sanitize_key($postStatus->getName());

            $style .= ".$cssClass { background: $backgroundColor !important }\r\n";
        }

        if ($style === '') {
            return;
        }

        echo "<style>$style</style>";
    }
}
