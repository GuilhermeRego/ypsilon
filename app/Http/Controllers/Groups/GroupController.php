<?php

namespace App\Http\Controllers\Groups;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Image;
use App\Models\Group_Member;
use App\Models\Group_Owner;
class GroupController extends Controller
{
    public function create(){
        return view('Groups.creategroup');

    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:16',
            'description' => 'required|string|max:1000',
            
        ]);
        $groupImageId = null;
        if ($request->hasFile('group_image')) {
            $imagePath = $request->file('group_image')->store('group_images', 'public');
            $groupImage = Image::create([
                'url' => $imagePath,
                'type' => 'group_profile',
            ]);
            $groupImageId = $groupImage->id; 
        }

        $groupBannerId = null;
        if ($request->hasFile('group_banner')) {
            $bannerPath = $request->file('group_banner')->store('group_banners', 'public');
            $groupBanner = Image::create([
                'url' => $bannerPath,
                'type' => 'group_banner',
            ]);
            $groupBannerId = $groupBanner->id; // Get the ID of the created banner
        }

        // Store the group along with the image and banner IDs
        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'group_image' => $groupImageId,  // Store the ID of the group image
            'group_banner' => $groupBannerId, // Store the ID of the group banner
        ]);

        $group_member = Group_Member::create([
            'group_id' => $group->id,
            'user_id' =>  Auth()->user()->id,
        ]);
        $group_member = Group_Owner::create([
            'member_id' => $group_member->id,
        ]);


        return redirect()->route('your-groups.index')->with('success', 'Group created successfully!');
    }

}
