<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Job;
use App\Company;
use App\User;
use App\JobApply;
use App\City;
use App\FunctionalArea;
use App\Industry;
use App\JobType;
use App\Service;
use App\ServiceRequest;
use App\ServiceCategory;
use Carbon\Carbon;
use DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Ana raporlama dashboard'u
     */
    public function index()
    {
        // Genel istatistikleri optimize edilmiş tekil sorgularla al
        $jobStats = Job::selectRaw('COUNT(*) as total, SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active')->first();
        $companyStats = Company::selectRaw('COUNT(*) as total, SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active')->first();
        $userStats = User::selectRaw('COUNT(*) as total, SUM(CASE WHEN verified = 1 THEN 1 ELSE 0 END) as verified')->first();
        $applyStats = JobApply::selectRaw('COUNT(*) as total, SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending')->first();

        $stats = [
            'total_jobs' => $jobStats->total,
            'active_jobs' => $jobStats->active,
            'total_companies' => $companyStats->total,
            'active_companies' => $companyStats->active,
            'total_users' => $userStats->total,
            'verified_users' => $userStats->verified,
            'total_applications' => $applyStats->total,
            'pending_applications' => $applyStats->pending,
        ];

        // Son 30 günlük iş ilanı trendi
        $jobTrend = Job::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Son 30 günlük başvuru trendi
        $applicationTrend = JobApply::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Türkiye'ye ait state_id'leri al
        $turkeyStateIds = DB::table('states')->where('lang', 'tr')->whereIn('country_id', [223, 805])->pluck('state_id');

        // Şehirlere (İllere) göre iş ilanları (Sadece Türkiye)
        $jobsByCity = Job::select('cities.state_id', 'states.state as city_name', DB::raw('count(*) as count'))
            ->join('cities', function ($join) {
                $join->on('jobs.city_id', '=', 'cities.city_id')
                    ->where('cities.lang', '=', 'tr');
            })
            ->join('states', function ($join) {
                $join->on('cities.state_id', '=', 'states.state_id')
                    ->where('states.lang', '=', 'tr');
            })
            ->whereIn('cities.state_id', $turkeyStateIds)
            ->where('jobs.is_active', 1)
            ->groupBy('cities.state_id', 'states.state')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        // İş alanlarına göre ilanlar (Türkçe isimlerle)
        $jobsByArea = Job::select('jobs.functional_area_id', 'functional_areas.functional_area as area_name', DB::raw('count(*) as count'))
            ->join('functional_areas', function ($join) {
                $join->on('jobs.functional_area_id', '=', 'functional_areas.functional_area_id')
                    ->where('functional_areas.lang', '=', 'tr');
            })
            ->where('jobs.is_active', 1)
            ->groupBy('jobs.functional_area_id', 'functional_areas.functional_area')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact('stats', 'jobTrend', 'applicationTrend', 'jobsByCity', 'jobsByArea'));
    }

    /**
     * İş ilanları raporu
     */
    public function jobs(Request $request)
    {
        $query = Job::with(['company:id,name', 'city:city_id,city', 'functionalArea:functional_area_id,functional_area', 'jobType:job_type_id,job_type']);

        // Filter by Date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Filter by City (İl/Şehir - state_id üzerinden filtreleme)
        if ($request->filled('state_id')) {
            $cityIdsInState = DB::table('cities')->where('state_id', $request->state_id)->where('lang', 'tr')->pluck('city_id');
            $query->whereIn('city_id', $cityIdsInState);
        }

        // Filter by Functional Area
        if ($request->filled('functional_area_id')) {
            $query->where('functional_area_id', $request->functional_area_id);
        }

        // Filter by Job Type
        if ($request->filled('job_type_id')) {
            $query->where('job_type_id', $request->job_type_id);
        }

        // Filter by Company
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // Filter by Featured Status
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }

        // Clone query for accurate statistics based on filters
        $stats = (clone $query)->reorder()
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactive,
                SUM(CASE WHEN is_featured = 1 THEN 1 ELSE 0 END) as featured
            ')->toBase()->first();

        $totalStats = [
            'total' => $stats->total ?? 0,
            'active' => $stats->active ?? 0,
            'inactive' => $stats->inactive ?? 0,
            'featured' => $stats->featured ?? 0,
        ];

        $jobs = $query->orderBy('created_at', 'desc')->paginate(25)->appends($request->all());

        // Optimized filter data - İller (Provinces)
        $turkeyStateIds = DB::table('states')->where('lang', 'tr')->whereIn('country_id', [223, 805])->pluck('state_id');
        $states = DB::table('states')->where('lang', 'tr')->whereIn('state_id', $turkeyStateIds)->select('state_id', 'state')->orderBy('state')->get();
        $functionalAreas = FunctionalArea::where('lang', 'tr')->select('functional_area_id', 'functional_area')->orderBy('functional_area')->get();
        $jobTypes = JobType::where('lang', 'tr')->where('job_type', '!=', '')->select('job_type_id', 'job_type')->get();
        $companies = Company::where('is_active', 1)->select('id', 'name')->orderBy('name')->get();

        return view('admin.reports.jobs', compact('jobs', 'totalStats', 'states', 'functionalAreas', 'jobTypes', 'companies'));
    }

    /**
     * Şirketler raporu
     */
    public function companies(Request $request)
    {
        $query = Company::query();

        // Filter by Date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Filter by Verified Status
        if ($request->filled('verified')) {
            $query->where('verified', $request->verified);
        }

        // Filter by City (İl/Şehir - state_id üzerinden filtreleme)
        if ($request->filled('state_id')) {
            $cityIdsInState = DB::table('cities')->where('state_id', $request->state_id)->where('lang', 'tr')->pluck('city_id');
            $query->whereIn('city_id', $cityIdsInState);
        }

        // Filter by Industry
        if ($request->filled('industry_id')) {
            $query->where('industry_id', $request->industry_id);
        }

        // Clone query for statistics (Use base selection to avoid withCount pollution)
        $stats = (clone $query)->reorder()
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN verified = 1 THEN 1 ELSE 0 END) as verified
            ')->toBase()->first();

        $totalStats = [
            'total' => $stats->total ?? 0,
            'active' => $stats->active ?? 0,
            'verified' => $stats->verified ?? 0,
            'with_jobs' => (clone $query)->has('jobs')->count(),
        ];

        // Apply relations and withCount ONLY for the list view
        $companies = $query->with(['city:city_id,city', 'industry:id,industry'])->withCount([
            'jobs',
            'jobs as active_jobs_count' => function ($q) {
                $q->where('is_active', 1);
            }
        ])->orderBy('created_at', 'desc')->paginate(25)->appends($request->all());

        // Optimized filter data - İller (Provinces)
        $turkeyStateIds = DB::table('states')->where('lang', 'tr')->whereIn('country_id', [223, 805])->pluck('state_id');
        $states = DB::table('states')->where('lang', 'tr')->whereIn('state_id', $turkeyStateIds)->select('state_id', 'state')->orderBy('state')->get();
        $industries = Industry::where('lang', 'tr')->where('is_active', 1)->select('industry_id', 'industry')->orderBy('industry')->get();

        return view('admin.reports.companies', compact('companies', 'totalStats', 'states', 'industries'));
    }

    /**
     * Başvurular raporu
     */
    public function applications(Request $request)
    {
        $query = JobApply::with(['job', 'user', 'job.company']);

        // Tarih filtresi
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Durum filtresi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Şirket filtresi
        if ($request->filled('company_id')) {
            $query->whereHas('job', function ($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(50);

        // İstatistikleri optimize et
        $stats = $query->reorder()->selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = "shortlisted" THEN 1 ELSE 0 END) as shortlisted,
            SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN status = "hired" THEN 1 ELSE 0 END) as hired
        ')->first();

        $totalStats = [
            'total' => $stats->total ?? 0,
            'pending' => $stats->pending ?? 0,
            'shortlisted' => $stats->shortlisted ?? 0,
            'rejected' => $stats->rejected ?? 0,
            'hired' => $stats->hired ?? 0,
        ];

        // Filtre seçenekleri
        $companies = Company::where('is_active', 1)->orderBy('name')->get();

        return view('admin.reports.applications', compact('applications', 'totalStats', 'companies'));
    }

    /**
     * İş ilanları PDF/Excel export
     */
    public function exportJobs(Request $request)
    {
        $format = $request->get('format', 'excel');

        if ($format === 'pdf') {
            return $this->exportJobsPdf($request);
        }

        // Build query for Excel export
        $query = Job::with(['company', 'city', 'functionalArea', 'jobType']);

        // Aynı filtreler
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }
        if ($request->filled('functional_area_id')) {
            $query->where('functional_area_id', $request->functional_area_id);
        }
        if ($request->filled('job_type_id')) {
            $query->where('job_type_id', $request->job_type_id);
        }
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }

        $jobs = $query->orderBy('created_at', 'desc')->get();

        return $this->exportJobsExcel($jobs);
    }

    /**
     * Şirketler PDF/Excel export
     */
    public function exportCompanies(Request $request)
    {
        $format = $request->get('format', 'excel');

        if ($format === 'pdf') {
            return $this->exportCompaniesPdf($request);
        }

        // Build query for Excel export
        $query = Company::withCount('jobs');

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
        if ($request->filled('verified')) {
            $query->where('verified', $request->verified);
        }
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }
        if ($request->filled('industry_id')) {
            $query->where('industry_id', $request->industry_id);
        }

        $companies = $query->orderBy('created_at', 'desc')->get();

        return $this->exportCompaniesExcel($companies);
    }

    /**
     * Başvurular PDF/Excel export
     */
    public function exportApplications(Request $request)
    {
        $query = JobApply::with(['job', 'user', 'job.company']);

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->orderBy('created_at', 'desc')->get();

        $format = $request->get('format', 'excel');

        if ($format === 'pdf') {
            return $this->exportApplicationsPdf($request);
        }

        return $this->exportApplicationsExcel($applications);
    }

    /**
     * Excel export - İş İlanları
     */
    private function exportJobsExcel($jobs)
    {
        $filename = 'is_ilanlari_raporu_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($jobs) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Başlıklar - noktalı virgül ayraç
            fputcsv($file, [
                'ID',
                'Ilan Basligi',
                'Sirket',
                'Sehir',
                'Is Alani',
                'Is Turu',
                'Maas Min',
                'Maas Max',
                'Durum',
                'One Cikan',
                'Olusturulma Tarihi',
                'Son Gecerlilik'
            ], ';');

            foreach ($jobs as $job) {
                fputcsv($file, [
                    $job->id,
                    $job->title,
                    $job->company->name ?? '-',
                    $job->city->city ?? '-',
                    $job->functionalArea->functional_area ?? '-',
                    $job->jobType->job_type ?? '-',
                    $job->salary_from,
                    $job->salary_to,
                    $job->is_active ? __('Aktif') : __('Pasif'),
                    $job->is_featured ? __('Evet') : __('Hayir'),
                    $job->created_at->format('d.m.Y H:i'),
                    $job->expiry_date ? Carbon::parse($job->expiry_date)->format('d.m.Y') : '-',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Excel export - Şirketler
     */
    private function exportCompaniesExcel($companies)
    {
        $filename = 'sirketler_raporu_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($companies) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'ID',
                'Sirket Adi',
                'E-posta',
                'Telefon',
                'Sehir',
                'Sektor',
                'Ilan Sayisi',
                'Durum',
                'Dogrulanmis',
                'Kayit Tarihi'
            ], ';');

            foreach ($companies as $company) {
                fputcsv($file, [
                    $company->id,
                    $company->name,
                    $company->email,
                    $company->phone ?? '-',
                    $company->city->city ?? '-',
                    $company->industry->industry ?? '-',
                    $company->jobs_count ?? 0,
                    $company->is_active ? __('Aktif') : __('Pasif'),
                    $company->verified ? __('Evet') : __('Hayir'),
                    $company->created_at->format('d.m.Y H:i'),
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Excel export - Başvurular
     */
    private function exportApplicationsExcel($applications)
    {
        $filename = 'basvurular_raporu_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($applications) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'ID',
                'Aday Adi',
                'E-posta',
                'Ilan Basligi',
                'Sirket',
                'Durum',
                'Basvuru Tarihi'
            ], ';');

            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->id,
                    $app->user->name ?? '-',
                    $app->user->email ?? '-',
                    $app->job->title ?? '-',
                    $app->job->company->name ?? '-',
                    $this->getStatusLabel($app->status),
                    $app->created_at->format('d.m.Y H:i'),
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * PDF export - İş İlanları
     */
    private function exportJobsPdf($jobs)
    {
        $html = view('admin.reports.exports.jobs_pdf', compact('jobs'))->render();

        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * PDF export - Şirketler
     */
    private function exportCompaniesPdf($companies)
    {
        $html = view('admin.reports.exports.companies_pdf', compact('companies'))->render();

        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * PDF export - Başvurular
     */
    private function exportApplicationsPdf(Request $request)
    {
        $query = JobApply::with(['job', 'user', 'job.company']);

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->orderBy('created_at', 'desc')->get();
        $html = view('admin.reports.exports.applications_pdf', compact('applications'))->render();

        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * Durum etiketi
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => __('Beklemede'),
            'shortlisted' => __('Ön Eleme Geçti'),
            'rejected' => __('Reddedildi'),
            'hired' => __('İşe Alındı'),
        ];

        return $labels[$status] ?? $status;
    }

    /**
     * Hizmetler raporu
     */
    public function services(Request $request)
    {
        $query = Service::with(['category']);

        // Tarih filtresi
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Durum filtresi
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Kategori filtresi
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $services = $query->orderBy('created_at', 'desc')->paginate(50);

        // İstatistikleri optimize et
        $stats = Service::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN is_featured = 1 THEN 1 ELSE 0 END) as featured
        ')->first();

        $totalStats = [
            'total' => $stats->total ?? 0,
            'active' => $stats->active ?? 0,
            'featured' => $stats->featured ?? 0,
            'total_requests' => ServiceRequest::count(),
        ];

        // Filtre seçenekleri
        $categories = ServiceCategory::where('is_active', 1)->orderBy('category_name')->get();

        return view('admin.reports.services', compact('services', 'totalStats', 'categories'));
    }

    /**
     * Hizmet talepleri raporu
     */
    public function serviceRequests(Request $request)
    {
        $query = ServiceRequest::with(['service', 'user']);

        // Tarih filtresi
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Durum filtresi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Hizmet filtresi
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(50);

        // İstatistikleri optimize et
        $stats = ServiceRequest::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress,
            SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled
        ')->first();

        $totalStats = [
            'total' => $stats->total ?? 0,
            'pending' => $stats->pending ?? 0,
            'approved' => $stats->approved ?? 0,
            'in_progress' => $stats->in_progress ?? 0,
            'completed' => $stats->completed ?? 0,
            'cancelled' => $stats->cancelled ?? 0,
        ];

        // Filtre seçenekleri
        $servicesList = Service::where('is_active', 1)->orderBy('service_name')->get();

        return view('admin.reports.service_requests', compact('requests', 'totalStats', 'servicesList'));
    }

    /**
     * Hizmetler Excel export
     */
    public function exportServices(Request $request)
    {
        $query = Service::with(['category']);

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $services = $query->orderBy('created_at', 'desc')->get();

        $format = $request->get('format', 'excel');

        if ($format === 'pdf') {
            return $this->exportServicesPdf($request);
        }

        return $this->exportServicesExcel($services);
    }

    /**
     * Hizmet talepleri Excel export
     */
    public function exportServiceRequests(Request $request)
    {
        $query = ServiceRequest::with(['service', 'user']);

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->orderBy('created_at', 'desc')->get();

        $format = $request->get('format', 'excel');

        if ($format === 'pdf') {
            return $this->exportServiceRequestsPdf($request);
        }

        return $this->exportServiceRequestsExcel($requests);
    }

    /**
     * Excel export - Hizmetler
     */
    private function exportServicesExcel($services)
    {
        $filename = 'hizmetler_raporu_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($services) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'ID',
                'Hizmet Adi',
                'Kategori',
                'Fiyat',
                'Sure (dk)',
                'Talep Sayisi',
                'Goruntulenme',
                'Durum',
                'One Cikan',
                'Olusturulma Tarihi'
            ], ';');

            foreach ($services as $service) {
                fputcsv($file, [
                    $service->id,
                    $service->service_name,
                    $service->category->category_name ?? '-',
                    $service->price ?? 0,
                    $service->duration_minutes ?? '-',
                    $service->requests_count ?? 0,
                    $service->views_count ?? 0,
                    $service->is_active ? __('Aktif') : __('Pasif'),
                    $service->is_featured ? __('Evet') : __('Hayir'),
                    $service->created_at ? $service->created_at->format('d.m.Y H:i') : '-',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Excel export - Hizmet Talepleri
     */
    private function exportServiceRequestsExcel($requests)
    {
        $filename = 'hizmet_talepleri_raporu_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($requests) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Talep No',
                'Musteri',
                'Telefon',
                'Hizmet',
                'Adres',
                'Tercih Edilen Tarih',
                'Tercih Edilen Saat',
                'Durum',
                'Fiyat',
                'Talep Tarihi'
            ], ';');

            foreach ($requests as $req) {
                fputcsv($file, [
                    $req->request_number ?? '-',
                    $req->user->name ?? '-',
                    $req->customer_phone ?? '-',
                    $req->service->service_name ?? '-',
                    $req->customer_address ?? '-',
                    $req->preferred_date ? Carbon::parse($req->preferred_date)->format('d.m.Y') : '-',
                    $req->preferred_time ?? '-',
                    $req->getStatusLabel(),
                    $req->final_price ?? '-',
                    $req->created_at ? $req->created_at->format('d.m.Y H:i') : '-',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * PDF export - Hizmetler
     */
    private function exportServicesPdf(Request $request)
    {
        $query = Service::with(['category']);

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $services = $query->orderBy('created_at', 'desc')->get();
        $html = view('admin.reports.exports.services_pdf', compact('services'))->render();

        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * PDF export - Hizmet Talepleri
     */
    private function exportServiceRequestsPdf(Request $request)
    {
        $query = ServiceRequest::with(['service', 'user']);

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->orderBy('created_at', 'desc')->get();
        $html = view('admin.reports.exports.service_requests_pdf', compact('requests'))->render();

        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * Mail gönderme testi
     */
    public function testMail()
    {
        $to = "kopserx53@gmail.com"; // Kullanıcının isteği üzerine güncellendi
        $subject = "Sistem Mail Testi - " . date('d.m.Y H:i');
        $message = "Bu bir test e-postasıdır. Eğer bu maili alıyorsanız, sistem mail ayarları doğru demektir.\n\n" .
            "Alıcı: " . $to . "\n" .
            "Zaman: " . date('d.m.Y H:i:s');

        try {
            \Mail::raw($message, function ($msg) use ($to, $subject) {
                $msg->to($to)->subject($subject);
            });
            return redirect()->route('admin.reports.index')->with('success_message', 'Test maili başarıyla gönderildi: ' . $to);
        } catch (\Exception $e) {
            return redirect()->route('admin.reports.index')->with('error_message', 'Mail gönderilemedi: ' . $e->getMessage());
        }
    }
}
