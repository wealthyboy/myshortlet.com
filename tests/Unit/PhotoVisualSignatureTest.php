<?php

namespace Tests\Unit;

use App\Services\PhotoFinder\VisualSignature;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class PhotoVisualSignatureTest extends TestCase
{
    private function photo(bool $other = false, int $width = 300, int $height = 200): string
    {
        $image = imagecreatetruecolor($width, $height);
        imagefill($image, 0, 0, imagecolorallocate($image, $other ? 25 : 225, $other ? 85 : 218, $other ? 190 : 201));
        for ($i = 0; $i < 9; $i++) {
            $color = imagecolorallocate($image, ($i * 27) % 255, ($i * 57) % 255, ($i * 81) % 255);
            imagefilledrectangle($image, (int) ($width * $i / 12), (int) ($height * ($other ? .6 : .1)), (int) ($width * ($i + 2) / 12), (int) ($height * ($other ? .9 : .45)), $color);
        }
        ob_start(); imagejpeg($image, null, 90); $bytes = ob_get_clean(); imagedestroy($image);
        return $bytes;
    }

    public function test_identical_and_resized_photos_rank_ahead_of_different_rooms(): void
    {
        $visual = new VisualSignature;
        $a = $visual->make($this->photo());
        $resized = $visual->make($this->photo(false, 150, 100));
        $other = $visual->make($this->photo(true));
        $this->assertSame(100, $visual->score($a, $a));
        $this->assertGreaterThanOrEqual(90, $visual->score($a, $resized));
        $this->assertGreaterThan($visual->score($a, $other), $visual->score($a, $resized));
    }

    public function test_screenshot_border_still_produces_a_close_suggestion(): void
    {
        $bytes = $this->photo(); $original = imagecreatefromstring($bytes);
        $bordered = imagecreatetruecolor(320, 220); imagefill($bordered, 0, 0, imagecolorallocate($bordered, 255, 255, 255));
        imagecopy($bordered, $original, 10, 10, 0, 0, 300, 200);
        ob_start(); imagepng($bordered); $screenshot = ob_get_clean(); imagedestroy($bordered); imagedestroy($original);
        $visual = new VisualSignature;
        $this->assertGreaterThanOrEqual(86, $visual->score($visual->make($bytes), $visual->make($screenshot)));
    }

    public function test_corrupt_or_unsupported_file_is_rejected(): void
    {
        $this->expectException(RuntimeException::class);
        (new VisualSignature)->make('<svg onload="evil()"></svg>');
    }
}
