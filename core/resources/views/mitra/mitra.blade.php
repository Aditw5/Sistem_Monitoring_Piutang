@extends('dash.layouts.app')

@section('title', 'KELOLA MITRA')

@section('content')
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table">
            <thead>
                <tr>
                    <th></th>
                    <th>No.</th>
                    <th>Nama Mitra</th>
                    <th>No Kontrak</th>
                    <th>Masa Kontrak</th>
                    <th>Nomor Handphone</th>
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
                    <h5 class="modal-title" id="modalFullTitle">Add New Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="mitra-store" action="{{ route('mitra.mitra.store') }}" method="post" style="display: contents" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name">Nama Mitra</label>
                            <input type="text" class="form-control" name="name" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="name">Nomor Kontrak</label>
                            <input type="text" class="form-control" name="no_kontrak" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="name">Masa Kontrak</label>
                            <input type="text" class="form-control date-range-picker" name="masa_kontrak" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label for="name">Nomor Handphone</label>
                            <input type="text" class="form-control" name="nomor_hp" required autocomplete="off" required placeholder="ex: 089654xxxx" onkeyup="formatPhoneNumber(this)">
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
                    <h5 class="modal-title" id="modalFullTitle">Add New Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="mitra-update" action="{{ route('mitra.mitra.update') }}" method="post" style="display: contents" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name">Nama Mitra</label>
                            <input type="text" class="form-control" name="name" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="name">Nomor Kontrak</label>
                            <input type="text" class="form-control" name="no_kontrak" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="name">Masa Kontrak</label>
                            <input type="text" class="form-control date-range-picker" name="masa_kontrak" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="name">Nomor Handphone</label>
                            <input type="text" class="form-control" name="nomor_hp" autocomplete="off" placeholder="ex: 089654xxxx" onkeyup="formatPhoneNumber(this)">
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
@endsection

@push('js')
<script>
    function formatPhoneNumber(input) {
        var phoneNumber = input.value.replace(/\D/g, '');
        if (phoneNumber.length === 10 && phoneNumber.startsWith('0')) {
            input.value = '62' + phoneNumber.slice(1);
        }
    }
    function formatDateRange(dateStr) {
        const dateArray = dateStr.split(" to ");
        const startDate = new Date(dateArray[0]);
        const endDate = new Date(dateArray[1]);

        const startDay = startDate.getDate();
        const startMonth = startDate.toLocaleString('default', { month: 'long' });
        const startYear = startDate.getFullYear();

        const endDay = endDate.getDate();
        const endMonth = endDate.toLocaleString('default', { month: 'long' });
        const endYear = endDate.getFullYear();

        return `${startDay} ${startMonth} ${startYear} - ${endDay} ${endMonth} ${endYear}`;
    }

    var ilsya = new velixs();
    var dbs = ilsya.datatables({
        url: "{{ route('mitra.mitra.ajax') }}",
        header: `Kelola Mitra`,
        columns: [
            { data: 'responsive_id' },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name' },
            { data: 'no_kontrak' },
            {
                data: 'masa_kontrak',
                render: function(data, type, row) {
                    return formatDateRange(data);
                }
            },
            { data: 'nomor_hp' },
            { data: 'action' }
        ],
        btn: [{
            text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New</span>',
            className: 'is-button-add btn btn-primary me-2',
            attr: {
                'data-bs-toggle': 'modal',
                'data-bs-target': '#modal-add'
            }
        }],
    });

    $("#mitra-store").submit(function(e) {
        e.preventDefault();
        ilsya.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            addons_success: function() {
                dbs.ajax.reload();
                $("#mitra-store")[0].reset();
                $("#modal-add").modal('hide');
            }
        });
    });

    $("#mitra-update").submit(function(e) {
        e.preventDefault();
        ilsya.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            addons_success: function() {
                dbs.ajax.reload();
                $("#mitra-update")[0].reset();
                $("#modal-edit").modal('hide');
            }
        });
    });

    $(document).on('click', ".is-btn-user-edit", function() {
        var id = $(this).data('id');
        ilsya.ajax({
            type: "GET",
            url: "{{ route('mitra.mitra.edit', '') }}" + "/" + id,
            success: function(res) {
                let data = res.data;
                Swal.close();
                $("#modal-edit").modal('show');
                $("#modal-edit").find("input[name='id']").val(data.id);
                $("#modal-edit").find("input[name='name']").val(data.name);
                $("#modal-edit").find("input[name='no_kontrak']").val(data.no_kontrak);
                $("#modal-edit").find("input[name='masa_kontrak']").val(data.masa_kontrak);
                $("#modal-edit").find("input[name='nomor_hp']").val(formatPhoneNumberInput(data.nomor_hp));
            }
        });
    });

    $(document).on('click', ".is-btn-user-delete", function() {
        var id = $(this).data('id');
        Swal.fire({
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                ilsya.ajax({
                    url: "{{ route('mitra.mitra.delete', '') }}" + "/" + id,
                    addons_success: function() {
                        dbs.ajax.reload();
                    }
                });
            }
        });
    });

    flatpickr(".date-range-picker", {
    mode: "range",
    dateFormat: "Y-m-d",
    placeholder: "Select a date range",
    allowInput: true,
    onClose: function (selectedDates, dateStr, instance) {
      // Dapatkan tanggal awal dan tanggal akhir dari input rentang tanggal
      const selectedDatesArray = dateStr.split(" to ");
      const startDate = selectedDatesArray[0];
      const endDate = selectedDatesArray[1];

      // Isi tanggal awal dan tanggal akhir ke input masing-masing
      instance.element.querySelector(".form-control[name='masa_kontrak']").value = startDate;
      instance.element.querySelector(".form-control[name='masa_kontrak']").dataset.endDate = endDate;
    }
  });

  


</script>
@endpush

@push('cssvendor')
<link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="{!! asset('assets') !!}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
  <!-- Datepicker CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.6/dist/flatpickr.min.css">
@endpush

@push('jsvendor')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js"></script>
<!-- Datepicker JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.6/dist/flatpickr.min.js"></script>
<script src="{!! asset('assets') !!}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
@endpush
