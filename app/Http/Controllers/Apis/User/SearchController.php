<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function search(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "name" => "required",
        ];
        $messages   = [
            "required"   => 1
        ];
        $msg        = [
            1  => trans("messages.required"),
            3  => trans("messages.success"),
            4  => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
         //$search =   html_entity_decode($request->input("name"), ENT_COMPAT, 'UTF-8');
         $search =   $request->input("name");
         
         
            
         $providerspag =  DB::table("providers")
                        ->join("images" , "images.id" ,"providers.image_id")
                        ->join('branches','branches.provider_id','=','providers.id')
                        ->where("providers.ar_name" , "LIKE" ,"%" . $search . "%")
                        ->orWhere("providers.en_name" , "LIKE" ,"%" . $search . "%")
                   //     ->where("providers.phoneactivated" , "1")
                        ->where("providers.accountactivated" , "1")
                        ->select(
                            "branches.id AS id",
                            "providers.id AS provider_id",
                             DB::raw("CONCAT(providers .ar_name,'-',branches .ar_name) AS name"),
                             "branches.has_delivery",
                             "branches.has_booking",
                             "branches.longitude",
                             "branches.latitude",
                             "branches." .$name ."_address AS address",
                             "branches.average_price AS mealAveragePrice",
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url")
                        )
                        ->paginate(10);
                        
        (new HomeController())->filter_providers_branches($request,$name,$providerspag);

            // filter based on distance
            $providers = $providerspag->sortBy(function($item){
                return $item->distance;
            })->values();
            
            
               // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($providers);

        // Define how many items we want to be visible in each page
        $perPage = 10;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath(url()->current());

        
        
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3] , "providers" => $paginatedItems]);
    }

    public function get_provider_names(){
        $providers_ar = DB::table("providers")
                            ->join("branches", "branches.provider_id", "providers.id")
                            ->select(
                                "providers.ar_name AS name"
                            )
                            ->groupBy("providers.id")
                            ->get();

        $providers_en = DB::table("providers")
                            ->join("branches", "branches.provider_id", "providers.id")
                            ->select(
                                "providers.en_name AS name"
                            )
                            ->groupBy("providers.id")
                            ->get();

        return response()->json([
                                    'status' => true,
                                    'errNum' => 0,
                                    'msg' => trans("messages.success") ,
                                    'ar_names' => $providers_ar,
                                    'en_names' => $providers_en
                                ]);
    }
}
