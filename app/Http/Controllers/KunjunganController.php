<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\PetugasJadwal;
use App\Models\Student;
use App\Models\UksVisit;
use App\Services\VisitExportService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        $todayStudentsCount = UksVisit::whereDate('visit_date', $today)
            ->whereNotNull('student_id')
            ->distinct('student_id')
            ->count('student_id');
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

        // Hitung status kunjungan KHUSUS HARI INI untuk dashboard
        $statusCounts = [
            'ditangani' => UksVisit::whereDate('visit_date', $today)->where('status', 'ditangani')->count(),
            'dirujuk' => UksVisit::whereDate('visit_date', $today)->where('status', 'dirujuk')->count(),
            'pulang' => UksVisit::whereDate('visit_date', $today)->where('status', 'pulang')->count(),
        ];

        $status = $request->query('status');
        $keyword = trim((string) $request->query('q', ''));

        // Tabel di Dashboard khusus menampilkan kunjungan siswa HARI INI saja
        $visitQuery = UksVisit::with([
            'student' => function ($q) {
                $q->withCount('visits');
            },
            'handler',
        ])->whereDate('visit_date', $today)
            ->latest('visit_date')
            ->latest('id');

        if ($status && in_array($status, ['ditangani', 'dirujuk', 'pulang'])) {
            $visitQuery->where('status', $status);
        }

        if ($keyword !== '') {
            $visitQuery->where(function ($q) use ($keyword) {
                $q->where('complaint', 'like', "%{$keyword}%")
                    ->orWhere('initial_treatment', 'like', "%{$keyword}%")
                    ->orWhereHas('student', function ($s) use ($keyword) {
                        $s->where('name', 'like', "%{$keyword}%")
                            ->orWhere('class_name', 'like', "%{$keyword}%")
                            ->orWhere('major', 'like', "%{$keyword}%");
                    });
            });
        }

        $visitsData = $visitQuery->paginate(10)->withQueryString();

        $daysList = PetugasJadwal::daysList();
        $todayDayNumber = now()->dayOfWeekIso;
        $allDays = PetugasJadwal::allDaysList();
        $todayDayName = $allDays[$todayDayNumber] ?? 'Senin';
        $isWeekday = $todayDayNumber >= 1 && $todayDayNumber <= 5;

        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $todayFormatted = $todayDayName.', '.now()->day.' '.($monthNames[now()->month] ?? '').' '.now()->year;

        $todayItems = PetugasJadwal::with('petugas')
            ->where('day_number', $todayDayNumber)
            ->where('status', 'aktif')
            ->whereHas('petugas', function ($query) {
                $query->where('status', 'aktif');
            })
            ->orderBy('id')
            ->get();

        return view('dashboard', [
            'todayVisits' => $todayVisits,
            'todayStudentsCount' => $todayStudentsCount,
            'monthVisits' => $monthVisits,
            'totalVisits' => $totalVisits,
            'studentCount' => $studentCount,
            'statusCounts' => $statusCounts,
            'complaints' => $complaints,
            'activeFilter' => 'today',
            'activeStatus' => $status,
            'visitsData' => $visitsData,
            'studentsData' => null,
            'petugasCount' => Petugas::count(),
            'daysList' => $daysList,
            'todayDayNumber' => $todayDayNumber,
            'todayDayName' => $todayDayName,
            'todayFormatted' => $todayFormatted,
            'isWeekday' => $isWeekday,
            'todayItems' => $todayItems,
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

        $filter = $request->query('filter', 'all');
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
                        ->orWhere('class_name', 'like', "%{$keyword}%")
                        ->orWhere('major', 'like', "%{$keyword}%");
                });
            }
            $studentsData = $studentQuery->paginate(10)->withQueryString();
        } else {
            $visitQuery = UksVisit::with(['student', 'handler'])->latest('visit_date')->latest('id');

            // Filter rentang waktu / tanggal / periode
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $start = min($request->query('start_date'), $request->query('end_date'));
                $end = max($request->query('start_date'), $request->query('end_date'));
                $visitQuery->whereBetween('visit_date', [$start, $end]);
            } elseif ($request->filled('start_date')) {
                $visitQuery->whereDate('visit_date', '>=', $request->query('start_date'));
            } elseif ($request->filled('end_date')) {
                $visitQuery->whereDate('visit_date', '<=', $request->query('end_date'));
            } elseif ($request->filled('date')) {
                $visitQuery->whereDate('visit_date', $request->query('date'));
            } elseif ($request->filled('month')) {
                $parts = explode('-', (string) $request->query('month'));
                if (count($parts) === 2) {
                    $visitQuery->whereYear('visit_date', $parts[0])
                        ->whereMonth('visit_date', $parts[1]);
                }
            } elseif ($filter === 'today' || $request->query('period') === 'today') {
                $visitQuery->whereDate('visit_date', $today);
            } elseif ($filter === 'month' || $request->query('period') === 'month') {
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
                                ->orWhere('nis', 'like', "%{$keyword}%")
                                ->orWhere('class_name', 'like', "%{$keyword}%")
                                ->orWhere('major', 'like', "%{$keyword}%");
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
     * Halaman Catat Kunjungan & Database Siswa Admin
     */
    public function index(Request $request): View
    {
        $query = Student::withCount('visits')->latest('id');

        // Pencarian nama, kelas, jurusan
        if ($request->filled('q')) {
            $keyword = trim((string) $request->query('q'));
            $query->where(function ($sub) use ($keyword) {
                $sub->where('name', 'like', "%{$keyword}%")
                    ->orWhere('nis', 'like', "%{$keyword}%")
                    ->orWhere('class_name', 'like', "%{$keyword}%")
                    ->orWhere('major', 'like', "%{$keyword}%");
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
        $allStudents = Student::orderBy('name')->get();

        return view('kunjungan.index', [
            'students' => $students,
            'allStudents' => $allStudents,
            'totalStudents' => Student::count(),
            'classes' => Student::select('class_name')->distinct()->orderBy('class_name')->pluck('class_name'),
            'majors' => Student::whereNotNull('major')->select('major')->distinct()->orderBy('major')->pluck('major'),
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
            'nis' => ['nullable', 'string', 'max:50'],
            'class_name' => ['nullable', 'string', 'max:50'],
            'major' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'in:L,P'],
            'visit_date' => ['required', 'date'],
            'complaint' => ['required', 'string', 'max:1000'],
            'initial_treatment' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:ditangani,dirujuk,pulang'],
        ]);

        if (! empty($validated['class_name']) && ! empty($validated['major'])) {
            $validated['class_name'] = Petugas::formatClassNameWithMajor($validated['class_name'], $validated['major']);
        }

        if ($request->filled('student_name')) {
            $inputName = trim((string) $request->input('student_name'));

            $student = null;
            if ($inputName !== '') {
                $student = Student::where('name', $inputName)->first();
            }

            if (! $student) {
                $student = Student::create([
                    'name' => $inputName !== '' ? $inputName : 'Siswa UKS',
                    'nis' => $request->filled('nis') ? trim((string) $request->input('nis')) : 'UKS-'.strtoupper(substr(uniqid(), -4)),
                    'class_name' => $validated['class_name'] ?? $request->input('class_name', '-') ?: '-',
                    'major' => $request->input('major') ?: null,
                    'gender' => $request->input('gender', 'L') ?: 'L',
                ]);
            } else {
                $updates = [];
                if ($inputName !== '' && $student->name !== $inputName) {
                    $updates['name'] = $inputName;
                }
                if ($request->filled('class_name')) {
                    $updates['class_name'] = $validated['class_name'] ?? $request->input('class_name');
                }
                if ($request->filled('major') && $student->major !== $request->input('major')) {
                    $updates['major'] = $request->input('major');
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

        return redirect()->route('students.index')->with('success', 'Data kunjungan berhasil dicatat ke sistem.');
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
            'student_id' => ['nullable', 'exists:students,id'],
            'student_name' => ['required_without:student_id', 'nullable', 'string', 'max:255'],
            'class_name' => ['nullable', 'string', 'max:50'],
            'major' => ['nullable', 'string', 'max:100'],
            'visit_date' => ['required', 'date'],
            'complaint' => ['required', 'string', 'max:1000'],
            'initial_treatment' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:ditangani,dirujuk,pulang'],
        ]);

        if (! empty($validated['class_name']) && ! empty($validated['major'])) {
            $validated['class_name'] = Petugas::formatClassNameWithMajor($validated['class_name'], $validated['major']);
        }

        if ($request->filled('student_name')) {
            $inputName = trim((string) $request->input('student_name'));
            $student = $visit->student;

            // Jika nama yang dimasukkan cocok dengan siswa lain yang sudah ada di database
            $existingOther = Student::where('name', $inputName)->where('id', '!=', $student?->id)->first();

            if ($existingOther) {
                $student = $existingOther;
                if ($request->filled('class_name')) {
                    $student->class_name = $validated['class_name'] ?? $request->input('class_name');
                }
                if ($request->filled('major')) {
                    $student->major = $request->input('major');
                }
                $student->save();
            } elseif ($student) {
                $student->name = $inputName;
                if ($request->filled('class_name')) {
                    $student->class_name = $validated['class_name'] ?? $request->input('class_name');
                }
                if ($request->filled('major')) {
                    $student->major = $request->input('major');
                }
                $student->save();
            } else {
                $student = Student::create([
                    'name' => $inputName,
                    'nis' => 'UKS-'.strtoupper(substr(uniqid(), -4)),
                    'class_name' => $validated['class_name'] ?? $request->input('class_name', '-') ?: '-',
                    'major' => $request->input('major') ?: null,
                    'gender' => 'L',
                ]);
            }
            $validated['student_id'] = $student->id;
        } elseif (! empty($validated['student_id'])) {
            $student = Student::find($validated['student_id']);
            if ($student) {
                if ($request->filled('class_name')) {
                    $student->class_name = $validated['class_name'] ?? $request->input('class_name');
                }
                if ($request->filled('major')) {
                    $student->major = $request->input('major');
                }
                $student->save();
            }
        }

        $visit->update([
            'student_id' => $validated['student_id'],
            'visit_date' => $validated['visit_date'],
            'complaint' => $validated['complaint'],
            'initial_treatment' => $validated['initial_treatment'] ?? null,
            'status' => $validated['status'],
        ]);

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

    /**
     * Export Data Laporan Kunjungan ke Format Excel (.xlsx) Per Tanggal / Filter
     */
    public function exportExcel(Request $request, VisitExportService $exportService): BinaryFileResponse
    {
        $today = now()->toDateString();
        $query = UksVisit::with(['student', 'handler'])
            ->orderBy('visit_date', 'asc')
            ->orderBy('id', 'asc');

        $periodLabel = 'Keseluruhan Data Riwayat Kunjungan';
        $filename = 'Laporan-Kunjungan-UKS-Semua-Tanggal.xlsx';

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = min($request->query('start_date'), $request->query('end_date'));
            $end = max($request->query('start_date'), $request->query('end_date'));
            $query->whereBetween('visit_date', [$start, $end]);
            $periodLabel = 'Periode '.Carbon::parse($start)->translatedFormat('d F Y').' - '.Carbon::parse($end)->translatedFormat('d F Y');
            $filename = 'Laporan-Kunjungan-UKS-'.$start.'-sd-'.$end.'.xlsx';
        } elseif ($request->filled('start_date')) {
            $query->whereDate('visit_date', '>=', $request->query('start_date'));
            $periodLabel = 'Mulai Tanggal '.Carbon::parse($request->query('start_date'))->translatedFormat('d F Y');
            $filename = 'Laporan-Kunjungan-UKS-Mulai-'.$request->query('start_date').'.xlsx';
        } elseif ($request->filled('end_date')) {
            $query->whereDate('visit_date', '<=', $request->query('end_date'));
            $periodLabel = 'Sampai Tanggal '.Carbon::parse($request->query('end_date'))->translatedFormat('d F Y');
            $filename = 'Laporan-Kunjungan-UKS-Sampai-'.$request->query('end_date').'.xlsx';
        } elseif ($request->filled('date')) {
            $date = Carbon::parse($request->query('date'));
            $query->whereDate('visit_date', $date->toDateString());
            $periodLabel = 'Tanggal '.$date->translatedFormat('d F Y');
            $filename = 'Laporan-Kunjungan-UKS-'.$date->format('Y-m-d').'.xlsx';
        } elseif ($request->filled('month')) {
            $parts = explode('-', (string) $request->query('month'));
            if (count($parts) === 2) {
                $query->whereYear('visit_date', $parts[0])
                    ->whereMonth('visit_date', $parts[1]);
                $monthDate = Carbon::createFromDate((int) $parts[0], (int) $parts[1], 1);
                $periodLabel = 'Bulan '.$monthDate->translatedFormat('F Y');
                $filename = 'Laporan-Kunjungan-UKS-Bulan-'.$parts[0].'-'.$parts[1].'.xlsx';
            }
        } elseif ($request->query('period') === 'today' || $request->query('filter') === 'today') {
            $query->whereDate('visit_date', $today);
            $periodLabel = 'Hari Ini ('.now()->translatedFormat('d F Y').')';
            $filename = 'Laporan-Kunjungan-UKS-'.now()->format('Y-m-d').'.xlsx';
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('q')) {
            $keyword = trim((string) $request->query('q'));
            $query->where(function ($sub) use ($keyword) {
                $sub->where('complaint', 'like', "%{$keyword}%")
                    ->orWhere('initial_treatment', 'like', "%{$keyword}%")
                    ->orWhereHas('student', function ($s) use ($keyword) {
                        $s->where('name', 'like', "%{$keyword}%")
                            ->orWhere('class_name', 'like', "%{$keyword}%")
                            ->orWhere('major', 'like', "%{$keyword}%");
                    });
            });
        }

        $visits = $query->get();
        $filePath = $exportService->exportVisits($visits, $periodLabel);

        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
