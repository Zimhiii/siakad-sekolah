<?php

namespace App\Controllers;

use App\Libraries\MockData;

class Auth extends BaseController
{
    public function index()
    {
        return $this->login();
    }

    public function login()
    {
        $session = session();
        $isError = (bool) $this->request->getGet('error');
        
        $data = [
            'title' => 'Masuk ke Akun - SIAKAD',
            'sekolah' => MockData::getSekolah(),
            'isError' => $isError,
            'currentRole' => $session->get('role') ?? 'admin'
        ];

        return view('auth/login', $data);
    }

    public function doLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $selectedRole = $this->request->getPost('role') ?? 'admin';

        if ($username === 'salah' || $password === 'salah') {
            return redirect()->to('/auth/login?error=1');
        }

        // Auto determine role if standard username
        $role = $selectedRole;
        if (str_starts_with($username, 'guru')) {
            $role = 'guru';
        } elseif (str_starts_with($username, 'tu')) {
            $role = 'tu';
        } elseif (str_starts_with($username, 'siswa') || str_starts_with($username, 'alumni')) {
            $role = 'siswa';
        } elseif (str_starts_with($username, 'admin')) {
            $role = 'admin';
        }

        session()->set([
            'isLoggedIn' => true,
            'role' => $role,
            'username' => $username ?: 'admin',
            'nama_user' => match($role) {
                'admin' => 'Administrator Sekolah',
                'guru' => 'Ustadz Hendra Gunawan, M.Pd.',
                'tu' => 'M. Taufik Hidayat, S.Sos.',
                'siswa' => 'Muhammad Raihan Pratama',
                default => 'Pengguna SIAKAD'
            }
        ]);

        return redirect()->to('/' . $role)->with('success', 'Selamat datang kembali di SIAKAD!');
    }

    public function switchRole($role = 'admin')
    {
        $validRoles = ['admin', 'guru', 'tu', 'siswa'];
        if (!in_array($role, $validRoles)) {
            $role = 'admin';
        }

        session()->set([
            'isLoggedIn' => true,
            'role' => $role,
            'username' => match($role) {
                'admin' => 'admin',
                'guru' => 'guru.hendra',
                'tu' => 'tu.taufik',
                'siswa' => 'siswa.raihan',
            },
            'nama_user' => match($role) {
                'admin' => 'Administrator Utama',
                'guru' => 'Ustadz Hendra Gunawan, M.Pd.',
                'tu' => 'M. Taufik Hidayat, S.Sos.',
                'siswa' => 'Muhammad Raihan Pratama',
            }
        ]);

        return redirect()->to('/' . $role)->with('info', 'Mode peran dialihkan ke: ' . strtoupper($role));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Anda telah berhasil keluar.');
    }
}
