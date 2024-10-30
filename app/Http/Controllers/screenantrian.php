<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class screenantrian extends Controller
{
    // public function index(){
    //     $client = new Client();

    //     $antrianUmumUrl = 'http://localhost:8069/api/antrian_umum';
    //     $antrianJaminanUrl = 'http://localhost:8069/api/antrian_jaminan';

    //     try {
    //         $responseUmum = $client->get($antrianUmumUrl, [
    //             'headers' => [
    //                 'Accept' => 'application/json',
    //                 'Content-Type' => 'application/json',
                   
    //             ],
    //         ]);

    //         Log::info('Request ke API antrian umum berhasildsadaadasd', [
    //             'url' => $antrianUmumUrl,
    //             'status_code' => $responseUmum->getStatusCode()
    //         ]);

    //         $responseJaminan = $client->get($antrianJaminanUrl, [
    //             'headers' => [
    //                 'Accept' => 'application/json',
    //                 'Content-Type' => 'application/json',
                    
    //             ],
    //         ]);

    //         Log::info('Request ke API antrian jaminan berhasil', [
    //             'url' => $antrianJaminanUrl,
    //             'status_code' => $responseJaminan->getStatusCode()
    //         ]);

    //         $dataUmum = json_decode($responseUmum->getBody()->getContents(), true);
    //         $dataJaminan = json_decode($responseJaminan->getBody()->getContents(), true);

    //         $antrianUmum = $dataUmum['data'][0]['no_appointment'] ?? 'N/A';
    //         $antrianJaminan = $dataJaminan['data'][0]['no_appointment'] ?? 'N/A';
    //         $poliUmum = $dataUmum['data'][0]['poli'] ?? 'N/A';
    //         $poliJaminan = $dataJaminan['data'][0]['poli'] ?? 'N/A';

    //         Log::info('Data antrian umum', [
    //             'no_appointment' => $antrianUmum,
    //             'poli' => $poliUmum,
    //         ]);

    //         Log::info('Data antrian jaminan', [
    //             'no_appointment' => $antrianJaminan,
    //             'poli' => $poliJaminan,
    //         ]);

    //     } catch (\Exception $e) {
    //         Log::error('Terjadi kesalahan saat mengambil data antrian', [
    //             'message' => $e->getMessage(),
    //         ]);

    //         return view('antrian.baris', [
    //             'antrianUmum' => 'Error',
    //             'antrianJaminan' => 'Error',
    //             'poliUmum' => 'Error',
    //             'poliJaminan' => 'Error',
    //         ]);
    //     }

    //     return view('antrian.baris', [
    //         'antrianUmum' => $antrianUmum,
    //         'antrianJaminan' => $antrianJaminan,
    //         'poliUmum' => $poliUmum,
    //         'poliJaminan' => $poliJaminan,
    //     ]);
    // }

    public function index()
    {
        $client = new Client();
        $antrianUmumUrl = 'http://localhost:8069/api/antrian_umum';
        $antrianJaminanUrl = 'http://localhost:8069/api/antrian_jaminan';

        try {
            $responseUmum = $client->get($antrianUmumUrl);
            $responseJaminan = $client->get($antrianJaminanUrl);

            $dataUmum = json_decode($responseUmum->getBody(), true);
            $dataJaminan = json_decode($responseJaminan->getBody(), true);

            $antrianUmum = $dataUmum['data'][0]['no_appointment'] ?? 'N/A';
            $poliUmum = $dataUmum['data'][0]['poli'] ?? 'N/A';
            $antrianJaminan = $dataJaminan['data'][0]['no_appointment'] ?? 'N/A';
            $poliJaminan = $dataJaminan['data'][0]['poli'] ?? 'N/A';

            if (request()->ajax()) {
                return response()->json([
                    'antrianUmum' => $antrianUmum,
                    'poliUmum' => $poliUmum,
                    'antrianJaminan' => $antrianJaminan,
                    'poliJaminan' => $poliJaminan,
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'antrianUmum' => 'Error',
                'poliUmum' => 'Error',
                'antrianJaminan' => 'Error',
                'poliJaminan' => 'Error',
            ]);
        }

        return view('antrian.baris', compact('antrianUmum', 'antrianJaminan', 'poliUmum', 'poliJaminan'));
    }


    public function speakQueue(Request $request)
    {
        $type = $request->input('type');
        $queueNumber = $request->input('queueNumber');
        $poli = $type === 'bpjs' ? 'POLI THT' : 'POLI MULUT';
        $message = "Nomor antrian {$queueNumber}, silahkan menuju {$poli}";
        Log::info('speakQueue API called', [
            'type' => $type,
            'queueNumber' => $queueNumber,
            'poli' => $poli,
            'message' => $message
        ]);
       
        return response()->json(['message' => $message]);
    }
    public function helo(){
        Log::info('API Pemeriksaan Dokter terpanggil.');
        return view('hala');
    }
}
