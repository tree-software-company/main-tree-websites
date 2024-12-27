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

    public function index(Request $request)
    {
        if (!$this->dbService->isAdmin(auth()->id())) {
            return redirect('/');
        }

        $searchParams = [
            'first_name' => $request->input('search_first_name'),
            'last_name'  => $request->input('search_last_name'),
            'email'      => $request->input('search_email'),
            'user_type'  => $request->input('search_user_type'),
        ];

        $lastEvaluatedKey = $request->session()->get('last_evaluated_key');

        $usersData = $this->dbService->searchUsers($searchParams, $lastEvaluatedKey, 100);
        $users = $usersData['items'];
        $nextKey = $usersData['last_evaluated_key'];

        if ($nextKey) {
            $request->session()->put('last_evaluated_key', $nextKey);
        } else {
            $request->session()->forget('last_evaluated_key');
        }

        $formWebsite = $this->dbService->getFormWebsiteRecords();
        $newsletter  = $this->dbService->getNewsletterRecords();

        return view('admin.admin-panel', compact('formWebsite', 'newsletter', 'users', 'nextKey'));
    }

    public function updateFormWebsiteStatus(Request $request)
    {
        if (!$this->dbService->isAdmin(auth()->id())) {
            return redirect('/');
        }

        $request->validate([
            'id' => 'required|numeric',
            'status' => 'required|in:not answered,answered',
        ]);

        try {
            $this->dbService->updateFormWebsiteStatus($request->id, $request->status);
            return redirect()->back()->with('success', 'Form website status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update status.']);
        }
    }

    public function sendEmailToUser(Request $request)
    {
        if (!$this->dbService->isAdmin(auth()->id())) {
            return redirect('/');
        }

        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {

            return redirect()->back()->with('success', 'Email sent successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to send email.']);
        }
    }

    public function updateUserPassword(Request $request)
    {
        if (!$this->dbService->isAdmin(auth()->id())) {
            return redirect('/');
        }

        $request->validate([
            'userId' => 'required|numeric',
            'newPassword' => 'required|string|min:8',
        ]);

        try {
            $hashedPassword = Hash::make($request->newPassword);
            $this->dbService->updateUserPassword($request->userId, $hashedPassword);
            return redirect()->back()->with('success', 'User password updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update password.']);
        }
    }

    public function updateUserType(Request $request)
    {
        if (!$this->dbService->isAdmin(auth()->id())) {
            return redirect('/');
        }

        $request->validate([
            'userId' => 'required|numeric',
            'user_type' => 'required|in:user,admin',
        ]);

        try {
            $this->dbService->updateUserType($request->userId, $request->user_type);
            return redirect()->back()->with('success', 'User type updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update user type.']);
        }
    }
}