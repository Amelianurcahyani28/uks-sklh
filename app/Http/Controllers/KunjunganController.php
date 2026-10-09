<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\UksVisit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KunjunganController extends Controller
{
    /**
     * Halaman Beranda / Dashboard Admin
     */
    public function dashboard(Request $request): View
    {
        $today = now()->toDateString();
        $monthStart = now()->startOfMonth()->toDateString();

        $totalVisits = UksVisit::count();
        $todayVisits = UksVisit::whereDate('visit_date', $today)->count();
        $monthVisits = UksVisit::whereBetween('visit_date', [$monthStart, $today])->count();
        $studentCount = Student::count();

        $complaints = UksVisit::query()
            ->whereBetween('visit_date', [$monthStart, $today])
            ->select('complaint')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('complaint')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $statusCounts = [
            'ditangani' => UksVisit::where('status', 'ditangani')->count(),
            'dirujuk' => UksVisit::where('status', 'dirujuk')->count(),
            'pulang' => UksVisit::where('status', 'pulang')->count(),
        ];

        $filter = $request->query('filter', 'today');
        $status = $request->query('status');
        $keyword = trim((string) $request->query('q', ''));

        $studentsData = null;
        $visitsData = null;

        if ($filter === 'students') {
            $studentQuery = Student::withCount('visits')->latest('id');
            if ($keyword !== '') {
                $studentQuery->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                        ->orWhere('class_name', 'like', "%{$keyword}%");
                });
            }
            $studentsData = $studentQuery->paginate(8)->withQueryString();
        } else {
            $visitQuery = UksVisit::with(['student', 'handler'])->latest('visit_date')->latest('id');

            if ($filter === 'today') {
                $visitQuery->whereDate('visit_date', $today);
            } elseif ($filter === 'month') {
                $visitQuery->whereBetween('visit_date', [$monthStart, $today]);
            }

            if ($status && in_array($status, ['ditangani', 'dirujuk', 'pulang'])) {
                $visitQuery->where('status', $status);
            }

            if ($keyword !== '') {
                $visitQuery->where(function ($q) use ($keyword) {
                    $q->where('complaint', 'like', "%{$keyword}%")
                        ->orWhere('initial_treatment', 'like', "%{$keyword}%")
                        ->orWhereHas('student', function ($s) use ($keyword) {
                            $s->where('name', 'like', "%{$keyword}%")
                                ->orWhere('class_name', 'like', "%{$keyword}%");
                        });
                });
            }

            $visitsData = $visitQuery->paginate(8)->withQueryString();
        }

        return view('dashboard', [
            'todayVisits' => $todayVisits,
            'monthVisits' => $monthVisits,
            'totalVisits' => $totalVisits,
            'studentCount' => $studentCount,
            'statusCounts' => $statusCounts,
            'complaints' => $complaints,
            'activeFilter' => $filter,
            'activeStatus' => $status,
            'visitsData' => $visitsData,
            'studentsData' => $studentsData,
        ]);
    }

    /**
     * Halaman Ringkasan Rekapitulasi & CRUD Khusus Admin
     */
    public function ringkasanAdmin(Request $request): View
    {
        $today = now()->toDateString();
        $monthStart = now()->startOfMonth()->toDateString();

        $totalVisits = UksVisit::count();
        $todayVisits = UksVisit::whereDate('visit_date', $today)->count();
        $monthVisits = UksVisit::whereBetween('visit_date', [$monthStart, $today])->count();
        $studentCount = Student::count();

        $statusDitangani = UksVisit::where('status', 'ditangani')->count();
        $statusDirujuk = UksVisit::where('status', 'dirujuk')->count();
        $statusPulang = UksVisit::where('status', 'pulang')->count();

        $filter = $request->query('filter', 'month');
        $status = $request->query('status');
        $keyword = trim((string) $request->query('q', ''));

        $studentsData = null;
        $visitsData = null;

        if ($filter === 'students') {
            $studentQuery = Student::withCount('visits')->latest('id');
            if ($keyword !== '') {
                $studentQuery->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                        ->orWhere('nis', 'like', "%{$keyword}%")
                        ->orWhere('class_name', 'like', "%{$keyword}%");
                });
            }
            $studentsData = $studentQuery->paginate(10)->withQueryString();
        } else {
            $visitQuery = UksVisit::with(['student', 'handler'])->latest('visit_date')->latest('id');

            if ($filter === 'today') {
                $visitQuery->whereDate('visit_date', $today);
            } elseif ($filter === 'month') {
                $visitQuery->whereBetween('visit_date', [$monthStart, $today]);
            }

            if ($status && in_array($status, ['ditangani', 'dirujuk', 'pulang'])) {
                $visitQuery->where('status', $status);
            }

            if ($keyword !== '') {
                $visitQuery->where(function ($q) use ($keyword) {
                    $q->where('complaint', 'like', "%{$keyword}%")
                        ->orWhere('initial_treatment', 'like', "%{$keyword}%")
                        ->orWhereHas('student', function ($s) use ($keyword) {
                            $s->where('name', 'like', "%{$keyword}%")
                                ->orWhere('class_name', 'like', "%{$keyword}%");
                        });
                });
            }

            $visitsData = $visitQuery->paginate(10)->withQueryString();
        }

        return view('admin.ringkasan', [
            'todayVisits' => $todayVisits,
            'monthVisits' => $monthVisits,
            'totalVisits' => $totalVisits,
            'studentCount' => $studentCount,
            'statusStats' => [
                'ditangani' => $statusDitangani,
                'dirujuk' => $statusDirujuk,
                'pulang' => $statusPulang,
            ],
            'activeFilter' => $filter,
            'activeStatus' => $status,
            'visitsData' => $visitsData,
            'studentsData' => $studentsData,
        ]);
    }

    /**
     * Halaman Riwayat Kunjungan Admin
     */
    public function index(Request $request): View
    {
        $query = UksVisit::with(['student', 'handler'])->latest('visit_date')->latest('id');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        // Filter rentang waktu / tanggal
        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->query('date'));
        } elseif ($request->filled('month')) {
            $parts = explode('-', $request->query('month'));
            if (count($parts) === 2) {
                $query->whereYear('visit_date', $parts[0])
                      ->whereMonth('visit_date', $parts[1]);
            }
        } elseif ($request->query('period') === 'today') {
            $query->whereDate('visit_date', now()->toDateString());
        } elseif ($request->query('period') === 'month') {
            $query->whereBetween('visit_date', [now()->startOfMonth()->toDateString(), now()->toDateString()]);
        }

        // Pencarian nama, nis, keluhan
        if ($request->filled('q')) {
            $keyword = trim((string) $request->query('q'));
            $query->where(function ($sub) use ($keyword) {
                $sub->where('complaint', 'like', "%{$keyword}%")
                    ->orWhere('initial_treatment', 'like', "%{$keyword}%")
                    ->orWhereHas('student', function ($s) use ($keyword) {
                        $s->where('name', 'like', "%{$keyword}%")
                            ->orWhere('class_name', 'like', "%{$keyword}%");
                    });
            });
        }

        $visits = $query->paginate(10)->withQueryString();

        return view('kunjungan.index', [
            'visits' => $visits,
            'totalVisits' => UksVisit::count(),
            'todayCount' => UksVisit::whereDate('visit_date', now()->toDateString())->count(),
            'students' => Student::orderBy('name')->get(),
        ]);
    }

    /**
     * Halaman Catat Kunjungan Admin (Redirect ke Data Siswa yang Berkunjung dengan modal form)
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('kunjungan.index', ['tambah' => 1]);
    }

    /**
     * Simpan Kunjungan Baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['nullable', 'exists:students,id'],
            'student_name' => ['required_without:student_id', 'nullable', 'string', 'max:255'],
            'class_name' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'in:L,P'],
            'visit_date' => ['required', 'date'],
            'complaint' => ['required', 'string', 'max:1000'],
            'initial_treatment' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:ditangani,dirujuk,pulang'],
        ]);

        if ($request->filled('student_name')) {
            $inputName = trim((string) $request->input('student_name'));

            $student = null;
            if ($inputName !== '') {
                $student = Student::where('name', $inputName)->first();
            }

            if (! $student) {
                $student = Student::create([
                    'name' => $inputName !== '' ? $inputName : 'Siswa UKS',
                    'nis' => 'UKS-'.strtoupper(substr(uniqid(), -4)),
                    'class_name' => $request->input('class_name', '-') ?: '-',
                    'gender' => $request->input('gender', 'L') ?: 'L',
                ]);
            } else {
                $updates = [];
                if ($inputName !== '' && $student->name !== $inputName) {
                    $updates['name'] = $inputName;
                }
                if ($request->filled('class_name') && $student->class_name !== $request->input('class_name')) {
                    $updates['class_name'] = $request->input('class_name');
                }
                if ($request->filled('gender') && $student->gender !== $request->input('gender')) {
                    $updates['gender'] = $request->input('gender');
                }
                if (! empty($updates)) {
                    $student->update($updates);
                }
            }
            $studentId = $student->id;
        } else {
            $studentId = (int) $validated['student_id'];
        }

        UksVisit::create([
            'student_id' => $studentId,
            'handled_by' => $request->user()?->id,
            'visit_date' => $validated['visit_date'],
            'complaint' => $validated['complaint'],
            'initial_treatment' => $validated['initial_treatment'] ?? null,
            'status' => $validated['status'],
        ]);

        if ($request->routeIs('public.*')) {
            return redirect()->route('public.ringkasan')->with('success', 'Catatan kunjungan berhasil disimpan dan langsung masuk ke Ringkasan UKS.');
        }

        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil dicatat ke sistem.');
    }

    /**
     * Halaman Edit Kunjungan
     */
    public function edit(UksVisit $visit): View
    {
        return view('kunjungan.edit', [
            'visit' => $visit,
            'students' => Student::orderBy('name')->get(),
        ]);
    }

    /**
     * Update Data Kunjungan
     */
    public function update(Request $request, UksVisit $visit): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'visit_date' => ['required', 'date'],
            'complaint' => ['required', 'string', 'max:1000'],
            'initial_treatment' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:ditangani,dirujuk,pulang'],
        ]);

        $visit->update($validated);

        return redirect()->back()->with('success', 'Data kunjungan berhasil diperbarui.');
    }

    /**
     * Hapus Catatan Kunjungan
     */
    public function destroy(UksVisit $visit): RedirectResponse
    {
        $visit->delete();

        return redirect()->back()->with('success', 'Catatan kunjungan berhasil dihapus.');
    }
}
