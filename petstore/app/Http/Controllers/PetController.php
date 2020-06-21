<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiResponse;
use App\Http\Controllers\Api\Models\Pet;

class PetController extends Controller
{
    private $apiResponse;
    public function __construct(){
        $this->apiResponse = new ApiResponse();
    }

    public function upload(Request $request, $petId){
        $pet = Pet::find($petId);
        if(empty($pet)) {            
            $this->apiResponse->setType('unknown');
            $this->apiResponse->setMessage('Pet does not exist');
            return $this->apiResponse->outputResponse();
        }
        if($request->hasFile('pet_avatar')){
            $extension = $request->file('pet_avatar')->getClientOriginalExtension();
            $filename = $petId. "_avatar.". $extension;
            $dirURI = 'app/public/avatars/';
            $avatarDir = storage_path($dirURI);
            $path = $request->file('pet_avatar')->move($avatarDir, $request->file('pet_avatar')->getClientOriginalName());
            $destPath = $avatarDir. $filename;
            rename($path, $destPath);
            $pet->photoUrl = $dirURI. $filename;
        }
        $pet->name = $request->pet_name;
        $pet->age = $request->pet_age;
        $pet->save();
        $this->apiResponse->setType('success');
        $this->apiResponse->setMessage('Successful');
        return $this->apiResponse->outputResponse();
    }
}
