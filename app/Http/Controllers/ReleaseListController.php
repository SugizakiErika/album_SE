<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Release_list;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReleaseListController extends Controller
{
    // フォロー検索画面
    public function index(Release_list $release_list)
    {
        $request_ids = Release_List::where('release_user_id',Auth::user()->id)->where('request',1)->value('users_id');
        if(Release_List::where('release_user_id',Auth::user()->id)->where('request',1)->count() > 1){
        foreach($request_ids as $request_id){
        $follow_lists = Release_List::where('release_user_id',$request_id)->where('request',1)->get();
    
        $follow_lists_vals = [];
        //本当はリレーションするべき...??
        $follow_lists_vals = collect($follow_lists)->map(function ($follow_lists) {
            
        $user_watchword = User::where('id',$follow_lists->users_id)->value('watchword');
        $follow_name['follow_name'] = User::where('id',$follow_lists->users_id)->value('name');
        Log::info($follow_name);
        $follow_lists['watchword'] = $user_watchword;
        
        return $follow_lists;
        });
        }
        }elseif(Release_List::where('release_user_id',Auth::user()->id)->where('request',1)->count() == 1){
           $follow_lists = Release_List::where('users_id',$request_ids)->where('request',1)->get();
    
        $follow_lists_vals = [];
        //本当はリレーションするべき...??
        $follow_lists_vals = collect($follow_lists)->map(function ($follow_lists) {
            
        $user_watchword = User::where('id',$follow_lists->users_id)->value('watchword');
        $follow_lists['follow_name'] = User::where('id',$follow_lists->users_id)->value('name');
        $follow_lists['watchword'] = $user_watchword;
        
        return $follow_lists;
        }); 
        }else{
            return view('release.create')
            ->with(['release_lists' => $release_list->where('users_id',Auth::user()->id)->where('request',1)->get()]);
        }
        Log::info($follow_lists);
        
        return view('release.create')
            ->with(['release_lists' => $release_list->where('users_id',Auth::user()->id)->where('request',1)->get()])
            ->with(['follow_lists' => $follow_lists_vals]);
    }
    
    //合言葉とフォロー申請保存画面
    public function create(User $user,Release_List $release_list,Request $request)
    {
        $input = $request['release'];
        //合言葉登録
        if($request->has('watchword')){ //form:watchword
        
        Log::info($input);
            $user = User::find(Auth::user()->id);
            $user->watchword = $input["watchword"];
            $user->save();
        
        }
        
        //フォロー申請内容保存
        if($request->has('follow')){ //form:follow
        Log::info($input);
            $release_list = Release_List::find($input["follow_id"]);
            $release_list->notice = $input["notice"];
            //$release_list->select_color  = $input["select_color"];
            $release_list->save();
            
        }
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
            
            Log::info($data);
            Log::info($duplications);
            
            
            if($data)
            {
                $result = User::where('name',$input["name"])
                                ->whereNotIn('id',[Auth::user()->id,$duplications])
                                ->get();
                                Log::info("result:$data");
            }else{
                $result = NULL;
                Log:info("result:NULL");
            }
            
        }else{
            
            if(User::where('name',$input["name"])->where('id','<>',Auth::user()->id)->exists())
            {
            $result = User::where('name',$input["name"])
                            ->where('id','<>',Auth::user()->id)
                            ->get();
                            Log::info("result:if最後");
            }else{
                $result = NULL;
                Log::info("else側");
            }
                
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
    
    //フォロー許可編集
    public function follow_save(Request $request,Release_List $release_list)
    {
        $input = $request['release'];
        $release_list = Release_List::find($input["id"]);
        $release_list->notice = $input["notice"];
        $release_list->save();
    }
}
