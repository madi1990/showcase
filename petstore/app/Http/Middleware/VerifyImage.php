<?php

namespace App\Http\Middleware;
use App\Http\Controllers\Api\ApiResponse;

use Closure;

class VerifyImage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->hasFile('pet_avatar')){
            $apiResponse = new ApiResponse();

            $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
            $mimeType = $request->file('pet_avatar')->getClientMimeType();
            if(in_array($mimeType, $allowedMimeTypes) === false){
                $apiResponse->setCode(-1);
                $apiResponse->setMessage('Uploaded file is not an image');
                return $apiResponse->outputResponse();
            }

	        $size = $request->file('pet_avatar')->getSize();
	        if($size > 10 * 1024 * 1024) {
	            $apiResponse->setCode(-2);
                $apiResponse->setMessage('Uploaded file is too large (Must not be more than 10MB)');
                return $apiResponse->outputResponse();
	        }
	        	        
	    }
        return $next($request);
    }
}
