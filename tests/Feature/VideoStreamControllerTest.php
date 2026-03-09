<?php

use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('s3');
    Storage::fake('public');
});

// ── VideoStreamController ──────────────────────────────────────────

it('streams video from S3 when file exists', function () {
    Storage::disk('s3')->put('videos/tiktok/test_video.mp4', 'fake-video-content');

    $response = $this->get('/storage/videos/tiktok/test_video.mp4');

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'video/mp4');
    $response->assertHeader('Accept-Ranges', 'bytes');
    expect($response->headers->get('Cache-Control'))->toContain('max-age=31536000');
});

it('falls back to local disk when S3 file missing', function () {
    Storage::disk('public')->put('videos/tiktok/local_video.mp4', 'local-video-content');

    $response = $this->get('/storage/videos/tiktok/local_video.mp4');

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'video/mp4');
});

it('returns 404 when video not found on S3 or local', function () {
    $response = $this->get('/storage/videos/tiktok/nonexistent.mp4');

    $response->assertNotFound();
});

it('returns 404 for path traversal attempts on videos', function () {
    $response = $this->get('/storage/videos/tiktok/../../../etc/passwd');

    $response->assertNotFound();
});

it('supports HTTP Range requests for video streaming', function () {
    $content = str_repeat('x', 1000);
    Storage::disk('s3')->put('videos/tiktok/range_test.mp4', $content);

    $response = $this->withHeaders(['Range' => 'bytes=0-499'])
        ->get('/storage/videos/tiktok/range_test.mp4');

    expect($response->getStatusCode())->toBe(206);
    $response->assertHeader('Content-Length', '500');
    $response->assertHeader('Accept-Ranges', 'bytes');
    expect($response->headers->get('Content-Range'))->toStartWith('bytes 0-499/');
});

// ── ThumbnailStreamController ──────────────────────────────────────

it('streams thumbnail from S3 when file exists', function () {
    Storage::disk('s3')->put('thumbnails/test_thumb.jpg', 'fake-image-content');

    $response = $this->get('/storage/thumbnails/test_thumb.jpg');

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'image/jpeg');
    expect($response->headers->get('Cache-Control'))->toContain('max-age=31536000');
});

it('streams png thumbnail with correct mime type', function () {
    Storage::disk('s3')->put('thumbnails/test_thumb.png', 'fake-png');

    $response = $this->get('/storage/thumbnails/test_thumb.png');

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'image/png');
});

it('falls back to local disk for thumbnails when S3 file missing', function () {
    Storage::disk('public')->put('thumbnails/local_thumb.jpg', 'local-thumb');

    $response = $this->get('/storage/thumbnails/local_thumb.jpg');

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'image/jpeg');
});

it('returns 404 when thumbnail not found on S3 or local', function () {
    $response = $this->get('/storage/thumbnails/nonexistent.jpg');

    $response->assertNotFound();
});

it('returns 404 for path traversal attempts on thumbnails', function () {
    $response = $this->get('/storage/thumbnails/../../../etc/passwd');

    $response->assertNotFound();
});
