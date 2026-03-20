<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\ProfileCv;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;

class UserRegistrationTest extends TestCase
{
    use WithFaker;

    public function test_user_can_register_with_cv_and_video_and_files_exist()
    {
        $uniqueEmail = 'test_' . time() . '@example.com';
        $cvName = 'resume_' . time() . '.pdf';
        $videoName = 'intro_' . time() . '.mp4';

        $response = $this->post(route('register'), [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $uniqueEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'user_type' => 'candidate',
            'is_subscribed' => 1,
            'terms_of_use' => 1,
            'cv_file' => UploadedFile::fake()->create($cvName, 100, 'application/pdf'),
            'video_file' => UploadedFile::fake()->create($videoName, 500, 'video/mp4'),
        ]);

        // Assert no validation errors
        if (session('errors')) {
            dump(session('errors')->all());
        }
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        // Find the specific user we just created
        $user = User::where('email', $uniqueEmail)->first();
        $this->assertNotNull($user, 'User was not created in DB');

        // 1. Verify Video Path and Existence
        $this->assertNotNull($user->video_link, 'Video link is null on user object');
        $videoPath = public_path('uploads/videos/' . $user->video_link);
        $this->assertTrue(File::exists($videoPath), 'Video file does not exist at: ' . $videoPath);

        // 2. Verify CV Path and Existence
        $profileCv = ProfileCv::where('user_id', $user->id)->first();
        $this->assertNotNull($profileCv, 'Profile CV record not found');

        $cvPath = public_path('cvs/' . $profileCv->cv_file);
        $this->assertTrue(File::exists($cvPath), 'CV file does not exist at: ' . $cvPath);

        // 3. Cleanup
        if (File::exists($videoPath))
            File::delete($videoPath);
        if (File::exists($cvPath))
            File::delete($cvPath);

        // Clean DB
        $profileCv->delete();
        $user->forceDelete();
    }
}
