<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\profile;
use Illuminate\Support\Facades\Storage;

use App\Mail\Welcome;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $user = Auth::user();
        $url='';
        $imageretrive=new profile();
        $some=$imageretrive->where('userid',$user->id)->pluck('imagename');
      
        if (!empty($some)){
            $url=$some;
        }
        return view('home')->with('urls',$url);
    }

    public function store(Request $request)
    {   
        $user = Auth::user();
        // var_dump($request->filename);
        $this->validate($request, [
            'filename' => 'required', 
        ]);
        $imagestore= new profile();
        $filename=request()->file('filename')->store('public');
        $url = Storage::url($filename);
        $imagestore->imagename=$url;
        $imagestore->userid=$user->id;
        $imagestore->save();    
        
        
        return back();
    }

    public function mailme(){
        $user = Auth::user();
        $imageretrive=new profile();
        $some=$imageretrive->where('userid',$user->id)->pluck('imagename');
        $links=$some;
        // dd($links);
        \Mail::to($user->email)->send(new Welcome($links));
        return redirect()->back();
    }
}
