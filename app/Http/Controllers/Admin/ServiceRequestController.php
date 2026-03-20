<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\ServiceRequest;
use App\Service;
use App\User;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Base
{
    private function isCaregiverRequest(ServiceRequest $serviceRequest, ?Request $request = null): bool
    {
        $requestedType = $request ? $request->input('type') : null;
        if ($requestedType === 'caregiver') {
            return true;
        }

        if ($serviceRequest->category && $serviceRequest->category->type === 'caregiver') {
            return true;
        }

        if ($serviceRequest->service && $serviceRequest->service->category && $serviceRequest->service->category->type === 'caregiver') {
            return true;
        }

        $extraDetails = json_decode((string) $serviceRequest->extra_details, true);
        return is_array($extraDetails) && (($extraDetails['type'] ?? null) === 'caregiver');
    }

    private function hasAnyAdminPermission(array $permissions): bool
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return false;
        }

        if ($admin->hasRole('SUPER_ADMIN')) {
            return true;
        }

        foreach ($permissions as $permission) {
            if ($admin->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    private function canManageServiceRequests(): bool
    {
        return $this->hasAnyAdminPermission(['manage_service_requests', 'manage_services']);
    }

    public function index(Request $request)
    {
        $type = $request->input('type', 'service');
        $query = ServiceRequest::with(['user', 'service.category', 'category'])
            ->where(function ($q) use ($type) {
                $q->whereHas('service.category', function ($sq) use ($type) {
                    $sq->where('type', $type);
                })
                    ->orWhereHas('category', function ($cq) use ($type) {
                        $cq->where('type', $type);
                    });
            });

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('service_id') && $request->service_id != '') {
            $query->where('service_id', $request->service_id);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);
        $services = Service::whereHas('category', function ($q) use ($type) {
            $q->where('type', $type);
        })->active()->ordered()->get();
        $statusLabels = ServiceRequest::getStatusLabels();

        return view('admin.service_requests.index', compact('requests', 'services', 'statusLabels', 'type'));
    }

    public function show($id)
    {
        $serviceRequest = ServiceRequest::with(['user', 'service.category', 'matchedPersonnel'])->findOrFail($id);
        $statusLabels = ServiceRequest::getStatusLabels();
        $statusColors = ServiceRequest::getStatusColors();

        // Load candidates for the auto-matching panel
        try {
            $matchingService = new \App\Services\MatchingService();
            $candidates = $matchingService->findCandidates($serviceRequest);
        } catch (\Exception $e) {
            $candidates = collect([]);
            \Log::error('ServiceRequestController::show candidates error: ' . $e->getMessage());
        }

        return view('admin.service_requests.show', compact('serviceRequest', 'statusLabels', 'statusColors', 'candidates'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|in:pending,approved,in_progress,completed,cancelled',
            'admin_notes' => 'nullable|string',
            'final_price' => 'nullable|numeric|min:0'
        ], [
            'status.required' => __('Durum seçimi zorunludur.'),
            'status.in' => __('Geçersiz durum seçimi.'),
            'final_price.numeric' => __('Son fiyat sayısal bir değer olmalıdır.'),
            'final_price.min' => __('Son fiyat negatif olamaz.'),
        ]);

        $serviceRequest = ServiceRequest::with(['category', 'service.category'])->findOrFail($id);

        // Permission Check
        $isCaregiver = $this->isCaregiverRequest($serviceRequest, $request);

        if ($request->status == 'approved') {
            $perm = $isCaregiver ? 'approve_caregiver_requests' : 'approve_service_requests';
            if (!$this->hasAnyAdminPermission([$perm, 'manage_service_requests', 'manage_services'])) {
                flash(__('Bu işlem için yetkiniz bulunmamaktadır.'))->error();
                return redirect()->back();
            }
        } else {
            $perm = $isCaregiver ? 'manage_caregiver_request_status' : 'manage_service_request_status';
            if (!$this->hasAnyAdminPermission([$perm, 'manage_service_requests', 'manage_services'])) {
                flash(__('Bu işlem için yetkiniz bulunmamaktadır.'))->error();
                return redirect()->back();
            }
        }

        $oldStatus = $serviceRequest->status;
        $serviceRequest->status = $request->status;

        if ($request->has('admin_notes')) {
            $serviceRequest->admin_notes = $request->admin_notes;
        }

        if ($request->has('final_price')) {
            $serviceRequest->final_price = $request->final_price;
        }

        if ($request->status == 'approved' && $oldStatus != 'approved') {
            $serviceRequest->approved_at = now();
        }

        if ($request->status == 'completed' && $oldStatus != 'completed') {
            $serviceRequest->completed_at = now();
        }

        $serviceRequest->save();

        flash(__('Talep durumu başarıyla güncellendi!'))->success();

        return redirect()->route('admin.service-requests.show', $id);
    }

    public function approve($id)
    {
        $serviceRequest = ServiceRequest::with(['category', 'service.category'])->findOrFail($id);

        // Permission Check
        $isCaregiver = $this->isCaregiverRequest($serviceRequest);
        $perm = $isCaregiver ? 'approve_caregiver_requests' : 'approve_service_requests';

        if (!$this->hasAnyAdminPermission([$perm, 'manage_service_requests', 'manage_services'])) {
            return response()->json([
                'success' => false,
                'message' => __('Bu işlem için yetkiniz bulunmamaktadır.')
            ], 403);
        }

        $serviceRequest->approve();

        return response()->json([
            'success' => true,
            'message' => __('Talep onaylandı!'),
            'status' => $serviceRequest->status,
            'status_label' => $serviceRequest->getStatusLabel()
        ]);
    }

    public function complete($id)
    {
        $serviceRequest = ServiceRequest::with(['category', 'service.category'])->findOrFail($id);

        // Permission Check
        $isCaregiver = $this->isCaregiverRequest($serviceRequest);
        $perm = $isCaregiver ? 'manage_caregiver_request_status' : 'manage_service_request_status';

        if (!$this->hasAnyAdminPermission([$perm, 'manage_service_requests', 'manage_services'])) {
            return response()->json([
                'success' => false,
                'message' => __('Bu işlem için yetkiniz bulunmamaktadır.')
            ], 403);
        }

        $serviceRequest->complete();

        return response()->json([
            'success' => true,
            'message' => __('Talep tamamlandı!'),
            'status' => $serviceRequest->status,
            'status_label' => $serviceRequest->getStatusLabel()
        ]);
    }

    public function cancel($id)
    {
        $serviceRequest = ServiceRequest::with(['category', 'service.category'])->findOrFail($id);

        // Permission Check
        $isCaregiver = $this->isCaregiverRequest($serviceRequest);
        $perm = $isCaregiver ? 'manage_caregiver_request_status' : 'manage_service_request_status';

        if (!$this->hasAnyAdminPermission([$perm, 'manage_service_requests', 'manage_services'])) {
            return response()->json([
                'success' => false,
                'message' => __('Bu işlem için yetkiniz bulunmamaktadır.')
            ], 403);
        }

        $serviceRequest->cancel();

        return response()->json([
            'success' => true,
            'message' => __('Talep iptal edildi!'),
            'status' => $serviceRequest->status,
            'status_label' => $serviceRequest->getStatusLabel()
        ]);
    }

    public function destroy($id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->delete();

        return response()->json([
            'success' => true,
            'message' => __('Talep başarıyla silindi!')
        ]);
    }

    public function statistics()
    {
        $stats = [
            'total' => ServiceRequest::count(),
            'pending' => ServiceRequest::pending()->count(),
            'approved' => ServiceRequest::approved()->count(),
            'completed' => ServiceRequest::completed()->count(),
            'cancelled' => ServiceRequest::where('status', 'cancelled')->count(),
            'today' => ServiceRequest::whereDate('created_at', today())->count(),
            'this_week' => ServiceRequest::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => ServiceRequest::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
        ];

        return response()->json($stats);
    }

    public function searchPersonnel(Request $request)
    {
        if (!$this->canManageServiceRequests()) {
            return response()->json(['error' => __('Bu işlem için yetkiniz bulunmamaktadır.')], 403);
        }

        $query = $request->input('q');

        $users = User::where(function ($q) use ($query) {
            $q->where('email', 'like', '%' . $query . '%')
                ->orWhere('first_name', 'like', '%' . $query . '%')
                ->orWhere('last_name', 'like', '%' . $query . '%');
        })
            ->whereIn('user_type', [User::TYPE_PERSONNEL, User::TYPE_CAREGIVER])
            ->where('is_active', 1)
            ->limit(10)
            ->get()
            ->map(function ($user) {
                $image = $user->image ? asset('uploads/user_images/' . $user->image) : asset('admin_assets/no-image.png');
                $roleLabel = ($user->user_type == 'personnel') ? 'Hizmet Personeli' : 'Bakıcı';
                return [
                    'id' => $user->id,
                    'name' => $user->getName() ?: $user->email,
                    'email' => $user->email,
                    'image' => $image,
                    'role' => $roleLabel
                ];
            });

        return response()->json($users);
    }

    public function assignPersonnel(Request $request, $id)
    {
        if (!$this->canManageServiceRequests()) {
            return response()->json([
                'success' => false,
                'message' => __('Bu işlem için yetkiniz bulunmamaktadır.')
            ], 403);
        }

        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $serviceRequest = ServiceRequest::findOrFail($id);
        $userId = (int) $request->input('user_id');
        $personnel = User::where('id', $userId)
            ->whereIn('user_type', [User::TYPE_PERSONNEL, User::TYPE_CAREGIVER])
            ->where('is_active', 1)
            ->first();

        if (!$personnel) {
            return response()->json([
                'success' => false,
                'message' => __('Seçilen kullanıcı aktif personel/bakıcı değil.')
            ], 422);
        }

        if ($serviceRequest->assignedPersonnel()->where('user_id', $userId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => __('Bu personel zaten atanmış!')
            ]);
        }

        $serviceRequest->assignedPersonnel()->attach($userId, ['assigned_at' => now()]);
        $serviceRequest->matched_personnel_id = $userId;
        if (empty($serviceRequest->automation_status) || in_array($serviceRequest->automation_status, ['pending_matching', 'failed'], true)) {
            $serviceRequest->automation_status = 'matched';
        }
        $serviceRequest->save();

        return response()->json([
            'success' => true,
            'message' => __('Personel başarıyla atandı!')
        ]);
    }

    public function removePersonnel(Request $request, $id)
    {
        if (!$this->canManageServiceRequests()) {
            return response()->json([
                'success' => false,
                'message' => __('Bu işlem için yetkiniz bulunmamaktadır.')
            ], 403);
        }

        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $serviceRequest = ServiceRequest::findOrFail($id);
        $userId = (int) $request->input('user_id');

        $serviceRequest->assignedPersonnel()->detach($userId);
        if ((int) $serviceRequest->matched_personnel_id === $userId) {
            $serviceRequest->matched_personnel_id = null;
            if (in_array($serviceRequest->automation_status, ['matched', 'accepted'], true)) {
                $serviceRequest->automation_status = 'pending_matching';
            }
            $serviceRequest->save();
        }

        return response()->json([
            'success' => true,
            'message' => __('Personel başarıyla kaldırıldı!')
        ]);
    }
}







