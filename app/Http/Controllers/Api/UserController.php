<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends BaseApiController
{
    public function viewPublicProfile(string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function myProfile(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateMyProfile(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateProfileSummary(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateImmediateAvailableStatus(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function addToFavouriteCompany(string $company_slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function removeFromFavouriteCompany(string $company_slug): JsonResponse
    {
        return $this->notImplemented();
    }

    public function myFollowings(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function applicantMessageDetail(string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showProfileCvs(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileCvForm(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function storeProfileCv(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileCvEditForm(Request $request, string $user_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateFrontProfileCv(Request $request, string $id, string $user_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function deleteProfileCv(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showFrontProfileProjects(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showApplicantProfileProjects(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function uploadProjectTempImage(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileProjectForm(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function storeFrontProfileProject(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileProjectEditForm(Request $request, string $user_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateFrontProfileProject(Request $request, string $id, string $user_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function deleteProfileProject(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showFrontProfileExperience(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showApplicantProfileExperience(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileExperienceForm(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function storeFrontProfileExperience(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileExperienceEditForm(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateFrontProfileExperience(Request $request, string $profile_experience_id, string $user_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function deleteProfileExperience(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showFrontProfileEducation(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showApplicantProfileEducation(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileEducationForm(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function storeFrontProfileEducation(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileEducationEditForm(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateFrontProfileEducation(Request $request, string $education_id, string $user_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function deleteProfileEducation(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showProfileSkills(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showApplicantProfileSkills(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileSkillForm(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function storeFrontProfileSkill(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileSkillEditForm(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateFrontProfileSkill(Request $request, string $skill_id, string $user_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function deleteProfileSkill(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showProfileLanguages(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function showApplicantProfileLanguages(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileLanguageForm(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function storeFrontProfileLanguage(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function getFrontProfileLanguageEditForm(Request $request, string $id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function updateFrontProfileLanguage(Request $request, string $language_id, string $user_id): JsonResponse
    {
        return $this->notImplemented();
    }

    public function deleteProfileLanguage(Request $request): JsonResponse
    {
        return $this->notImplemented();
    }

    public function myAlerts(): JsonResponse
    {
        return $this->notImplemented();
    }

    public function delete_alert(string $id): JsonResponse
    {
        return $this->notImplemented();
    }
}
