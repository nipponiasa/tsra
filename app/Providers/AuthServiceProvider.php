<?php

namespace App\Providers;

use App\Models\TechnicalCase;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // initialize passport routes
        Passport::routes();

        //Gate to check if user and case have the same country
        Gate::define('accessThisCountry', function ($user,$case_id) {
            if (!$user->country_id){     // not restricted for country
                return true;
            }
            $case = TechnicalCase::find($case_id);
            return $user->country_id==$case->country_id;
        });

        // super admin get all the access
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()


       // Gate::define('view-case', function ($user,$caseuserid) {
       //     return $user->id==$caseuserid;
      //  });




        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
