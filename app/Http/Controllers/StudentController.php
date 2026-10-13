<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\UksVisit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Halaman Data Siswa yang Berkunjung
     */
    public function index(Request $request): View
    {
        $query = UksVisit::with([
            'student' => function ($q) {
                $q->withCount('visits');
            },
            'handler',
        ])->latest('visit_date')->latest('id');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        // Pencarian nama, keluhan, kelas, jurusan
        if ($request->filled('q')) {
            $keyword = trim((string) $request->query('q'));
            $query->where(function ($sub) use ($keyword) {
                $sub->where('complaint', 'like', "%{$keyword}%")
                    ->orWhere('initial_treatment', 'like', "%{$keyword}%")
                    ->orWhereHas('student', function ($s) use ($keyword) {
                        $s->where('name', 'like', "%{$keyword}%")
                            ->orWhere('nis', 'like', "%{$keyword}%")
                            ->orWhere('class_name', 'like', "%{$keyword}%")
                            ->orWhere('major', 'like', "%{$keyword}%");
                    });
            });
        }

        $visits = $query->paginate(10)->withQueryString();

        return view('students.index', [
            'visits' => $visits,
            'totalVisits' => UksVisit::count(),
            'todayCount' => UksVisit::whereDate('visit_date', now()->toDateString())->count(),
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
            'major' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', 'in:L,P'],
        ]);

        $validated['nis'] = 'NIS-'.strtoupper(uniqid());

        Student::create($validated);

        return redirect()->route('kunjungan.index')->with('success', 'Data siswa baru berhasil ditambahkan.');
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
            'major' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', 'in:L,P'],
        ]);

        $student->update($validated);

        return redirect()->route('kunjungan.index')->with('success', "Data siswa {$student->name} berhasil diperbarui.");
    }

    /**
     * Hapus Data Siswa
     */
    public function destroy(Student $student): RedirectResponse
    {
        $name = $student->name;
        $student->delete();

        return redirect()->route('kunjungan.index')->with('success', "Data siswa {$name} berhasil dihapus.");
    }
}
