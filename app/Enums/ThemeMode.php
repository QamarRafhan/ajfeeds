<?php

namespace App\Enums;

enum ThemeMode: string
{
    case LIGHT_BLUE = 'light_blue';
    case MIDNIGHT = 'midnight';
    case MODERN_DARK = 'modern_dark';
    case FOREST_GREEN = 'forest_green';
    case SUNSET_GOLD = 'sunset_gold';
    case ROYAL_PURPLE = 'royal_purple';
    case OCEAN_TEAL = 'ocean_teal';
    case ROSE_QUARTZ = 'rose_quartz';
    case MONOCHROME = 'monochrome';
    case HIGH_CONTRAST = 'high_contrast';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    // Optional (nice for dropdown labels)
    public function label(): string
    {
        return match ($this) {
            self::LIGHT_BLUE => 'Light Blue',
            self::MIDNIGHT => 'Midnight',
            self::MODERN_DARK => 'Modern Dark',
            self::FOREST_GREEN => 'Forest Green',
            self::SUNSET_GOLD => 'Sunset Gold',
            self::ROYAL_PURPLE => 'Royal Purple',
            self::OCEAN_TEAL => 'Ocean Teal',
            self::ROSE_QUARTZ => 'Rose Quartz',
            self::MONOCHROME => 'Monochrome',
            self::HIGH_CONTRAST => 'High Contrast',
        };
    }
}
