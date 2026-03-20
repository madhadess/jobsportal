<?php

namespace App\Traits;

use Auth;
use App\User;
use App\ProfileCertificate;
use Illuminate\Http\Request;

trait ProfileCertificateTrait
{
    public function showFrontProfileCertificates(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $html = '';
        if (isset($user) && $user->profileCertificates->count()):
            foreach ($user->profileCertificates as $cert):
                $fileLink = '';
                if ($cert->file) {
                    $fileLink = '<a href="' . asset('uploads/certificates/' . $cert->file) . '" target="_blank" class="text-primary ms-2"><i class="fas fa-download"></i> İndir</a>';
                }
                $html .= '<div class="expbox d-flex align-items-center justify-content-between mb-2" id="certificate_' . $cert->id . '">
                    <div><i class="fas fa-certificate text-warning me-2"></i> ' . e($cert->title) . $fileLink . '</div>
                    <div class="cvnewbxedit">
                        <a href="javascript:void(0);" onclick="delete_profile_certificate(' . $cert->id . ');" class="text text-danger"><i class="fas fa-times"></i></a>
                    </div>
                </div>';
            endforeach;
        endif;
        echo $html;
    }

    public function storeFrontProfileCertificate(Request $request, $user_id)
    {
        $request->validate([
            'certificate_title' => 'required|string|max:255',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $cert = new ProfileCertificate();
        $cert->user_id = $user_id;
        $cert->title = $request->input('certificate_title');

        if ($request->hasFile('certificate_file')) {
            $file = $request->file('certificate_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/certificates'), $fileName);
            $cert->file = $fileName;
        }

        $cert->save();

        $returnHTML = view('user.forms.certificate.certificate_thanks')->render();
        return response()->json(['success' => true, 'html' => $returnHTML], 200);
    }

    public function deleteFrontProfileCertificate(Request $request)
    {
        $cert = ProfileCertificate::find($request->input('id'));
        if ($cert && $cert->user_id == Auth::user()->id) {
            if ($cert->file && file_exists(public_path('uploads/certificates/' . $cert->file))) {
                unlink(public_path('uploads/certificates/' . $cert->file));
            }
            $cert->delete();
            echo 'ok';
        }
    }
}
