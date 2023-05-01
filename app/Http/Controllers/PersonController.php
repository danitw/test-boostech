<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonCreateRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PersonController extends Controller
{
    /**
     * Create Person
     * @param PersonCreateRequest $request
     * @return JsonResponse
     */
    public function create(PersonCreateRequest $request): JsonResponse
    {
        $payload = $request->validated();

        try {
            $person = Person::create([
                'name' => $payload['name'],
                'email' => $payload['email'],
            ]);

            return response()->json([
                'message' => 'Person Created Successfully',
                'person' => $person
            ], 201);
        } catch (\Throwable $th) {
            Log::error('Person creation error' . $th->getMessage() . $th->getLine() . $th->getFile());
            return response()->json(['error' => 'person not created'], 500);
        }
    }

    /**
     * Read Person
     * @param int $id
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        try {
            $person = Person::find($id);

            return response()->json([
                'person' => $person
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Read person error' . $th->getMessage() . $th->getLine() . $th->getFile());
            return response()->json(['error' => 'person not exist'], 500);
        }
    }

    /**
     * List Person
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        try {
            $persons = Person::all();

            return response()->json([
                'persons' => $persons
            ], 200);
        } catch (\Throwable $th) {
            Log::error('List person error' . $th->getMessage() . $th->getLine() . $th->getFile());
            return response()->json(['error' => 'List person error'], 500);
        }
    }

    /**
     * Update Person
     * @param PersonUpdateRequest $request
     * @return JsonResponse
     */
    public function update(PersonUpdateRequest $request, int $id): JsonResponse
    {
        $payload = $request->validated();

        try {
            Person::find($id)->update($payload);

            return response()->json([
                'status' => 'successfully updated person'
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error updating person' . $th->getMessage() . $th->getLine() . $th->getFile());
            return response()->json(['error' => 'Error updating person'], 500);
        }
    }

    /**
     * Delete Person
     * @param id $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            Person::find($id)->delete();

            return response()->json([
                'status' => 'successfully deleted person'
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error deleting person' . $th->getMessage() . $th->getLine() . $th->getFile());
            return response()->json(['error' => 'error deleting person'], 500);
        }
    }
}
