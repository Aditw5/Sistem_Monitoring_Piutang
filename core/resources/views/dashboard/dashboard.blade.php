@extends('dash.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="text-center mb-4">
        <h1>Selamat Datang Di SIMP POS</h1>
        <h2>Sistem Informasi Monitoring Piutang POS</h2>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Mitra</h5>
                    <p class="card-text">{{ $totalMitra }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Piutang Mitra</h5>
                    <p class="card-text">{{ $totalPiutang }}</p>
                </div>
            </div>
        </div>
   

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Piutang Belum Validasi</h5>
                    <p class="card-text">{{ $totalPiutangBelumValidasi }}</p>
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection
