<?php

namespace Tests\Feature;

use App\Models\Petugas;
use App\Models\PetugasJadwal;
use App\Models\Student;
use App\Models\UksVisit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_guest_can_view_public_home(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertViewIs('home')
            ->assertDontSee('Siswa Merasa Sakit di Sekolah?');
    }

    public function test_guest_is_redirected_from_layanan_to_home(): void
    {
        $response = $this->get('/layanan');

        $response->assertRedirect('/#layanan');
    }

    public function test_home_page_contains_layanan_and_fasilitas(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Pertolongan Pertama Pada Kecelakaan')
            ->assertSee('Fasilitas Dan Peralatan Medis UKS')
            ->assertSee('Alur Pelayanan Saat Merasa Sakit di Sekolah');
    }

    public function test_guest_can_view_public_ringkasan(): void
    {
        $response = $this->get('/ringkasan');

        $response->assertOk()->assertViewIs('public.ringkasan');
    }

    public function test_guest_can_filter_ringkasan_by_status(): void
    {
        $student = Student::create([
            'name' => 'Pasien Rujukan',
            'nis' => 'UKS-999',
            'class_name' => 'VIII A',
            'gender' => 'L',
        ]);

        UksVisit::create([
            'student_id' => $student->id,
            'visit_date' => now()->subMonth()->toDateString(),
            'complaint' => 'Sakit perut hebat',
            'initial_treatment' => 'Diberi obat',
            'status' => 'dirujuk',
        ]);

        $response = $this->get('/ringkasan?filter=month&status=dirujuk');

        $response->assertOk()
            ->assertViewIs('public.ringkasan')
            ->assertSee('Pasien Rujukan')
            ->assertSee('Sakit perut hebat');
    }

    public function test_guest_can_view_public_kunjungan(): void
    {
        $response = $this->get('/kunjungan-publik');

        $response->assertOk()->assertViewIs('public.kunjungan');
    }

    public function test_guest_can_view_public_kunjungan_create(): void
    {
        $response = $this->get('/isi-kunjungan');

        $response->assertOk()->assertViewIs('public.kunjungan-create');
    }

    public function test_public_visit_submission_is_saved_for_admin(): void
    {
        $student = Student::create([
            'name' => 'Siswa Demo',
            'nis' => 'UKS-001',
            'class_name' => 'VII A',
            'gender' => 'L',
        ]);

        $response = $this->post('/isi-kunjungan', [
            'student_id' => $student->id,
            'visit_date' => now()->toDateString(),
            'complaint' => 'Pusing',
            'initial_treatment' => 'Istirahat',
            'status' => 'ditangani',
        ]);

        $response->assertRedirectToRoute('public.ringkasan');
        $this->assertDatabaseHas('uks_visits', [
            'student_id' => $student->id,
            'complaint' => 'Pusing',
        ]);
    }

    public function test_guest_can_submit_visit_with_manual_student_name(): void
    {
        $response = $this->post('/isi-kunjungan', [
            'student_name' => 'Budi Santoso',
            'class_name' => 'VIII B',
            'gender' => 'L',
            'visit_date' => now()->toDateString(),
            'complaint' => 'Sakit perut',
            'initial_treatment' => 'Minyak kayu putih',
            'status' => 'ditangani',
        ]);

        $response->assertRedirectToRoute('public.ringkasan');
        $this->assertDatabaseHas('students', [
            'name' => 'Budi Santoso',
            'class_name' => 'VIII B',
        ]);
        $this->assertDatabaseHas('uks_visits', [
            'complaint' => 'Sakit perut',
        ]);
    }

    public function test_guest_can_submit_visit_with_custom_nis(): void
    {
        $response = $this->post('/isi-kunjungan', [
            'nis' => '10293847',
            'student_name' => 'Rina Nose',
            'class_name' => 'IX C',
            'gender' => 'P',
            'visit_date' => now()->toDateString(),
            'complaint' => 'Pusing dan demam',
            'initial_treatment' => 'Kompres hangat',
            'status' => 'ditangani',
        ]);

        $response->assertRedirectToRoute('public.ringkasan');
        $this->assertDatabaseHas('students', [
            'nis' => '10293847',
            'name' => 'Rina Nose',
            'class_name' => 'IX C',
            'gender' => 'P',
        ]);
        $this->assertDatabaseHas('uks_visits', [
            'complaint' => 'Pusing dan demam',
        ]);
    }

    public function test_guest_can_submit_visit_with_major(): void
    {
        $response = $this->post('/isi-kunjungan', [
            'student_name' => 'Ahmad Fikri',
            'class_name' => 'X PPLG 1',
            'major' => 'PPLG',
            'gender' => 'L',
            'visit_date' => now()->toDateString(),
            'complaint' => 'Flu dan batuk',
            'initial_treatment' => 'Istirahat di UKS',
            'status' => 'ditangani',
        ]);

        $response->assertRedirectToRoute('public.ringkasan');
        $this->assertDatabaseHas('students', [
            'name' => 'Ahmad Fikri',
            'class_name' => 'X PPLG 1',
            'major' => 'PPLG',
        ]);
        $this->assertDatabaseHas('uks_visits', [
            'complaint' => 'Flu dan batuk',
        ]);
    }

    public function test_user_can_login_and_view_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirectToRoute('dashboard');
        $this->assertAuthenticatedAs($user);
        $this->get('/dashboard')->assertOk()->assertViewIs('dashboard');
    }

    public function test_guest_cannot_export_visits(): void
    {
        $response = $this->get('/admin/kunjungan/export');

        $response->assertRedirectToRoute('login');
    }

    public function test_authenticated_admin_can_export_visits_to_excel(): void
    {
        $user = User::factory()->create();
        $student = Student::create([
            'name' => 'Siswa Test Export',
            'nis' => 'UKS-EXP1',
            'class_name' => 'X PPLG 1',
            'gender' => 'L',
        ]);

        UksVisit::create([
            'student_id' => $student->id,
            'visit_date' => now()->toDateString(),
            'complaint' => 'Demam dan pusing',
            'initial_treatment' => 'Istirahat di UKS',
            'status' => 'ditangani',
            'handled_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/admin/kunjungan/export');

        $response->assertOk();
        $this->assertTrue(str_contains((string) $response->headers->get('content-type'), 'spreadsheetml.sheet'));
        $this->assertTrue(str_contains((string) $response->headers->get('content-disposition'), 'attachment'));
    }

    public function test_authenticated_admin_can_export_visits_by_date(): void
    {
        $user = User::factory()->create();
        $targetDate = '2026-10-15';

        $student = Student::create([
            'name' => 'Siswa Tanggal Khusus',
            'nis' => 'UKS-EXP2',
            'class_name' => 'XI TJKT 2',
            'gender' => 'P',
        ]);

        UksVisit::create([
            'student_id' => $student->id,
            'visit_date' => $targetDate,
            'complaint' => 'Sakit perut',
            'status' => 'pulang',
        ]);

        $response = $this->actingAs($user)->get('/admin/kunjungan/export?date='.$targetDate);

        $response->assertOk();
        $this->assertTrue(str_contains((string) $response->headers->get('content-disposition'), 'Laporan-Kunjungan-UKS-2026-10-15.xlsx'));
    }

    public function test_authenticated_admin_can_filter_and_export_visits_by_date_range(): void
    {
        $user = User::factory()->create();

        $student = Student::create([
            'name' => 'Siswa Rentang Tanggal',
            'nis' => 'UKS-RANGE',
            'class_name' => 'X BCF 1',
            'major' => 'BCF',
            'gender' => 'P',
        ]);

        UksVisit::create([
            'student_id' => $student->id,
            'visit_date' => '2026-10-10',
            'complaint' => 'Pusing rentang tanggal',
            'status' => 'ditangani',
        ]);

        // 1. Filter halaman admin ringkasan dengan rentang tanggal awal dan akhir
        $responseFilter = $this->actingAs($user)->get('/admin/ringkasan?start_date=2026-10-01&end_date=2026-10-20');
        $responseFilter->assertOk()
            ->assertSee('Tanggal Awal')
            ->assertSee('Tanggal Akhir')
            ->assertSee('Pusing rentang tanggal');

        // 2. Export ke Excel dengan rentang tanggal
        $responseExport = $this->actingAs($user)->get('/admin/kunjungan/export?start_date=2026-10-01&end_date=2026-10-20');
        $responseExport->assertOk();
        $this->assertTrue(str_contains((string) $responseExport->headers->get('content-disposition'), '2026-10-01-sd-2026-10-20.xlsx'));
    }

    public function test_guest_can_view_public_petugas_page(): void
    {
        $todayDay = now()->dayOfWeekIso;
        $petugas = Petugas::factory()->create([
            'name' => 'Ns. Siti Rahmawati',
            'role_title' => 'Tenaga Medis UKS',
            'status' => 'aktif',
        ]);

        PetugasJadwal::create([
            'petugas_id' => $petugas->id,
            'day_number' => $todayDay,
            'day' => PetugasJadwal::allDaysList()[$todayDay] ?? 'Senin',
            'shift_time' => '07:30 - 15:30 WIB',
            'room' => 'Ruang UKS',
            'status' => 'aktif',
        ]);

        $response = $this->get('/petugas');

        $response->assertOk()
            ->assertViewIs('public.petugas')
            ->assertSee('Agenda Piket Hari Ini')
            ->assertDontSee('Daftar Tim UKS SMKN 1 Ciomas')
            ->assertDontSee('Siswa Merasa Sakit di Sekolah?');

        if ($todayDay >= 1 && $todayDay <= 5) {
            $response->assertSee('Ns. Siti Rahmawati')
                ->assertSee('Tenaga Medis UKS');
        }
    }

    public function test_guest_can_view_today_petugas_schedule_on_public_petugas_page(): void
    {
        $todayDay = now()->dayOfWeekIso;
        $petugas = Petugas::factory()->create([
            'name' => 'Petugas Jaga Hari Ini',
            'role_title' => 'Koordinator PMR',
            'status' => 'aktif',
        ]);

        PetugasJadwal::create([
            'petugas_id' => $petugas->id,
            'day_number' => $todayDay,
            'day' => PetugasJadwal::allDaysList()[$todayDay] ?? 'Senin',
            'shift_time' => '08:00 - 14:00 WIB',
            'room' => 'Ruang UKS',
            'status' => 'aktif',
        ]);

        $response = $this->get('/petugas');

        $response->assertOk()
            ->assertSee('Agenda Piket Hari Ini')
            ->assertSee('Petugas Jaga Hari Ini')
            ->assertSee('08:00 - 14:00 WIB');
    }

    public function test_guest_cannot_access_admin_petugas(): void
    {
        $response = $this->get('/admin/petugas');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_admin_petugas(): void
    {
        $user = User::factory()->create();
        Petugas::factory()->create([
            'name' => 'Dra. Hj. Nurjanah',
        ]);

        $response = $this->actingAs($user)->get('/admin/petugas');

        $response->assertOk()
            ->assertViewIs('petugas.index')
            ->assertViewHas('daysList')
            ->assertSee('Tambah Petugas Baru')
            ->assertSee('modalTambahPetugas')
            ->assertSee('Kelas')
            ->assertSee('Jurusan')
            ->assertDontSee('Lihat Tampilan Publik')
            ->assertSee('Dra. Hj. Nurjanah');
    }

    public function test_admin_can_create_petugas(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/petugas', [
            'name' => 'Petugas Baru UKS',
            'role_title' => 'Petugas P3K',
            'class_name' => 'XI PPLG 2',
            'major' => 'PPLG',
            'gender' => 'L',
            'phone' => '081299998888',
            'schedule' => 'Senin - Jumat',
            'status' => 'aktif',
            'bio' => 'Petugas sigap P3K',
        ]);

        $response->assertRedirect('/admin/petugas');
        $this->assertDatabaseHas('petugas', [
            'name' => 'Petugas Baru UKS',
            'role_title' => 'Petugas P3K',
            'class_name' => 'XI PPLG 2',
            'major' => 'PPLG',
        ]);
    }

    public function test_admin_can_update_petugas(): void
    {
        $user = User::factory()->create();
        $petugas = Petugas::factory()->create([
            'name' => 'Nama Lama',
            'role_title' => 'Staf UKS',
            'major' => 'BCF',
        ]);

        $response = $this->actingAs($user)->put('/admin/petugas/'.$petugas->id, [
            'name' => 'Nama Baru Petugas',
            'role_title' => 'Pembina UKS',
            'class_name' => 'XII ANIM 1',
            'major' => 'ANIM',
            'gender' => 'P',
            'phone' => '081200001111',
            'schedule' => 'Setiap Hari',
            'status' => 'aktif',
            'bio' => 'Diperbarui',
        ]);

        $response->assertRedirect('/admin/petugas');
        $this->assertDatabaseHas('petugas', [
            'id' => $petugas->id,
            'name' => 'Nama Baru Petugas',
            'role_title' => 'Pembina UKS',
            'class_name' => 'XII ANIM 1',
            'major' => 'ANIM',
        ]);
    }

    public function test_petugas_class_name_automatically_includes_major(): void
    {
        $user = User::factory()->create();

        // 1. Simpan Petugas baru dengan kelas "X 1" dan jurusan "BCF"
        $createResponse = $this->actingAs($user)->post('/admin/petugas', [
            'name' => 'Siswa Petugas 1',
            'role_title' => 'Anggota PMR',
            'class_name' => 'X 1',
            'major' => 'BCF',
            'gender' => 'P',
            'status' => 'aktif',
        ]);

        $createResponse->assertRedirect('/admin/petugas');
        $this->assertDatabaseHas('petugas', [
            'name' => 'Siswa Petugas 1',
            'class_name' => 'X BCF 1',
            'major' => 'BCF',
        ]);

        $petugas = Petugas::where('name', 'Siswa Petugas 1')->firstOrFail();

        // 2. Update Petugas dengan kelas "XI" dan jurusan "BCF"
        $updateResponse = $this->actingAs($user)->put('/admin/petugas/'.$petugas->id, [
            'name' => 'Siswa Petugas 1',
            'role_title' => 'Anggota PMR',
            'class_name' => 'XI',
            'major' => 'BCF',
            'gender' => 'P',
            'status' => 'aktif',
        ]);

        $updateResponse->assertRedirect('/admin/petugas');
        $this->assertDatabaseHas('petugas', [
            'id' => $petugas->id,
            'class_name' => 'XI BCF',
            'major' => 'BCF',
        ]);

        // 3. Pastikan tampil di tabel halaman admin petugas
        $indexResponse = $this->actingAs($user)->get('/admin/petugas');
        $indexResponse->assertOk()->assertSee('XI BCF');
    }

    public function test_admin_can_delete_petugas(): void
    {
        $user = User::factory()->create();
        $petugas = Petugas::factory()->create([
            'name' => 'Petugas Dihapus',
        ]);

        $response = $this->actingAs($user)->delete('/admin/petugas/'.$petugas->id);

        $response->assertRedirect('/admin/petugas');
        $this->assertDatabaseMissing('petugas', [
            'id' => $petugas->id,
        ]);
    }

    public function test_admin_can_view_jadwal_petugas(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/jadwal-petugas');

        $response->assertOk()
            ->assertViewIs('petugas.jadwal')
            ->assertSee('Jadwal Petugas UKS')
            ->assertSee('Kelas')
            ->assertSee('Lihat Tampilan Publik');
    }

    public function test_admin_can_create_jadwal_petugas(): void
    {
        $user = User::factory()->create();
        $petugas = Petugas::factory()->create([
            'name' => 'Petugas Jadwal Baru',
        ]);

        $response = $this->actingAs($user)->post('/admin/jadwal-petugas', [
            'day_number' => 1,
            'petugas_id' => $petugas->id,
            'shift_time' => '07:30 - 15:30 WIB',
            'room' => 'Ruang UKS',
            'notes' => 'Piket Pemeriksaan Siswa',
            'status' => 'aktif',
        ]);

        $response->assertRedirect('/admin/jadwal-petugas');
        $this->assertDatabaseHas('petugas_jadwals', [
            'petugas_id' => $petugas->id,
            'day_number' => 1,
            'day' => 'Senin',
        ]);
    }

    public function test_admin_can_update_jadwal_petugas(): void
    {
        $user = User::factory()->create();
        $petugasLama = Petugas::factory()->create(['name' => 'Petugas Lama']);
        $petugasBaru = Petugas::factory()->create(['name' => 'Petugas Baru']);

        $jadwal = PetugasJadwal::create([
            'day_number' => 2,
            'day' => 'Selasa',
            'petugas_id' => $petugasLama->id,
            'shift_time' => '07:30 - 15:30 WIB',
            'room' => 'Ruang UKS',
            'notes' => 'Tugas awal',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->put('/admin/jadwal-petugas/'.$jadwal->id, [
            'day_number' => 2,
            'petugas_id' => $petugasBaru->id,
            'shift_time' => '08:00 - 14:00 WIB',
            'room' => 'Ruang UKS Baru',
            'notes' => 'Tugas telah diganti',
            'status' => 'aktif',
        ]);

        $response->assertRedirect('/admin/jadwal-petugas');
        $this->assertDatabaseHas('petugas_jadwals', [
            'id' => $jadwal->id,
            'petugas_id' => $petugasBaru->id,
            'shift_time' => '08:00 - 14:00 WIB',
        ]);
    }

    public function test_admin_can_delete_jadwal_petugas(): void
    {
        $user = User::factory()->create();
        $petugas = Petugas::factory()->create();

        $jadwal = PetugasJadwal::create([
            'day_number' => 3,
            'day' => 'Rabu',
            'petugas_id' => $petugas->id,
            'shift_time' => '07:30 - 15:30 WIB',
            'room' => 'Ruang UKS',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->delete('/admin/jadwal-petugas/'.$jadwal->id);

        $response->assertRedirect('/admin/jadwal-petugas');
        $this->assertDatabaseMissing('petugas_jadwals', [
            'id' => $jadwal->id,
        ]);
    }

    public function test_creating_petugas_automatically_assigns_jadwal_piket(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/admin/petugas', [
            'name' => 'Petugas Otomatis',
            'role_title' => 'Tenaga Medis',
            'gender' => 'L',
            'phone' => '08123456789',
            'piket_day' => 4, // Kamis
            'shift_time' => '06:30 - 15:00 WIB',
            'room' => 'Ruang UKS',
            'status' => 'aktif',
            'bio' => 'Petugas uji coba',
        ]);

        $response->assertRedirect('/admin/petugas');

        $petugas = Petugas::where('name', 'Petugas Otomatis')->first();
        $this->assertNotNull($petugas);
        $this->assertEquals('Kamis (06:30 - 15:00 WIB)', $petugas->schedule);

        $this->assertDatabaseHas('petugas_jadwals', [
            'petugas_id' => $petugas->id,
            'day_number' => 4,
            'day' => 'Kamis',
            'shift_time' => '06:30 - 15:00 WIB',
            'room' => 'Ruang UKS',
        ]);
    }

    public function test_admin_dashboard_displays_today_petugas_schedule(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk()
            ->assertSee('Agenda Piket Hari Ini')
            ->assertSee('Jadwal Piket Petugas UKS — Hari');
    }

    public function test_beranda_does_not_display_petugas_schedule(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertDontSee('Petugas UKS Siaga Hari Ini');
    }
}
