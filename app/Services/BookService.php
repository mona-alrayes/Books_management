<?php

namespace App\Services;
use Exception;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class TaskService
 *
 * This service handles operations related to tasks, including fetching, storing, updating, and deleting tasks.
 */
class BookService
{
    /**
     * Retrieve all books
     * @return array
     * An array containing paginated book resources.
     *
     * @throws \Exception
     * Throws an exception if there is an error during the process.
     */
    public function getAll(): array
    {
        try {
            $books = Book::paginate(5);
            return [
                'data' => $books->items(), // The items on the current page
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
            ];
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve books: ' . $e->getMessage());
        }
    }

    /**
     * Store a new book.
     *
     * @param array $data
     * An associative array containing the book's details .
     *
     * @return Book
     * The created book resource.
     *
     * @throws \Exception
     * Throws an exception if book creation fails.
     */
    public function store(array $data): Book
    {
        try {
            $book = Book::create($data);

            if (!$book) {
                throw new Exception('Failed to create the book.');
            }

            return $book;
        } catch (Exception $e) {
            throw new Exception('Book creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Retrieve a specific book by its ID.
     *
     * @param int $id
     * The ID of the task to retrieve.
     *
     * @return Book
     * The task resource.
     *
     * @throws \Exception
     * Throws an exception if the task is not found.
     */
    public function show(int $id): Book
    {
        try {
            return Book::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Book not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve book: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing book.
     *
     * @param array $data
     *
     * @param string $id
     * The ID of the book to update.
     *
     * @return Book
     * The updated book resource.
     *
     * @throws \Exception
     * Throws an exception if the task is not found or update fails.
     */
    public function update(array $data, string $id): book
    {
        try {
            $book = Book::findOrFail($id);
            $book->update(array_filter($data));
            return $book;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Book not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to update book: ' . $e->getMessage());
        }
    }

    /**
     * Delete a book by its ID.
     *
     * @param string $id
     * The ID of the book to delete.
     *
     * @return string
     * A message confirming the successful deletion.
     *
     * @throws \Exception
     * Throws an exception if the book is not found or deletion fails.
     */
    public function delete(string $id): string
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return "Book deleted successfully.";
        } catch (ModelNotFoundException $e) {
            throw new Exception('Book not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to delete book: ' . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function showDeleted(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        try {
            return Book::onlyTrashed()->paginate(5);
        } catch (Exception $e){
            throw new Exception('Failed to retrieve trashed book: ' . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function restoreDeleted(string $id):Book
    {
        try {
            $book = Book::findOrFail($id);
            $book->restore();
            return $book;
        }catch (ModelNotFoundException $e) {
            throw new Exception('Book not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to restore book: ' . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function ForceDelete(string $id):string
    {
        try{
            $book = Book::findOrFail($id);
            $book->forceDelete();
            return "Book deleted Forever from database successfully.";
        }catch (ModelNotFoundException $e) {
            throw new Exception('Book not found: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Failed to restore book: ' . $e->getMessage());
        }
    }
}
