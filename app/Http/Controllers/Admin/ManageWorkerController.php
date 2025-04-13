<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class ManageWorkerController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('pages.admin.manage.worker', compact('user'));
    }

    public function getWorker(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'worker')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('profile', function ($row) {
                    $src = $row->profile ? asset('storage/' . $row->profile) : asset('images/profile-default.png');
                    return '<img src="' . $src . '" width="40" height="40" style="object-fit: cover;">';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn bg-brown text-white" onclick="editWorker(' . $row->id . ')">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button class="btn bg-brown text-white" onclick="deleteWorker(' . $row->id . ')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    ';
                })
                
                ->rawColumns(['profile', 'action'])
                ->make(true);
        }
    }

    public function getData($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'username' => 'required|string|unique:users',
                'phone_number' => 'required|numeric',
                'password' => 'required|string|min:6',
                'profile' => 'nullable|image|max:2048'
            ]);
    
            $path = null;
            if ($request->hasFile('profile')) {
                $path = $request->file('profile')->store('profiles', 'public');
            }
    
            User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'phone_number' => $validated['phone_number'],
                'password' => Hash::make($validated['password']),
                'profile' => $path,
                'role' => 'worker',
            ]);
    
            return redirect()->back()->with('success', 'Tasker successfully added.');
        } catch (ValidationException $e) {
            $firstError = collect($e->validator->errors()->all())->first();
            return redirect()->back()->with('error', $firstError);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $id,
            'phone_number' => 'required|string',
            'password' => 'nullable|string|min:6',
            'profile' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('profiles', 'public');
        }

        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->phone_number = $validated['phone_number'];
        $user->profile = $path ?? $user->profile;
        $user->password = $request->filled('password') ? Hash::make($validated['password']) : $user->password;
        $user->save();

        return response()->json(['success' => 'Worker successfully updated.']);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'User successfully deleted.']);
    }
}
