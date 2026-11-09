<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\PetugasJadwal;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetugasController extends Controller
{
    /**
     * Tampilkan daftar petugas UKS di halaman admin.
     */
    public function index(Request $request): View
    {
        $query = Petugas::with('jadwals');

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('q')) {
            $keyword = trim((string) $request->query('q'));
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('role_title', 'like', "%{$keyword}%")
                    ->orWhere('class_name', 'like', "%{$keyword}%")
                    ->orWhere('major', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%")
                    ->orWhere('schedule', 'like', "%{$keyword}%");
            });
        }

        $petugas = $query->orderByRaw("CASE WHEN status = 'aktif' THEN 1 ELSE 2 END")
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.index', [
            'petugas' => $petugas,
            'allStudents' => Student::orderBy('name')->get(['id', 'name', 'class_name', 'major', 'gender']),
            'totalCount' => Petugas::count(),
            'aktifCount' => Petugas::where('status', 'aktif')->count(),
            'nonaktifCount' => Petugas::where('status', 'nonaktif')->count(),
            'daysList' => PetugasJadwal::daysList(),
        ]);
    }

    /**
     * Halaman formulir tambah petugas UKS baru.
     */
    public function create(): View
    {
        return view('petugas.create', [
            'allStudents' => Student::orderBy('name')->get(['id', 'name', 'class_name', 'major', 'gender']),
            'daysList' => PetugasJadwal::daysList(),
        ]);
    }

    /**
     * Simpan data petugas UKS baru dan otomatis pasangkan jadwal piket.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_title' => ['required', 'string', 'max:255'],
            'class_name' => ['nullable', 'string', 'max:50'],
            'major' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', 'in:L,P'],
            'phone' => ['nullable', 'string', 'max:30'],
            'piket_day' => ['nullable', 'integer', 'between:1,5'],
            'shift_time' => ['nullable', 'string', 'max:100'],
            'room' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:aktif,nonaktif'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $days = PetugasJadwal::daysList();
        $piketDay = ! empty($validated['piket_day']) ? (int) $validated['piket_day'] : null;
        $shiftTime = ! empty($validated['shift_time']) ? trim($validated['shift_time']) : '06:30 - 15:00 WIB';
        $room = ! empty($validated['room']) ? trim($validated['room']) : 'Ruang UKS';

        if ($piketDay && isset($days[$piketDay])) {
            $validated['schedule'] = $days[$piketDay]." ({$shiftTime})";
        } else {
            $validated['schedule'] = 'Sesuai Jam Operasional UKS';
        }

        if (! empty($validated['class_name']) && ! empty($validated['major'])) {
            $validated['class_name'] = Petugas::formatClassNameWithMajor($validated['class_name'], $validated['major']);
        }

        $petugas = Petugas::create($validated);

        if ($piketDay && isset($days[$piketDay])) {
            PetugasJadwal::updateOrCreate(
                [
                    'day_number' => $piketDay,
                    'petugas_id' => $petugas->id,
                ],
                [
                    'day' => $days[$piketDay],
                    'shift_time' => $shiftTime,
                    'room' => $room,
                    'status' => $petugas->status,
                ]
            );
        }

        return redirect()->route('petugas.index')->with('success', 'Data petugas UKS dan jadwal piket berhasil ditambahkan.');
    }

    /**
     * Halaman formulir edit data petugas UKS.
     */
    public function edit(Petugas $petugas): View
    {
        $petugas->load('jadwals');
        $primaryJadwal = $petugas->jadwals->first();

        return view('petugas.edit', [
            'petugas' => $petugas,
            'primaryJadwal' => $primaryJadwal,
            'daysList' => PetugasJadwal::daysList(),
        ]);
    }

    /**
     * Perbarui data petugas UKS dan otomatis perbarui jadwal piketnya di database.
     */
    public function update(Request $request, Petugas $petugas): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_title' => ['required', 'string', 'max:255'],
            'class_name' => ['nullable', 'string', 'max:50'],
            'major' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', 'in:L,P'],
            'phone' => ['nullable', 'string', 'max:30'],
            'piket_day' => ['nullable', 'integer', 'between:1,5'],
            'shift_time' => ['nullable', 'string', 'max:100'],
            'room' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:aktif,nonaktif'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $days = PetugasJadwal::daysList();
        $piketDay = ! empty($validated['piket_day']) ? (int) $validated['piket_day'] : null;
        $shiftTime = ! empty($validated['shift_time']) ? trim($validated['shift_time']) : '06:30 - 15:00 WIB';
        $room = ! empty($validated['room']) ? trim($validated['room']) : 'Ruang UKS';

        if ($piketDay && isset($days[$piketDay])) {
            $validated['schedule'] = $days[$piketDay]." ({$shiftTime})";
        } else {
            $validated['schedule'] = 'Sesuai Jam Operasional UKS';
        }

        if (! empty($validated['class_name']) && ! empty($validated['major'])) {
            $validated['class_name'] = Petugas::formatClassNameWithMajor($validated['class_name'], $validated['major']);
        }

        $petugas->update($validated);

        if ($piketDay && isset($days[$piketDay])) {
            PetugasJadwal::updateOrCreate(
                [
                    'petugas_id' => $petugas->id,
                ],
                [
                    'day_number' => $piketDay,
                    'day' => $days[$piketDay],
                    'shift_time' => $shiftTime,
                    'room' => $room,
                    'status' => $petugas->status,
                ]
            );
        } elseif ($request->has('piket_day') && empty($piketDay)) {
            PetugasJadwal::where('petugas_id', $petugas->id)->delete();
        }

        return redirect()->route('petugas.index')->with('success', 'Data petugas UKS dan jadwal piket berhasil diperbarui.');
    }

    /**
     * Hapus data petugas UKS dari database.
     */
    public function destroy(Petugas $petugas): RedirectResponse
    {
        $petugas->delete();

        return redirect()->route('petugas.index')->with('success', 'Data petugas UKS berhasil dihapus.');
    }

    /**
     * Halaman daftar dan manajemen jadwal piket petugas UKS (Senin - Jumat).
     */
    public function jadwalIndex(Request $request): View
    {
        $daysList = PetugasJadwal::daysList();
        $selectedDay = $request->query('day');

        $query = PetugasJadwal::with('petugas')->whereBetween('day_number', [1, 5]);

        if ($selectedDay && isset($daysList[(int) $selectedDay])) {
            $query->where('day_number', (int) $selectedDay);
        }

        $jadwals = $query->orderBy('day_number')
            ->orderBy('id')
            ->get();

        $allPetugas = Petugas::where('status', 'aktif')->orderBy('name')->get();

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

        $todayJadwalCount = PetugasJadwal::where('day_number', $todayDayNumber)->where('status', 'aktif')->count();

        // Siapkan jadwal per hari Senin - Jumat
        $weeklyCards = [];
        $allJadwals = PetugasJadwal::with('petugas')->whereBetween('day_number', [1, 5])->orderBy('day_number')->get();
        foreach ($daysList as $num => $dayName) {
            $weeklyCards[$num] = [
                'day' => $dayName,
                'day_number' => $num,
                'items' => $allJadwals->where('day_number', $num),
            ];
        }

        $todayItems = $allJadwals->where('day_number', $todayDayNumber);

        return view('petugas.jadwal', [
            'jadwals' => $jadwals,
            'daysList' => $daysList,
            'selectedDay' => $selectedDay ? (int) $selectedDay : null,
            'allPetugas' => $allPetugas,
            'todayDayNumber' => $todayDayNumber,
            'todayDayName' => $todayDayName,
            'todayFormatted' => $todayFormatted,
            'isWeekday' => $isWeekday,
            'todayJadwalCount' => $todayJadwalCount,
            'todayItems' => $todayItems,
            'totalJadwal' => PetugasJadwal::whereBetween('day_number', [1, 5])->count(),
            'weeklyCards' => $weeklyCards,
        ]);
    }

    /**
     * Simpan jadwal piket baru (Senin - Jumat).
     */
    public function jadwalStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'day_number' => ['required', 'integer', 'between:1,5'],
            'petugas_id' => ['required', 'exists:petugas,id'],
            'shift_time' => ['required', 'string', 'max:100'],
            'room' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $days = PetugasJadwal::daysList();
        $validated['day'] = $days[$validated['day_number']] ?? 'Senin';
        if (empty($validated['room'])) {
            $validated['room'] = 'Ruang UKS';
        }

        $newJadwal = PetugasJadwal::create($validated);

        if (! empty($validated['notes'])) {
            $newJadwal->petugas?->update(['role_title' => $validated['notes']]);
        }

        return redirect()->route('petugas.jadwal')->with('success', 'Jadwal piket petugas UKS berhasil ditambahkan.');
    }

    /**
     * Perbarui jadwal piket petugas UKS (ubah petugas, jam dinas, atau ruangan).
     */
    public function jadwalUpdate(Request $request, PetugasJadwal $jadwal): RedirectResponse
    {
        $validated = $request->validate([
            'day_number' => ['required', 'integer', 'between:1,5'],
            'petugas_id' => ['required', 'exists:petugas,id'],
            'shift_time' => ['required', 'string', 'max:100'],
            'room' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $days = PetugasJadwal::daysList();
        $validated['day'] = $days[$validated['day_number']] ?? 'Senin';
        if (empty($validated['room'])) {
            $validated['room'] = 'Ruang UKS';
        }

        $jadwal->update($validated);

        if (! empty($validated['notes'])) {
            $jadwal->petugas?->update(['role_title' => $validated['notes']]);
        }

        return redirect()->route('petugas.jadwal')->with('success', 'Jadwal piket petugas UKS berhasil diperbarui.');
    }

    /**
     * Hapus jadwal piket petugas UKS.
     */
    public function jadwalDestroy(PetugasJadwal $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return redirect()->route('petugas.jadwal')->with('success', 'Jadwal piket petugas UKS berhasil dihapus.');
    }
}
