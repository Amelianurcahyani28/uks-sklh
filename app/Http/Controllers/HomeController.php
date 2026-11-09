<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\PetugasJadwal;
use App\Models\Student;
use App\Models\UksVisit;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $today = now()->toDateString();
        $monthStart = now()->startOfMonth()->toDateString();

        return view('home', [
            'todayVisits' => UksVisit::whereDate('visit_date', $today)->count(),
            'monthVisits' => UksVisit::whereBetween('visit_date', [$monthStart, $today])->count(),
            'totalVisits' => UksVisit::count(),
            'studentCount' => Student::count(),
        ]);
    }

    public function hubungi(): View
    {
        return view('public.hubungi');
    }

    public function petugas(Request $request): View
    {
        $query = Petugas::query();

        if ($request->filled('q')) {
            $keyword = trim((string) $request->query('q'));
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('role_title', 'like', "%{$keyword}%")
                    ->orWhere('schedule', 'like', "%{$keyword}%");
            });
        }

        $petugasList = $query->orderByRaw("CASE WHEN status = 'aktif' THEN 1 ELSE 2 END")
            ->latest('id')
            ->get();

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

        // Jadwal petugas piket khusus HARI INI yang terhubung langsung dengan jadwal admin
        $todaySchedules = PetugasJadwal::with('petugas')
            ->where('day_number', $todayDayNumber)
            ->where('status', 'aktif')
            ->whereHas('petugas', function ($query) {
                $query->where('status', 'aktif');
            })
            ->orderBy('id')
            ->get();

        return view('public.petugas', [
            'petugasList' => $petugasList,
            'totalPetugas' => Petugas::count(),
            'aktifCount' => Petugas::where('status', 'aktif')->count(),
            'todayDayNumber' => $todayDayNumber,
            'todayDayName' => $todayDayName,
            'todayFormatted' => $todayFormatted,
            'isWeekday' => $isWeekday,
            'todaySchedules' => $todaySchedules,
        ]);
    }

    public function summary(Request $request): View
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
                        ->orWhere('class_name', 'like', "%{$keyword}%")
                        ->orWhere('major', 'like', "%{$keyword}%");
                });
            }
            $studentsData = $studentQuery->paginate(10)->withQueryString();
        } else {
            $visitQuery = UksVisit::with(['student' => function ($q) {
                $q->withCount('visits');
            }])->latest('visit_date')->latest('id');

            if ($filter === 'today') {
                $visitQuery->whereDate('visit_date', $today);
            } elseif ($filter === 'month' && ! $status) {
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
                                ->orWhere('class_name', 'like', "%{$keyword}%")
                                ->orWhere('major', 'like', "%{$keyword}%");
                        });
                });
            }

            $visitsData = $visitQuery->paginate(10)->withQueryString();
        }

        return view('public.ringkasan', [
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

    public function kunjunganPublic(Request $request): View
    {
        $today = now()->toDateString();
        $monthStart = now()->startOfMonth()->toDateString();

        $todayVisits = UksVisit::whereDate('visit_date', $today)->count();
        $monthVisits = UksVisit::whereBetween('visit_date', [$monthStart, $today])->count();
        $totalVisits = UksVisit::count();

        $status = $request->query('status');
        $keyword = trim((string) $request->query('q', ''));

        $query = UksVisit::with(['student' => function ($q) {
            $q->withCount('visits');
        }])->whereDate('visit_date', $today)
            ->orderByDesc('visit_date')
            ->orderByDesc('id');

        if ($status && in_array($status, ['ditangani', 'dirujuk', 'pulang'])) {
            $query->where('status', $status);
        }

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('complaint', 'like', "%{$keyword}%")
                    ->orWhere('initial_treatment', 'like', "%{$keyword}%")
                    ->orWhereHas('student', function ($s) use ($keyword) {
                        $s->where('name', 'like', "%{$keyword}%")
                            ->orWhere('class_name', 'like', "%{$keyword}%")
                            ->orWhere('major', 'like', "%{$keyword}%");
                    });
            });
        }

        $recentVisits = $query->get()->unique(function ($item) {
            return $item->student_id ?? $item->id;
        })->values();

        return view('public.kunjungan', [
            'todayVisits' => $todayVisits,
            'monthVisits' => $monthVisits,
            'totalVisits' => $totalVisits,
            'recentVisits' => $recentVisits,
            'activeFilter' => 'today',
            'activeStatus' => $status,
        ]);
    }

    public function createVisit(): View
    {
        return view('public.kunjungan-create', [
            'students' => Student::orderBy('name')->get(['id', 'nis', 'name', 'class_name', 'major', 'gender']),
        ]);
    }
}
