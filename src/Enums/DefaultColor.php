<?php

namespace Rockschtar\WordPress\ColoredAdminPostList\Enums;

use ReflectionClass;

enum DefaultColor : string
{
    case DRAFT = "#FCE3F2";

    case PENDING = "#87C5D6";

    case FUTURE = "#C6EBF5";

    case PRIVATE = "#F2D46F";

    case PUBLISH = "transparent";

    public static function tryFromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }
}
