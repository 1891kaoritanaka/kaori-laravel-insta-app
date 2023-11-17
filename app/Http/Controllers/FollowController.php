<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\IgnoreFunctionForCodeCoverage;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow){
        $this->follow = $follow;
    }

    # Store method to store the follower and the folloing id
    public function store($user_id){
        $this->follow->follower_id = Auth::user()->id; //follower
        $this->follow->following_id = $user_id;        //following ->user being followed
        $this->follow->save();

        return redirect()->back();
    }

    public function destroy($user_id){
        $this->follow->where('follower_id',Auth::user()->id)->where('following_id',$user_id)->delete();

        return redirect()->back();
    }
}
