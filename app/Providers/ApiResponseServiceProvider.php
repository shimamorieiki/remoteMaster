<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use \Symfony\Component\HttpFoundation\Response as Status;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * response macro
     *
     * @return void
     */
    public function boot()
    {
        // success
        Response::macro('success', function ($response=null) {
            return response([
                'status'   =>Status::HTTP_OK,
                'message'  => 'Request Completed.',
                'response' => $response,
            ], Status::HTTP_OK);
        });


        // Bad Request Error
        Response::macro('badRequest', function ($message) {
            return response([
                'status'   => Status::HTTP_BAD_REQUEST,
                'message'  => $message,
                'response' => null
            ], Status::HTTP_BAD_REQUEST);
        });

        // Internal Server Error
        Response::macro('serverError', function ($message="Server Error.") {
            return response([
                "status"   => Status::HTTP_INTERNAL_SERVER_ERROR,
                "message"  => $message,
                "response" => null
            ], Status::HTTP_INTERNAL_SERVER_ERROR);
        });
        
    }
}