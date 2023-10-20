<?php

namespace App\Http\Controllers;

use Exception;
use App\Install\App;
use App\Install\Database;
use App\Install\Requirement;
use App\Install\AdminAccount;
use App\Install\FinalInstallation;
use Illuminate\Routing\Controller;
use App\Http\Requests\InstallAppRequest;
use App\Http\Requests\InstallDatabaseRequest;
use App\Http\Middleware\RedirectIfInstalled;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class InstallController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectIfInstalled::class);
    }

    public function installation(Requirement $requirement)
    {
        return view('install.new', compact('requirement'));
    }

    public function configurations(Requirement $requirement)
    {
        if (! $requirement->satisfied()) {
            return redirect()->name('installation');
        }

        return view('install.db_configuration', compact('requirement'));
    }

    public function db(InstallDatabaseRequest $request,Database $database,App $app)
    {
        $database->setup($request->db);
        $app->setup($request);

        return view('install.app_configuration');
    }

    public function app(InstallAppRequest $request,FinalInstallation $final,AdminAccount $admin)
    {
        $final->setup($request);
        $admin->setup($request);

        return redirect()->route('complete.installation');
    }

    public function complete()
    {
        if (env('APP_INSTALLED') == true) {
            return redirect()->route('dashboard.home');
        }

        DotenvEditor::setKey('APP_INSTALLED', 'true')->save();

        return view('install.complete');
    }
}
