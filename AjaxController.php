<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function save(Request $request)
    {

        /**
         * FETCHING ALL CHECKBOX IN AN ARRAY
         */
        $chk_arry = $request->all_chks;


        /**
         * LOOP THROUGH ALL THE CHECKBOX VALUES
         */
        foreach ($chk_arry as $chk_name => $chk_val) {

            // GETTING ALREADY EXISTING CHECKBOXES IN DATABASE
            $tmp_nm = DB::table('capunits')->select('chk_name')->where('chk_name', '=', "{$chk_name}")->get();

            // GET NUMBERS OF ALREADY EXIST CHECKBOX FROM DATABSE
            $has_chk = sizeof($tmp_nm);

            $stats = $chk_val != "" ? "" : "x";

            // IF DATABSE DON"T HAVE ANY CHECKBOX MATCHING THE REQUESTED NAME
            if ($has_chk <= 0) {
                DB::table('capunits')->insert(
                    array(
                        'chk_name'   =>   $chk_name,
                        'value'   =>   $chk_val,
                        'stats'   =>   $stats
                    )
                );
            } else { // IF DATABASE ALREADY HAS MATCHING CHECKBOX NAME
                DB::table('capunits')
                    ->where('chk_name', $chk_name)
                    ->limit(2)
                    ->update(array('stats' => $stats));
            }

            // ASSIGNING RESPONSE TO $response VARIABLE
            $response = $tmp_nm;
        }
        // $response = array(
        //     'status' => 'success',
        //     'msg' => $request->all_chks,
        // );

        // SENDING BACK RESPONSE TO JQUERY
        return response()->json($response);
    }
}
