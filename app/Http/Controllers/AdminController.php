<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DynamoDbService;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected $dbService;

    public function __construct(DynamoDbService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function index()
    {
        if (!$this->dbService->isAdmin(auth()->id())) {
            return redirect('/');
        }
        $formWebsite     = $this->dbService->getFormWebsiteRecords();
        $newsletter      = $this->dbService->getNewsletterRecords();
        $users           = $this->dbService->getAllUsers();
        return view('admin.admin-panel', compact('formWebsite','newsletter','users'));
    }

    public function updateFormWebsiteStatus(Request $request)
    {
        if (!$this->dbService->isAdmin(auth()->id())) {
            return redirect('/');
        }
        $this->dbService->updateFormWebsiteStatus($request->id, $request->status);
        return redirect()->back();
    }

    public function sendEmailToUser(Request $request)
    {
        if (!$this->dbService->isAdmin(auth()->id())) {
            return redirect('/');
        }
        return redirect()->back();
    }

    public function updateUserPassword(Request $request)
    {
        if (!$this->dbService->isAdmin(auth()->id())) {
            return redirect('/');
        }
        $this->dbService->updateUserPassword($request->userId, Hash::make($request->newPassword));
        return redirect()->back();
    }
}