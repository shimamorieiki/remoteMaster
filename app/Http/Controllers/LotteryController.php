<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;
use App\Models\Vote;
use App\Models\Complete;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LotteryRequest; 
use App\Services\LotteryService;
use Illuminate\Http\Exceptions\HttpResponseException;

class LotteryController extends Controller
{

    private $lotteryService;

    public function __construct(LotteryService $lotteryservice)
    {
        $this->lotteryService = $lotteryservice;
    }


   // 当選者情報を取得する
   public function get_winner(Request $request)
   {    

       try {
            // 管理者権限ユーザじゃないと例外を投げる。
            $request->user()->must_be_Admin();
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }

        try {
            // 投票結果を取得する
            $response = $this->lotteryService->get_winner_and_number();
            $vote_result = ["vote_result"=>$response];
            return response()->success($vote_result);
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }
        
   }

    // くじに申し込む
    public function post_voting(Request $request)
    {    

        try {
            // 一般ユーザじゃないと例外を投げる。
            $request->user()->must_be_General();
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }

        try {
            // 投票を行う
            $this->lotteryService->vote($request);
            return response()->success();
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }
        
    }
}