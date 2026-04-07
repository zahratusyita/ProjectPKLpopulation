<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Kabupaten_kota;
use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check()){
            $kab_kota = Kabupaten_kota::all();
            $kecamatan = Kecamatan::all();

            if(Auth::user()->user_type == 'A'){
                $user = User::paginate(25);
            }else{
                echo('User type tidak diketahui');
            }
        }else{
            redirect('/login');
        }

        return view('admin.user.user', ['user' => $user, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_type = Auth::user()->user_type;
        if($user_type == "A"){
            $kab_kota = Kabupaten_kota::all();  
        }
        return view('admin.user.form_user', ['kab_kota' => $kab_kota]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|regex:/^[a-zA-Z\s]+$/',
            'email'             => 'required|email',
            'user_type'         => 'required',
            'password'          => 'required|confirmed|min:8'
        ]);

        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'user_type'         => $request->user_type,
            'password'          => Hash::make($request->password),
            'kab_kota_id'       => $request->kab_kota,
            'kecamatan_id'      => $request->kecamatan,
        ]);

        return redirect('user');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user_type = Auth::user()->user_type;
        if($user_type != "A"){
            return redirect('user')->withErrors(['error' => 'Akses ditolak']);
        }
        
        $user = User::findOrFail($id);
        $kab_kota = Kabupaten_kota::all();
        $kecamatan = collect();
        if ($user->kab_kota_id) {
            $kecamatan = Kecamatan::where('kab_kota_id', $user->kab_kota_id)->get();
        }

        return view('admin.user.edit_user', ['user' => $user, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $rules = [
            'name'              => 'required|regex:/^[a-zA-Z\s]+$/',
            'email'             => 'required|email|unique:users,email,'.$id,
            'user_type'         => 'required',
        ];

        if($request->filled('password')){
            $rules['password'] = 'required|confirmed|min:8';
        }

        $validated = $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->kab_kota_id = $request->kab_kota;
        $user->kecamatan_id = $request->kecamatan;

        if($request->filled('password')){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('user');
    }

    public function search(Request $request)
    {
        $user_type = Auth::user()->user_type;
        $user_kab_kota = Auth::user()->kab_kota_id;
        $user_kecamatan = Auth::user()->kecamatan_id;

        // retrieving searched data
        $search = $request->search;
        $ft_kab_kota = $request->kab_kota;
        $ft_kecamatan = $request->kecamatan;
        if($user_type == 'A'){
            $user =User::whereNotNull('id');
            if(isset($ft_kab_kota)){
                $user = User::where('kab_kota_id', $ft_kab_kota);
            }
            if(isset($ft_kecamatan)){
                $user->where('kecamatan_id', $ft_kecamatan);
            }
            
            $kab_kota = Kabupaten_kota::all();
            $kecamatan = Kecamatan::all();
        }elseif($user_type == 'B'){
            $user = User::where('kab_kota_id', $user_kab_kota);
            if(isset($ft_kecamatan)){
                $user->where('kecamatan_id', $ft_kecamatan);
            }

            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('kab_kota_id', $user_kab_kota)->get();
        }elseif($user_type == 'C'){
            $user = User::where('kab_kota_id', $user_kab_kota)
                ->where('kecamatan_id', $user_kecamatan);

            $kab_kota = Kabupaten_kota::where('id', $user_kab_kota)->get();
            $kecamatan = Kecamatan::where('id', $user_kecamatan)->get();
        }

        if(isset($search)){
            $user->where('name', 'like', "%".$search."%");
        }

        $result = $user->paginate(25);

        // return data peternak to view (index)
        return view('admin.user.user', ['user' => $result, 'kab_kota' => $kab_kota, 'kecamatan' => $kecamatan]);
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'mimes:xls,xlsx'
        ]);

        Excel::import(new UsersImport(), $request->file('file'));
        return redirect('user');
    }
}
