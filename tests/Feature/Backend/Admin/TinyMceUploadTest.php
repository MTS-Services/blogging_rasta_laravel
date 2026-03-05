<?php

use App\Models\Admin;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = Admin::factory()->create([
        'email_verified_at' => now(),
    ]);
});

test('unauthenticated user cannot upload tinymce image', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('test-image.jpg', 800, 600)->size(500);

    $this->postJson(route('admin.tinymce.upload-image'), ['file' => $file])
        ->assertUnauthorized();
});

test('authenticated admin can upload a valid image', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('test-image.jpg', 800, 600)->size(500);

    $response = $this->actingAs($this->admin, 'admin')
        ->postJson(route('admin.tinymce.upload-image'), ['file' => $file]);

    $response->assertOk()
        ->assertJsonStructure(['location']);

    Storage::disk('public')->assertExists('blog-content-images/' . basename($response->json('location')));
});

test('upload rejects non-image files', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');

    $this->actingAs($this->admin, 'admin')
        ->postJson(route('admin.tinymce.upload-image'), ['file' => $file])
        ->assertUnprocessable();
});

test('upload rejects files exceeding max size', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('large-image.jpg')->size(16000);

    $this->actingAs($this->admin, 'admin')
        ->postJson(route('admin.tinymce.upload-image'), ['file' => $file])
        ->assertUnprocessable();
});

test('upload requires a file', function () {
    Storage::fake('public');

    $this->actingAs($this->admin, 'admin')
        ->postJson(route('admin.tinymce.upload-image'), [])
        ->assertUnprocessable();
});
