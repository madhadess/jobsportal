<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\ProfileCv;
use App\Helpers\ImageUploadingHelper as ImgUploader;

class VerificationController extends Controller
{
    public function showVerificationForm()
    {
        $user = Auth::user();

        // Eğer zaten doğrulanmışsa (Veya şartlar sağlanmışsa) dashboard'a at
        // Not: Burada 'verified' alanı e-posta için kullanılıyor olabilir, 
        // biz profil doluluğuna bakacağız.

        return view('auth.verify_profile', compact('user'));
    }

    public function submitVerification(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'cv_file' => 'required|mimes:pdf,doc,docx|max:5120',
        ];

        // Bakıcı veya Personel ise Video ZORUNLU
        if ($user->isPersonnel() || $user->isCaregiver()) {
            $rules['video_file'] = 'required|mimes:mp4,mov,ogg,qt|max:20480';
        } else {
            // Aday ise Video OPSİYONEL
            $rules['video_file'] = 'nullable|mimes:mp4,mov,ogg,qt|max:20480';
        }

        $request->validate($rules);

        // Handle Video Upload
        if ($request->hasFile('video_file')) {
            $video = $request->file('video_file');
            $fileName = time() . '_' . $video->getClientOriginalName();
            $video->move(public_path('uploads/videos'), $fileName);
            $user->video_link = $fileName;
        }

        $user->save();

        // Handle CV Upload
        if ($request->hasFile('cv_file')) {
            $cv = $request->file('cv_file');
            $fileName = ImgUploader::UploadDoc('cvs', $cv, 'Varsayılan CV');

            // Eski CV'leri pasif yap (Veya sil)
            ProfileCv::where('user_id', $user->id)->update(['is_default' => 0]);

            $profileCv = new ProfileCv();
            $profileCv->user_id = $user->id;
            $profileCv->title = 'Varsayılan CV';
            $profileCv->cv_file = $fileName;
            $profileCv->is_default = 1;
            $profileCv->save();
        }

        return redirect()->route('home')->with('success', 'Profiliniz başarıyla güncellendi ve doğrulamaya gönderildi.');
    }
}
