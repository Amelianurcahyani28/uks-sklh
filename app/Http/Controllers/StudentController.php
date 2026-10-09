<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Halaman Daftar Siswa Admin
     */
    public function index(Request $request): View
    {
        $query = Student::withCount('visits')->latest('id');

        // Pencarian nama, nis, kelas
        if ($request->filled('q')) {
            $keyword = trim((string) $request->query('q'));
            $query->where(function ($sub) use ($keyword) {
                $sub->where('name', 'like', "%{$keyword}%")
                    ->orWhere('class_name', 'like', "%{$keyword}%");
            });
        }

        // Filter Jenis Kelamin
        if ($request->filled('gender') && in_array($request->query('gender'), ['L', 'P'])) {
            $query->where('gender', $request->query('gender'));
        }

        // Filter Kelas
        if ($request->filled('class_name')) {
            $query->where('class_name', $request->query('class_name'));
        }

        $students = $query->paginate(10)->withQueryString();

        $availableClasses = Student::select('class_name')
            ->distinct()
            ->orderBy('class_name')
            ->pluck('class_name');

        return view('students.index', [
            'students' => $students,
            'totalStudents' => Student::count(),
            'classes' => $availableClasses,
        ]);
    }

    /**
     * Halaman Tambah Siswa Baru
     */
    public function create(): View
    {
        return view('students.create');
    }

    /**
     * Simpan Siswa Baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'class_name' => ['required', 'string', 'max:30'],
            'gender' => ['required', 'in:L,P'],
        ]);

        $validated['nis'] = 'NIS-' . strtoupper(uniqid());

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa baru berhasil ditambahkan.');
    }

    /**
     * Halaman Edit Data Siswa
     */
    public function edit(Student $student): View
    {
        return view('students.edit', [
            'student' => $student,
        ]);
    }

    /**
     * Perbarui Data Siswa
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'class_name' => ['required', 'string', 'max:30'],
            'gender' => ['required', 'in:L,P'],
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', "Data siswa {$student->name} berhasil diperbarui.");
    }

    /**
     * Hapus Data Siswa
     */
    public function destroy(Student $student): RedirectResponse
    {
        $name = $student->name;
        $student->delete();

        return redirect()->route('students.index')->with('success', "Data siswa {$name} berhasil dihapus.");
    }
}
