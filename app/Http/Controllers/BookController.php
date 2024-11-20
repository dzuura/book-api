<?php

namespace App\Http\Controllers;

// use Kreait\Firebase\Database;
use Kreait\Firebase\Contract\Database;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $database;

    // Menginisialisasi koneksi ke Firebase Database
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    // Create Book
    public function create(Request $request)
    {
        // Validasi input request
        $data = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'published_at' => 'required|date',
        ]);

        // Menambahkan atribut created_at dan updated_at ke data buku
        $timestamp = now()->toISOString();
        $data['created_at'] = $timestamp;
        $data['updated_at'] = $timestamp;

        // Mengambil nilai counter ID terakhir
        $counter = $this->database->getReference('counter');
        $currentId = $counter->getValue() ?? 0;
        $newId = $currentId + 1;

        // Menyimpan data buku dengan ID numerik yang di-generate
        $this->database->getReference('books/' . $newId)->set($data);

        // Memperbarui counter dengan ID baru yang di-generate
        $counter->set($newId);

        // Menambahkan ID ke dalam respons data
        $data['id'] = $newId;

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $data,
        ], 201);
    }

    // Read All Books
    public function index()
    {
        // Mengambil semua data buku dari Firebase Database
        $books = $this->database->getReference('books')->getValue();

        // Jika data kosong, kembalikan respons dengan data kosong
        if (empty($books)) {
            return response()->json([
                'data' => null,
            ], 200);
        }

        // Pastikan data tidak mengandung entri null
        $formattedBooks = [];
        foreach ($books as $id => $book) {
            // Periksa jika entri berupa null, abaikan
            if (is_null($book)) {
                continue;
            }

            // Menambahkan entri buku
            $book['id'] = $id; // Menambahkan ID pada setiap buku
            $formattedBooks[] = $book;
        }

        return response()->json([
            'data' => $formattedBooks,
        ], 200);
    }

    // Read Single Book
    public function show($id)
    {
        // Mengambil data buku berdasarkan ID numerik
        $book = $this->database->getReference('books/' . $id)->getValue();

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json([
            'data' => $book
        ], 200);
    }

    // Update Book
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'author' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        // Ambil referensi data buku yang akan diupdate
        $reference = $this->database->getReference('books/' . $id);
        $existingBook = $reference->getValue();

        if (!$existingBook) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Menambahkan waktu 'created_at' dan 'updated_at'
        $currentTimestamp = now()->toIso8601String();

        // Perbarui data yang ada dengan data baru dan tambahkan timestamp
        $updatedData = [
            'title' => $data['title'] ?? $existingBook['title'],
            'author' => $data['author'] ?? $existingBook['author'],
            'published_at' => $data['published_at'] ?? $existingBook['published_at'],
            'created_at' => $existingBook['created_at'] ?? $currentTimestamp,
            'updated_at' => $currentTimestamp,
        ];

        // Perbarui data di Firebase
        $reference->update($updatedData);

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => [
                'id' => (int)$id,
                'title' => $updatedData['title'],
                'author' => $updatedData['author'],
                'published_at' => $updatedData['published_at'],
                'created_at' => $updatedData['created_at'],
                'updated_at' => $updatedData['updated_at'],
            ]
        ], 200);
    }

    // Delete Book
    public function destroy($id)
    {
        // Menghapus data buku berdasarkan ID numerik
        $this->database->getReference('books/' . $id)->remove();

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
