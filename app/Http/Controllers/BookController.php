<?php

namespace App\Http\Controllers;
use App\Services\BookService;
use App\Http\Resources\BookResource;
use App\Http\Requests\BookRequest\StoreBookRequest;
use App\Http\Requests\BookRequest\UpdateBookRequest;

class BookController extends Controller
{
    protected BookService $BookService;

    /**
     * Constructor for BookController
     *
     * @param BookService $BookService The task service for handling book-related logic.
     */
    public function __construct(BookService $BookService)
    {
        $this->BookService = $BookService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $books= $this->BookService->getAll();
     return response()->json([
         'status' => 'success',
         'message' => 'Tasks retrieved successfully',
         'books' => [
             'info' => BookResource::collection($books['data']),
             'current_page' => $books['current_page'],
             'last_page' => $books['last_page'],
             'per_page' => $books['per_page'],
             'total' => $books['total'],
         ],
     ], 200); // OK
    }

    public function show(string $id)
    {
        $book = $this->BookService->show($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Book retrived successfully',
            'book' => BookResource::make($book),
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreBookRequest $request): \Illuminate\Http\JsonResponse
    {
        $book = $this->BookService->store($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Book created successfully',
            'book' => BookResource::make($book),
        ], 201); // Created
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateBookRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $book = $this->BookService->update($request->validated(), $id);

        return response()->json([
            'status' => 'success',
            'message' => 'Book updated successfully',
            'book' => BookResource::make($book),
        ], 200); // OK
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $message = $this->BookService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ], 200); // OK
    }

    /**
     * @throws \Exception
     */
    public function ShowTrashed(): \Illuminate\Http\JsonResponse
    {
      $trashedBooks= $this->BookService->showDeleted();
        return response()->json([
            'status' => 'success',
            'message' => 'Trashed Books retrieved successfully',
            'books' => [
                'books' => [
            'info' => BookResource::collection($trashedBooks->items()), 
            'current_page' => $trashedBooks->currentPage(),
            'last_page' => $trashedBooks->lastPage(),
            'per_page' => $trashedBooks->perPage(),
            'total' => $trashedBooks->total(),
        ],
            ],
        ], 200); // OK
    }

    /**
     * @throws \Exception
     */
    public function restore(string $id)
    {
        $book=$this->BookService->restoreDeleted($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Trashed Books restored successfully',
            'book' => BookResource::make($book),
           ] , 200); // OK
    }

    /**
     * @throws \Exception
     */
    public function forceDelete(string $id)
    {
       $message=$this->BookService->ForceDelete($id);
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ] , 200); // OK
    }

}
