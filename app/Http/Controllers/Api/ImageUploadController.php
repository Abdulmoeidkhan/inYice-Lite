<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageUploadController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    protected function index() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->sendError('Unauthorized', ['error' => 'User not authenticated'], 401);
        }

        if (!$user->hasAnyRole(['admin',  'developer', 'owner'])) {
            return $this->sendError('Forbidden', ['error' => 'Insufficient permissions'], 403);
        }

        // return $request->all();
        $validator = Validator::make($request->all(), [
            'disk' => 'required|string',
            'name' => 'required|string',
            'savedpicture' => 'required|string',
            'path' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {
            // clean base64 prefix
            $imageBlob = str_replace('data:image/png;base64,', '', $request->savedpicture);

            // decide path
            $filePath = $request->path
                ? $request->path . '/' . $request->name . '.png'
                : $request->name . '.png';

            // save file
            $imgSaved = Storage::disk($request->disk)->put($filePath, base64_decode($imageBlob));
            // get public URL
            // 
            $url = Storage::disk($request->disk)->url($filePath);
            
            // return $url;
            return $this->sendResponse('Image uploaded successfully', $url);
        } catch (\Exception $e) {
            return $this->sendError('Image upload failed.', ['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    protected function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    protected function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    protected function destroy(string $id)
    {
        //
    }
}
