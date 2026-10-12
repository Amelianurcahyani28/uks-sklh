<?php

namespace App\Http\Controllers;

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

    public function layanan(): View
    {
        return view('public.layanan', [
            'totalVisits' => UksVisit::count(),
            'studentCount' => Student::count(),
        ]);
    }

    public function hubungi(): View
    {
        return view('public.hubungi');
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
                        ->orWhere('class_name', 'like', "%{$keyword}%");
                });
            }
            $studentsData = $studentQuery->paginate(12)->withQueryString();
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
                                ->orWhere('class_name', 'like', "%{$keyword}%");
                        });
                });
            }

            $visitsData = $visitQuery->paginate(12)->withQueryString();
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

        $filter = $request->query('filter');
        $status = $request->query('status');

        $query = UksVisit::with(['student' => function ($q) {
            $q->withCount('visits');
        }])->orderByDesc('visit_date')->orderByDesc('id');

        if ($filter === 'today') {
            $query->whereDate('visit_date', $today);
        } elseif ($filter === 'month') {
            $query->whereBetween('visit_date', [$monthStart, $today]);
        }

        if ($status && in_array($status, ['ditangani', 'dirujuk', 'pulang'])) {
            $query->where('status', $status);
        }

        $recentVisits = $query->limit(50)->get();

        return view('public.kunjungan', [
            'todayVisits' => $todayVisits,
            'monthVisits' => $monthVisits,
            'totalVisits' => $totalVisits,
            'recentVisits' => $recentVisits,
            'activeFilter' => $filter,
            'activeStatus' => $status,
        ]);
    }

    public function createVisit(): View
    {
        return view('public.kunjungan-create', [
            'students' => Student::orderBy('name')->get(['id', 'nis', 'name', 'class_name', 'gender']),
        ]);
    }
}
