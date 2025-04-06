<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organiser;

class OrganiserController extends Controller
{
    //
    public function index(){
        $organisers = Organiser::all();

        return inertia('Admin/Organisers/organiser',[
            'organisers' => $organisers
            
        ]);
       
    }
    public function create(){

    }
    public function store(Request $request){
        $request->validate([
            'name'              =>'required|string|max:255',
            'email'             =>'required|email|unique:organisers,email|max:255',
            'phone_number'       =>'required|string|unique:organisers,phone_number|max:20',
            'organization_name'  =>'required|string|unique:organisers,organization_name|max:25',
            'profile_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif',
            
        ]);

        $organiser = Organiser::firstOrNew(['id' =>$request->id]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('organizer-profile-images', 'public');
            $validated['profile_image'] = $path;
        } else {
            $organiser->profile_image = $request->profile_image;
        }

        $organiser->name = $request->name;
        $organiser->email = $request->email;
        $organiser->phone_number =$request->phone_number;
        $organiser->organization_name =$request->organization_name;
        $organiser->profile_image =$request->profile_image;


        $organiser->save();

        return redirect(route('admin.organiser.index'));
    }

    public function show(Organiser $organiser)
    {

    }
    public function update(Request $request, $id){

        $request-> validate([
            'name'              =>'required|string|max:255',
            'email'             =>'required|email|unique:organisers,email|max:255',
            'phone_number'       =>'required|string|unique:organisers,phone_number|max:20',
            'organization_name'  =>'required|string|unique:organisers,organization_name|max:25',
            'profile_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $organise =Organiser::findOrFail($id);

        $event->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'organization_name' => $request->organization_name,
            'profile_image' => $request->profile_image,
        ]);

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('organisers', 'public');
            $event->profile_image = $imagePath;

            $organiser->save();
        }

        return redirect()->route('organiser.index')->with('success', 'Organiser Updated successfully!');


        
    }

    
    public function destroy(Organiser $organiser)
    {

        
        $organiser->delete();

        return redirect()->back()->with('message', [
            'type'        => 'success',
            'description' => '',
            'title'       => 'Event Deleted',
        ]);
    }

}
