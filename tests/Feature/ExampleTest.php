<?php

namespace Tests\Feature;

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

        $response->assertOk()->assertViewIs('home');
    }

    public function test_guest_can_view_public_layanan(): void
    {
        $response = $this->get('/layanan');

        $response->assertOk()->assertViewIs('public.layanan');
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
}
