<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class screenantrian extends Controller
{
    public function index(){
        // Membuat client Guzzle untuk melakukan request ke API Odoo
        $client = new Client();

        // URL API Odoo untuk antrian umum dan antrian jaminan
        $antrianUmumUrl = 'http://localhost:8069/api/antrian_umum';
        $antrianJaminanUrl = 'http://localhost:8069/api/antrian_jaminan';

        try {
            // Mengirim request GET ke API Odoo untuk antrian umum
            $responseUmum = $client->get($antrianUmumUrl, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    // Tambahkan token jika API Odoo butuh autentikasi
                    // 'Authorization' => 'Bearer YOUR_API_TOKEN'
                ],
            ]);

            // Logging response status dan URL untuk debugging
            Log::info('Request ke API antrian umum berhasil', [
                'url' => $antrianUmumUrl,
                'status_code' => $responseUmum->getStatusCode()
            ]);

            // Mengirim request GET ke API Odoo untuk antrian jaminan
            $responseJaminan = $client->get($antrianJaminanUrl, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    // 'Authorization' => 'Bearer YOUR_API_TOKEN'
                ],
            ]);

            Log::info('Request ke API antrian jaminan berhasil', [
                'url' => $antrianJaminanUrl,
                'status_code' => $responseJaminan->getStatusCode()
            ]);

            // Parsing response dari API ke array
            $dataUmum = json_decode($responseUmum->getBody()->getContents(), true);
            $dataJaminan = json_decode($responseJaminan->getBody()->getContents(), true);

            // Mengambil data antrian yang dibutuhkan
            $antrianUmum = $dataUmum['data'][0]['no_appointment'] ?? 'N/A';
            $antrianJaminan = $dataJaminan['data'][0]['no_appointment'] ?? 'N/A';
            $poliUmum = $dataUmum['data'][0]['poli'] ?? 'N/A';
            $poliJaminan = $dataJaminan['data'][0]['poli'] ?? 'N/A';

            // Logging ID antrian
            Log::info('Data antrian umum', [
                'no_appointment' => $antrianUmum,
                'poli' => $poliUmum,
            ]);

            Log::info('Data antrian jaminan', [
                'no_appointment' => $antrianJaminan,
                'poli' => $poliJaminan,
            ]);

        } catch (\Exception $e) {
            // Log error jika ada masalah dengan request
            Log::error('Terjadi kesalahan saat mengambil data antrian', [
                'message' => $e->getMessage(),
            ]);

            return view('antrian.baris', [
                'antrianUmum' => 'Error',
                'antrianJaminan' => 'Error',
                'poliUmum' => 'Error',
                'poliJaminan' => 'Error',
            ]);
        }

        // Return view dengan data antrian yang diperoleh dari API Odoo
        return view('antrian.baris', [
            'antrianUmum' => $antrianUmum,
            'antrianJaminan' => $antrianJaminan,
            'poliUmum' => $poliUmum,
            'poliJaminan' => $poliJaminan,
        ]);
    }
}
