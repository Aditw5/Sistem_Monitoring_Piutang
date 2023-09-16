@extends('dash.layouts.app')

@section('title', 'KELOLA PIUTANG MITRA')

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
</style>

<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table">
            <thead>
                <tr>
                    <th></th>
                    <th>No.</th>
                    <th>Nama Mitra</th>
                    <th>Item</th>
                    <th>Besar Uang</th>
                    <th>Jenis Layanan</th>
                    <th>Status</th>
                    <th>Status Validasi</th>
                    <th>Tanggal Mulai</th>
                    <th>Jatuh Tempo</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-add" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Tambah Data Piutang Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="piutang-store" action="{{ route('piutang.piutang.store') }}" method="post" style="display: contents" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name">Name Mitra</label>
                                <select class="form-control" name="mitra_id" required autocomplete="off">
                                    <option value="">Pilih Mitra</option>
                                    @foreach ($mitras as $mitra)
                                        <option value="{{ $mitra->id }}">{{ $mitra->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name">Item</label>
                                <input type="text" class="form-control" name="item" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="name">Besar Uang</label>
                                <input type="text" class="form-control currency-input" name="besar_uang" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="name">Jenis Layanan</label>
                                <!-- <input type="text" class="form-control" name="jenis_layanan" required autocomplete="off"> -->
                                <select class="form-control" id="jenis_layanan" name="jenis_layanan" required autocomplete="off">
                                    <option value="">Pilih Layanan</option>
                                    <option value="Express">Express</option>
                                    <option value="SKH">SKH</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name">Status</label>
                                <!-- <input type="text" class="form-control" name="status" required autocomplete="off"> -->
                                <select class="form-control" id="status" name="status" required autocomplete="off">
                                    <option value="">Pilih Status</option>
                                    <option value="Belum Bayar">Belum Bayar</option>
                                    <option value="Sudah Bayar">Sudah Bayar</option>
                                </select>
                            </div>
                             @if ($auth->role == 'user') 
                            <div class="mb-3">
                                <label for="name">Status Validasi</label>
                                <select class="form-control" id="status_validasi" name="status_validasi" autocomplete="on">
                                    <option value="">Pilih Status Validasi</option>
                                    <option value="Belum Validasi">Belum Validasi</option>
                                    <option value="Tervalidasi">Sudah Validasi</option>
                                </select>
                            </div>
                             @endif 
                            <div class="mb-3">
                                <label for="name">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tgl_mulai_piutang" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="name">Jatuh Tempo</label>
                                <input type="date" class="form-control" name="tgl_jatuh_tempo" required autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

            </div>
        </div>
</div>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Update Data Piutang Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="piutang-update" action="{{ route('piutang.piutang.update') }}" method="post" style="display: contents" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                             @if ($auth->role == 'admin') 
                            <div class="mb-3">
                                <label for="name">Status</label>
                                <!-- <input type="text" class="form-control" name="status" required autocomplete="off"> -->
                                <select class="form-control" id="status" name="status" required autocomplete="off">
                                    <option value="">Pilih Status</option>
                                    <option value="Belum Bayar">Belum Bayar</option>
                                    <option value="Sudah Bayar">Sudah Bayar</option>
                                </select>
                            </div>
                            @endif 
                            @if ($auth->role == 'user') 
                            <div class="mb-3">
                                <label for="name">Status Validasi</label>
                                <select class="form-control" id="status_validasi" name="status_validasi" autocomplete="on">
                                    <option value="">Pilih Status Validasi</option>
                                    <option value="Belum Validasi">Belum Validasi</option>
                                    <option value="Tidak Valid">Tidak Valid</option>
                                    <option value="Tervalidasi">Sudah Validasi</option>
                                </select>
                            </div>
                            @endif 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Menambahkan event listener pada input dengan class "currency-input"
        $('.currency-input').on('keyup', function() {
            // Mengambil nilai dari input
            var value = $(this).val();

            // Menghapus semua karakter non-digit dari nilai input
            var number = value.replace(/\D/g, '');

            // Memformat angka dengan menambahkan titik setiap tiga digit
            var formattedNumber = number.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Mengupdate nilai input dengan angka yang diformat
            $(this).val(formattedNumber);
        });
    });

    var ilsya = new velixs();
    var dbs = ilsya.datatables({
        url: "{{ route('piutang.piutang.ajax') }}",
        header: `Kelola Piutang Mitra`,
        columns: [
            {
                data: 'responsive_id'
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'mitra.name'
            },
            {
                data: 'item'
            },
            {
                data: 'besar_uang',
                render: function (data) {
                    // Format the value to currency format
                    var formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });

                    return formatter.format(data);
                }
            },
            {
                data: 'jenis_layanan'
            },
            {
                data: 'status',
                name: 'status',
                render: function(data) {
                    if (data === 'Sudah Bayar') {
                        return '<span class="text-success">' + data + '</span>';
                    } else {
                        return '<span class="text-danger">' + data + '</span>';
                    }
                }
            },
            {
                data: 'status_validasi',
                name: 'status_validasi',
                render: function(data) {
                    if (data === 'Tervalidasi') {
                        return '<span class="text-success">' + data + '</span>';
                    } else {
                        return '<span class="text-danger">' + data + '</span>';
                    }
                }
            },
            {
                data: 'tgl_mulai_piutang'
            },
            {
                data: 'tgl_jatuh_tempo'
            },
            {
                data: 'action'
            }
        ],
        btn: [
            {
                text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New</span>',
                className: 'is-button-add btn btn-primary me-2',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#modal-add'
                }
            }
        ]
    });

    $("#piutang-store").submit(function(e) {
        e.preventDefault();
        ilsya.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            addons_success: function() {
                dbs.ajax.reload();
                $("#piutang-store")[0].reset();
                $("#modal-add").modal('hide');
            }
        });
    });

    $("#piutang-update").submit(function(e) {
        e.preventDefault();
        ilsya.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            addons_success: function() {
                dbs.ajax.reload();
                $("#piutang-update")[0].reset();
                $("#modal-edit").modal('hide');
            }
        });
    });

    $(document).on('click', ".is-btn-piutang-edit", function() {
        var id = $(this).data('id');
        ilsya.ajax({
            type: "GET",
            url: "{{ route('piutang.piutang.edit', '') }}" + "/" + id,
            success: function(res) {
                let data = res.data;
                Swal.close();
                $("#modal-edit").modal('show');
                $("#modal-edit").find("input[name='status']").val(data.status);
                $("#modal-edit").find("select[name='status_validasi']").val(data.status_validasi);
                $("#modal-edit").find("input[name='id']").val(data.id);
            }
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
@endpush
