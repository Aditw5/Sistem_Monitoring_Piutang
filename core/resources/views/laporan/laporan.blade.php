@extends('dash.layouts.app')

@section('title', 'LAPORAN')

@section('content')
<style>
    .text-success {
        color: green;
        font-weight: bold;
    }

    .text-danger {
        color: red;
        font-weight: bold;
    }
    
    /* Adjust the button widths */
    .btn-primary.w-100 {
        width: 100%;
    }
</style>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-xl-3 col-lg-3">
                <form id="filter-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input id="fromDate" type="date" name="fromDate" class="form-control" autocomplete="off" required placeholder="ex: !help">
                    </div>
                </form>
            </div>
            <div class="col-12 col-xl-3 col-lg-3">
                <form id="filter-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input id="toDate" type="date" name="toDate" class="form-control" autocomplete="off" required placeholder="ex: !help">
                    </div>
                </form>
            </div>
            <div class="col-12 col-xl-3 col-lg-3 align-self-end mb-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-12 col-xl-3 col-lg-3 align-self-end mb-3">
                <label class="form-label">&nbsp;</label>
                <button id="excelButton" class="btn btn-primary w-100">Export to Excel</button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="piutangTable" class="table">
            <thead>
                    <tr>
                        <th>No</th>
                        <th>Mitra</th>
                        <th>No Kontrak</th>
                        <th>Nomor Handphone</th>
                        <th>Item</th>
                        <th>Besar Uang</th>
                        <th>Jenis Layanan</th>
                        <th>Status</th>
                        <th>Tanggal Mulai Piutang</th>
                        <th>Tanggal Jatuh Tempo</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Total Besar Uang:</th>
                        <th class="text-end" id="totalBesarUang"></th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
   $(document).ready(function () {
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();

    var table = $('#piutangTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan.laporan') }}",
            type: "POST",
            data: function (d) {
                d.fromDate = fromDate;
                d.toDate = toDate;
                d._token = "{{ csrf_token() }}";
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'mitra_id', name: 'mitra_id' },
            { data: 'no_kontrak', name: 'no_kontrak' },
            { data: 'nomor_hp', name: 'nomor_hp' },
            { data: 'item', name: 'item' },
            {
                data: 'besar_uang',
                name: 'besar_uang',
                render: function (data) {
                    // Format the value to currency format
                    var formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });

                    return formatter.format(data);
                }
            },
            { data: 'jenis_layanan', name: 'jenis_layanan' },
            {
                data: 'status',
                name: 'status',
                render: function (data) {
                    if (data === 'Sudah Bayar') {
                        return '<span class="text-success">' + data + '</span>';
                    } else {
                        return '<span class="text-danger">' + data + '</span>';
                    }
                }
            },
            { data: 'tgl_mulai_piutang', name: 'tgl_mulai_piutang' },
            { data: 'tgl_jatuh_tempo', name: 'tgl_jatuh_tempo' },
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'btn btn-primary',
                text: 'Export to Excel',
                exportOptions: {
                    modifier: {
                        search: 'none'
                    }
                },
                filename: 'Laporan_Piutang_' + new Date().toISOString().slice(0, 10), // Menambahkan tanggal hari saat mengunduh
            }
        ]
    });
    $('#excelButton').on('click', function () {
    table.button('.buttons-excel').trigger();
});


    $('#filter-form').on('submit', function (e) {
        e.preventDefault();

        fromDate = $('#fromDate').val();
        toDate = $('#toDate').val();

        table.draw();
    });

    function calculateTotalBesarUang() {
        var total = table
            .column(5)
            .data()
            .reduce(function (a, b) {
                return a + b;
            }, 0);

        // Format the total to currency format
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        });

        $('#totalBesarUang').text(formatter.format(total));
    }

    table.on('draw', function () {
        calculateTotalBesarUang();
    });
});
</script>
@endpush

@push('cssvendor')
    <link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
@endpush

@push('jsvendor')
    <script src="{!! asset('assets') !!}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{!! asset('assets') !!}/vendor/datatables/buttons.dataTables.min.js"></script>
    <script src="{!! asset('assets') !!}/vendor/datatables/buttons.server-side.js"></script>
@endpush