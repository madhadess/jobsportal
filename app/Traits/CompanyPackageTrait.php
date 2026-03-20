<?php



namespace App\Traits;



use DB;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

use App\Company;



trait CompanyPackageTrait
{



    public function addCompanyPackage($company, $package, $method = '')
    {

        $now = Carbon::now();

        $company->package_id = $package->id;

        $company->package_start_date = $now;

        $company->package_end_date = $now->addDays($package->package_num_days);

        $company->jobs_quota = $package->package_num_listings;

        $company->availed_jobs_quota = 0;

        $company->payment_method = $method;

        $company->update();

    }

    public function addCompanySearchPackage($company, $package, $method = '')
    {

        $now = Carbon::now();

        $company->cvs_package_id = $package->id;

        $company->cvs_package_start_date = $now;

        $company->cvs_package_end_date = $now->addDays($package->package_num_days);

        $company->cvs_quota = $package->package_num_listings;

        $company->availed_cvs_quota = 0;

        $company->payment_method = $method;

        $company->update();



    }

    public function updateCompanyPackage($company, $package, $method = '')
    {

        $package_end_date = $company->package_end_date;

        $current_end_date = Carbon::createFromDate(date('Y-m-d', strtotime($package_end_date)));



        $company->package_id = $package->id;

        $company->package_end_date = $current_end_date->addDays($package->package_num_days);

        $company->jobs_quota = ($company->jobs_quota - $company->availed_jobs_quota) + $package->package_num_listings;

        $company->availed_jobs_quota = 0;

        $company->payment_method = $method;

        $company->update();

    }

    public function updateCompanySearchPackage($company, $package, $method = '')
    {

        $cvs_package_end_date = $company->cvs_package_end_date;

        $current_end_date = Carbon::createFromDate(Carbon::parse($cvs_package_end_date)->format('Y'), Carbon::parse($cvs_package_end_date)->format('m'), Carbon::parse($cvs_package_end_date)->format('d'));



        $company->cvs_package_id = $package->id;

        $company->cvs_package_end_date = $current_end_date->addDays($package->package_num_days);

        $company->cvs_quota = ($company->cvs_quota - $company->availed_cvs_quota) + $package->package_num_listings;

        $company->payment_method = $method;

        $company->availed_cvs_quota = 0;

        $company->update();

    }

    public function addCompanyFeaturedJobPackage($company, $package, $method = '')
    {
        $company->payment_method = $method;

        // Guard old databases: avoid updating missing featured quota columns.
        if (Schema::hasColumn('companies', 'featured_jobs_quota') && Schema::hasColumn('companies', 'availed_featured_jobs_quota')) {
            $featuredJobsQuota = (int) ($company->featured_jobs_quota ?? 0);
            $availedFeaturedJobsQuota = (int) ($company->availed_featured_jobs_quota ?? 0);
            $remainingFeaturedJobs = max(0, $featuredJobsQuota - $availedFeaturedJobsQuota);

            $company->featured_jobs_quota = $remainingFeaturedJobs + (int) $package->package_num_listings;
            $company->availed_featured_jobs_quota = 0;
        }

        $company->update();
    }

    public function updateCompanyFeaturedJobPackage($company, $package, $method = '')
    {
        $this->addCompanyFeaturedJobPackage($company, $package, $method);
    }



}

