<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\ServiceCategory;
use App\ServiceRequest;
use App\ServiceOption;
use App\State;
use App\City;
use Auth;
use Illuminate\Support\Facades\Schema;
use App\Services\MatchingService;

class HomeServiceController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->route()->defaults['type'] ?? 'service';
        $categories = ServiceCategory::where('type', $type)->active()->ordered()->get();
        $featuredServices = Service::whereHas('category', function ($q) use ($type) {
            $q->where('type', $type);
        })->active()->featured()->ordered()->limit(6)->get();
        $popularServices = Service::whereHas('category', function ($q) use ($type) {
            $q->where('type', $type);
        })->active()->orderBy('requests_count', 'desc')->limit(8)->get();

        return view('home_services.index', compact('categories', 'featuredServices', 'popularServices', 'type'));
    }

    public function category(Request $request, $slug)
    {
        $type = $request->route()->defaults['type'] ?? 'service';
        $category = ServiceCategory::where('category_slug', $slug)->where('type', $type)->where('is_active', 1)->firstOrFail();
        $services = Service::where('category_id', $category->id)->active()->ordered()->paginate(12);
        $categories = ServiceCategory::where('type', $type)->active()->ordered()->get();

        return view('home_services.category', compact('category', 'services', 'categories', 'type'));
    }

    public function show($slug)
    {
        $service = Service::with('category')->where('service_slug', $slug)->where('is_active', 1)->firstOrFail();
        $service->incrementViews();
        $type = $service->category->type;

        $relatedServices = Service::where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->active()
            ->limit(4)
            ->get();

        return view('home_services.show', compact('service', 'relatedServices', 'type'));
    }

    public function allServices(Request $request)
    {
        $type = $request->route()->defaults['type'] ?? 'service';
        $query = Service::active()->whereHas('category', function ($q) use ($type) {
            $q->where('type', $type);
        });

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('service_name', 'like', '%' . $request->search . '%')
                    ->orWhere('service_desc', 'like', '%' . $request->search . '%');
            });
        }

        $services = $query->ordered()->paginate(12);
        $categories = ServiceCategory::where('type', $type)->active()->ordered()->get();

        return view('home_services.all', compact('services', 'categories', 'type'));
    }

    public function requestForm($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Hizmet talep etmek için giriş yapmalısınız.');
        }

        // Restrict Candidates/Personnel/Caregivers
        $user = Auth::user();
        if ($user->isJobSeeker() || $user->isPersonnel() || $user->isCaregiver()) {
            return redirect()->route('home')->with('error', 'İş arayanlar, personel ve bakıcılar hizmet talebinde bulunamaz. Lütfen "Hizmet Alan" hesabınızla giriş yapın.');
        }

        $service = Service::where('service_slug', $slug)->where('is_active', 1)->firstOrFail();
        $states = State::where('country_id', 223)->active()->sorted()->get();

        return view('home_services.request', compact('service', 'states'));
    }

    public function getCities(Request $request)
    {
        $stateId = $request->input('state_id');
        $cities = City::where('state_id', $stateId)->active()->orderBy('city')->get();

        return response()->json($cities);
    }

    public function submitRequest(Request $request, $slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Hizmet talep etmek için giriş yapmalısınız.');
        }

        // Restrict Candidates/Personnel/Caregivers
        $user = Auth::user();
        if ($user->isJobSeeker() || $user->isPersonnel() || $user->isCaregiver()) {
            return redirect()->route('home')->with('error', 'İş arayanlar, personel ve bakıcılar hizmet talebinde bulunamaz. Lütfen "Hizmet Alan" hesabınızla giriş yapın.');
        }

        $this->validate($request, [
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'customer_city' => 'required|string|max:100',
            'customer_district' => 'required|string|max:100',
            'customer_neighborhood' => 'required|string|max:100',
            'customer_street' => 'required|string|max:100',
            'preferred_date' => 'nullable|date|after_or_equal:today',
            'preferred_time' => 'nullable',
            'customer_notes' => 'nullable|string|max:1000',
            'service_duration' => 'required|integer|min:1|max:24',
            'home_size' => 'nullable|string|max:50'
        ], [
            'customer_phone.required' => 'Telefon numarası zorunludur.',
            'customer_address.required' => 'Adres zorunludur.',
            'customer_city.required' => 'Şehir seçimi zorunludur.',
            'customer_district.required' => 'İlçe seçimi zorunludur.',
            'preferred_date.after_or_equal' => 'Tercih edilen tarih bugün veya sonrası olmalıdır.',
            'service_duration.required' => 'Hizmet süresi tahmini zorunludur.',
        ]);

        $service = Service::where('service_slug', $slug)->where('is_active', 1)->firstOrFail();

        $serviceRequest = new ServiceRequest();
        $serviceRequest->user_id = Auth::id();
        $serviceRequest->service_id = $service->id;
        $serviceRequest->request_number = ServiceRequest::generateRequestNumber();
        $serviceRequest->customer_phone = $request->customer_phone;
        $serviceRequest->customer_address = $request->customer_address;
        $serviceRequest->customer_city = $request->customer_city;
        $serviceRequest->customer_district = $request->customer_district;
        $serviceRequest->customer_neighborhood = $request->customer_neighborhood;
        $serviceRequest->customer_street = $request->customer_street;
        $serviceRequest->preferred_date = $request->preferred_date;
        $serviceRequest->preferred_time = $request->preferred_time;
        $serviceRequest->customer_notes = $request->customer_notes;
        $serviceRequest->service_duration = $request->service_duration;
        $serviceRequest->home_size = $request->home_size;
        $serviceRequest->status = 'pending';
        $serviceRequest->automation_status = 'pending_matching';
        $serviceRequest->save();

        $service->increment('requests_count');

        // Auto-match in background (synchronous, non-blocking on error)
        try {
            (new MatchingService())->runMatch($serviceRequest);
        } catch (\Exception $e) {
            \Log::error('HomeServiceController submitRequest matching error: ' . $e->getMessage());
        }

        return redirect()->route('home-services.my-requests')
            ->with('success', 'Hizmet talebiniz başarıyla oluşturuldu! Talep numaranız: ' . $serviceRequest->request_number);
    }

    public function myRequests()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Taleplerinizi görmek için giriş yapmalısınız.');
        }

        // Restrict Candidates/Personnel/Caregivers
        $user = Auth::user();
        if ($user->isJobSeeker() || $user->isPersonnel() || $user->isCaregiver()) {
            return redirect()->route('home')->with('error', 'Bu sayfaya erişim yetkiniz yok. Lütfen "Hizmet Alan" hesabınızla giriş yapın.');
        }

        $requests = ServiceRequest::with(['service', 'category', 'matchedPersonnel'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('home_services.my_requests', compact('requests'));
    }

    public function requestDetail($requestNumber)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Talep detaylarını görmek için giriş yapmalısınız.');
        }

        // Restrict Candidates/Personnel/Caregivers
        $user = Auth::user();
        if ($user->isJobSeeker() || $user->isPersonnel() || $user->isCaregiver()) {
            return redirect()->route('home')->with('error', 'Bu sayfaya erişim yetkiniz yok. Lütfen "Hizmet Alan" hesabınızla giriş yapın.');
        }

        $serviceRequest = ServiceRequest::with(['service.category', 'category', 'matchedPersonnel', 'assignedPersonnel'])
            ->where('request_number', $requestNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('home_services.request_detail', compact('serviceRequest'));
    }

    public function cancelRequest($requestNumber)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Yetkisiz erişim'], 401);
        }

        $serviceRequest = ServiceRequest::where('request_number', $requestNumber)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->firstOrFail();

        $serviceRequest->cancel();

        return response()->json([
            'success' => true,
            'message' => 'Talebiniz başarıyla iptal edildi.'
        ]);
    }

    public function wizard($type = 'service')
    {
        // Restrict Candidates/Personnel/Caregivers
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isJobSeeker() || $user->isPersonnel() || $user->isCaregiver()) {
                return redirect()->route('home')->with('error', 'İş arayanlar, personel ve bakıcılar hizmet talebinde bulunamaz. Lütfen "Hizmet Alan" hesabınızla giriş yapın.');
            }
        }
        $categories = ServiceCategory::where('type', $type)->active()->ordered()->get();
        \Log::info("Wizard Accessed. Type: $type. Categories Count: " . $categories->count());
        return view('home_services.wizard', compact('categories', 'type'));
    }

    public function getCategoryOptions(Request $request)
    {
        try {
            $categoryId = $request->input('category_id');
            \Log::info("getCategoryOptions Request for Category ID: " . $categoryId);

            $options = ServiceOption::where('category_id', $categoryId)->active()->orderBy('sort_order', 'asc')->get();

            $workingModes = $options->where('option_type', 'working_mode')->values();
            $attributes = $options->where('option_type', 'attribute')->values();

            $services = Service::where('category_id', $categoryId)->active()->ordered()->get();

            // Check if table exists before querying (defensive)
            $questions = collect([]);
            if (Schema::hasTable('service_questions')) {
                $questions = \App\ServiceQuestion::where('category_id', $categoryId)->orderBy('sort_order')->with('options')->get();
            }

            \Log::info("Found: services=" . $services->count() . ", workingModes=" . $workingModes->count() . ", questions=" . $questions->count());

            return response()->json([
                'success' => true,
                'working_modes' => $workingModes,
                'attributes' => $attributes,
                'services' => $services,
                'questions' => $questions
            ]);
        } catch (\Exception $e) {
            \Log::error("Wizard Error: " . $e->getMessage() . " Line: " . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Veri hatası: ' . $e->getMessage()], 500);
        }
    }

    public function submitWizard(Request $request)
    {
        // Restrict Candidates/Personnel/Caregivers
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isJobSeeker() || $user->isPersonnel() || $user->isCaregiver()) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'İş arayanlar hizmet talebinde bulunamaz.'], 403);
                }
                return redirect()->route('home')->with('error', 'İş arayanlar, personel ve bakıcılar hizmet talebinde bulunamaz.');
            }
        }
        // 1. Validation
        $this->validate($request, [
            'category_id' => 'required|exists:service_categories,id',
            'customer_phone' => 'required|string|max:20',
            'customer_city' => 'required|string',
            'customer_district' => 'required|string',
            'customer_neighborhood' => 'required|string',
            'customer_street' => 'required|string',
            'customer_address' => 'required|string|max:500',
            'preferred_date' => 'required|date|after_or_equal:today',
        ], [
            'preferred_date.required' => 'Lütfen bir tarih seçiniz.',
            'preferred_date.after_or_equal' => 'Geçmiş bir tarih seçemezsiniz.',
        ]);

        // 2. Create Request (Works for Guest & Auth)
        $userId = Auth::check() ? Auth::id() : null;

        $serviceRequest = new ServiceRequest();
        $serviceRequest->user_id = $userId;
        $serviceRequest->category_id = $request->category_id;
        $serviceRequest->service_id = $request->input('service_id');
        $serviceRequest->request_number = ServiceRequest::generateRequestNumber();
        $serviceRequest->customer_phone = $request->customer_phone;
        $serviceRequest->customer_address = $request->customer_address;
        $serviceRequest->customer_city = $request->customer_city;
        $serviceRequest->customer_district = $request->customer_district;
        $serviceRequest->customer_neighborhood = $request->customer_neighborhood;
        $serviceRequest->customer_street = $request->customer_street;
        $serviceRequest->preferred_date = $request->preferred_date;
        $serviceRequest->preferred_time = $request->preferred_time;

        // Extra details as JSON
        $extraData = [
            'working_mode' => $request->input('working_mode_name'),
            'attributes' => $request->input('attributes', []),
            'notes' => $request->input('customer_notes'),
            'type' => $request->input('type')
        ];

        // Handle Dynamic Questions
        $questions = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'question_') === 0) {
                $qId = str_replace('question_', '', $key);
                $questions[$qId] = $value;
            }
        }
        if (!empty($questions)) {
            $extraData['dynamic_questions'] = $questions;
        }

        $serviceRequest->extra_details = json_encode($extraData);
        $serviceRequest->status = 'pending';
        $serviceRequest->automation_status = 'pending_matching';
        $serviceRequest->save();

        if (!empty($serviceRequest->service_id)) {
            $service = Service::find($serviceRequest->service_id);
            if ($service)
                $service->increment('requests_count');
        }

        // Auto-match (only for logged-in users; guest requests matched after registration)
        if (Auth::check()) {
            try {
                (new MatchingService())->runMatch($serviceRequest);
            } catch (\Exception $e) {
                \Log::error('HomeServiceController submitWizard matching error: ' . $e->getMessage());
            }
        }

        // 3. Response handling
        if (Auth::check()) {
            return response()->json([
                'success' => true,
                'message' => 'Talebiniz başarıyla alındı. No: ' . $serviceRequest->request_number,
                'redirect' => route('home-services.my-requests')
            ]);
        } else {
            // Guest User - Store ID to link later
            session(['guest_service_request_id' => $serviceRequest->id]);

            return response()->json([
                'success' => false, // Keep false to trigger "Auth Required" modal flow or redirect
                'require_auth' => true,
                'redirect' => route('member.register'),
                'message' => 'Talebiniz tarafımıza iletilmiştir. Takibi için lütfen üye olunuz.'
            ]);
        }
    }

    /**
     * Helper to create service request from data
     */
    public static function createServiceRequestForUser($user, $data)
    {
        // Extract data (handle both array and Request object if needed, but here simple array)
        // If data comes from session it's array, if from request it's object (but we passed $request->all())

        $data = (array) $data; // Ensure array

        $serviceRequest = new ServiceRequest();
        $serviceRequest->user_id = $user->id;
        $serviceRequest->category_id = $data['category_id'];
        $serviceRequest->service_id = $data['service_id'] ?? null;
        $serviceRequest->request_number = ServiceRequest::generateRequestNumber();
        $serviceRequest->customer_phone = $data['customer_phone'];
        $serviceRequest->customer_address = $data['customer_address'];
        $serviceRequest->customer_city = $data['customer_city'];
        $serviceRequest->customer_district = $data['customer_district'];
        $serviceRequest->customer_neighborhood = $data['customer_neighborhood'] ?? null;
        $serviceRequest->customer_street = $data['customer_street'] ?? null;
        $serviceRequest->preferred_date = $data['preferred_date'];
        $serviceRequest->preferred_time = $data['preferred_time'] ?? null;

        // Extra details as JSON
        $extraData = [
            'working_mode' => $data['working_mode_name'] ?? null,
            'attributes' => $data['attributes'] ?? [],
            'notes' => $data['customer_notes'] ?? null,
            'type' => $data['type'] ?? 'service'
        ];

        // Handle Dynamic Questions
        // Logic to extract question_* fields
        $questions = [];
        foreach ($data as $key => $value) {
            if (strpos($key, 'question_') === 0) {
                $qId = str_replace('question_', '', $key);
                $questions[$qId] = $value;
            }
        }
        if (!empty($questions)) {
            $extraData['dynamic_questions'] = $questions;
        }

        $serviceRequest->extra_details = json_encode($extraData);
        $serviceRequest->status = 'pending';
        $serviceRequest->automation_status = 'pending_matching';
        $serviceRequest->save();

        // Increment service count if service_id exists
        if (!empty($serviceRequest->service_id)) {
            $service = Service::find($serviceRequest->service_id);
            if ($service)
                $service->increment('requests_count');
        }

        // Auto-match after user links (called from RegisterController after registration)
        try {
            (new MatchingService())->runMatch($serviceRequest);
        } catch (\Exception $e) {
            \Log::error('HomeServiceController createServiceRequestForUser matching error: ' . $e->getMessage());
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Talebiniz başarıyla alındı. No: ' . $serviceRequest->request_number,
                'redirect' => route('home-services.my-requests')
            ]);
        } else {
            // For controller calls from Register/Login
            return $serviceRequest;
        }
    }
}
