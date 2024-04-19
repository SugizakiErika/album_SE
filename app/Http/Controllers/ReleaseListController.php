<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Release_list;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReleaseListController extends Controller
{
    // フォロー検索画面
    public function index(Release_list $release_list)
    {
        return view('release.create')->with(['release_lists' => $release_list->where('users_id',Auth::user()->id)
                                                                                ->where('request',1)->get()]);
    }
    
    //合言葉登録画面
    public function create(Request $request, User $user)
    {
        $input = $request['release'];
        $user = User::find(Auth::user()->id);
        $user->watchword = $input["watchword"];
        $user->save();
        
        return redirect()->route('release');
    }
    
    //フォロー検索後画面
    public function serach(Request $request)
    {
        $input = $request->all();
        $duplications_data = [];
        $duplications_data2 = [];
        $duplications = Release_List::where('follow_name',$input["name"])
                                    ->where('users_id',Auth::user()->id)
                                    ->where('request',1)
                                    ->pluck('release_user_id');
        
        if(Release_List::where('follow_name',$input["name"])->where('users_id',Auth::user()->id)->where('request',1)->exists())
        {
            array_push($duplications_data,Auth::user());
            array_push($duplications_data,$duplications);
            array_push($duplications_data2,User::pluck('id'));
            $data = array_intersect($duplications_data,$duplications_data2);
        
            
            if($data == 0)
            {
                $result = User::where('name',$input["name"])
                                ->whereNotIn('id',[Auth::user()->id,$duplications])
                                ->get();
            }else{
                $result = NULL;
            }
            
        }else{
            $result = User::where('name',$input["name"])
                            ->where('id','<>',Auth::user()->id)
                            ->get();
        }
        
        return response()->json($result);
    }
    
    //フォロー申請テーブル保存
    public function serach_save(Request $request, Release_List $release_list)
    {
        $input = $request->all();
        
        $release_list->request = 1;
        $release_list->release_user_id = $input["followuserid"];
        $release_list->follow_name = User::where('id',$input["followuserid"])->value('name');
        $release_list->users_id = Auth::user()->id;
        $release_list->save();
        
        $result = Release_list::where('users_id',Auth::user()->id)->get();
        
        return response()->json($result);
    }
    
    //フォロー申請取消
    public function delete(Release_List $release_list)
    {
        //$this->authorize('delete', $my_event);
        $release_list->delete();
        
        $result = Release_list::where('users_id',Auth::user()->id)->get();
        
        return response()->json($result);
    }
    
    
}
