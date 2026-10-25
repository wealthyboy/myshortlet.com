<?php

namespace App\Services\PhotoFinder;

use RuntimeException;

/** Local near-duplicate comparison, not semantic recognition or proof of identity. */
class VisualSignature
{
    public const VERSION = 1;
    public const MAX_BYTES = 8388608;

    public function make(string $bytes): array
    {
        if (!extension_loaded('gd')) {
            throw new RuntimeException('Photo search requires the PHP GD extension.');
        }
        $size = @getimagesizefromstring($bytes);
        if (strlen($bytes) > self::MAX_BYTES || !$size || $size[0] * $size[1] > 12000000
            || !in_array($size[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            throw new RuntimeException('Choose a JPEG, PNG or WebP photo under 8 MB and 12 megapixels.');
        }
        $image = @imagecreatefromstring($bytes);
        if (!$image) {
            throw new RuntimeException('This photo could not be read. Please try another image.');
        }
        try {
            $variants = [];
            // Light crops tolerate screenshot borders and small OTA crops.
            foreach ([0, .04, .10] as $crop) {
                $sample = imagecreatetruecolor(9, 8);
                imagefill($sample, 0, 0, imagecolorallocate($sample, 255, 255, 255));
                imagecopyresampled($sample, $image, 0, 0, (int) ($size[0] * $crop), (int) ($size[1] * $crop),
                    9, 8, max(1, (int) ($size[0] * (1 - 2 * $crop))), max(1, (int) ($size[1] * (1 - 2 * $crop))));
                $gray = []; $colors = [];
                for ($y = 0; $y < 8; $y++) {
                    for ($x = 0; $x < 9; $x++) {
                        $rgb = imagecolorat($sample, $x, $y);
                        $r = ($rgb >> 16) & 255; $g = ($rgb >> 8) & 255; $b = $rgb & 255;
                        $gray[$y][$x] = .299 * $r + .587 * $g + .114 * $b;
                        if ($x < 8) { $colors[] = $r; $colors[] = $g; $colors[] = $b; }
                    }
                }
                imagedestroy($sample);
                $pixels = [];
                foreach ($gray as $line) { $pixels = array_merge($pixels, array_slice($line, 0, 8)); }
                $average = array_sum($pixels) / 64;
                $difference = ''; $brightness = '';
                for ($y = 0; $y < 8; $y++) {
                    for ($x = 0; $x < 8; $x++) {
                        $difference .= $gray[$y][$x] > $gray[$y][$x + 1] ? '1' : '0';
                        $brightness .= $gray[$y][$x] >= $average ? '1' : '0';
                    }
                }
                $variants[] = ['difference' => $difference, 'brightness' => $brightness, 'colors' => $colors];
            }
            return ['version' => self::VERSION, 'variants' => $variants];
        } finally {
            imagedestroy($image);
        }
    }

    public function score(array $reference, array $candidate): int
    {
        if (($candidate['version'] ?? null) !== self::VERSION) { return 0; }
        $best = 1;
        foreach ($reference['variants'] ?? [] as $a) {
            foreach ($candidate['variants'] ?? [] as $b) {
                if (strlen($b['difference'] ?? '') !== 64 || strlen($b['brightness'] ?? '') !== 64 || count($b['colors'] ?? []) !== 192) { continue; }
                $edges = 0; $light = 0; $color = 0;
                for ($i = 0; $i < 64; $i++) {
                    $edges += $a['difference'][$i] !== $b['difference'][$i] ? 1 : 0;
                    $light += $a['brightness'][$i] !== $b['brightness'][$i] ? 1 : 0;
                }
                foreach ($a['colors'] as $i => $value) { $color += abs($value - $b['colors'][$i]); }
                $best = min($best, .5 * $edges / 64 + .3 * $light / 64 + .2 * $color / (192 * 255));
            }
        }
        return max(0, min(100, (int) round(100 * (1 - $best))));
    }
}
