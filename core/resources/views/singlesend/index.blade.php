@extends('dash.layouts.app')

@section('title', 'SINGLE SEND')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <span class="alert-icon text-primary me-2">
                    <i class="ti ti-device-mobile ti-xs"></i>
                </span>
                <div class="d-block">
                    Anda Mengirim Pesan Menggunakan Device<span class="fw-bold"> {{ $main_device->session_name }} {!! $main_device->whatsapp_number ? "<small>($main_device->whatsapp_number)</small>" : '' !!} </span> 
                </div>
            </div>
            <form id="form-store-single" action="{!! route('single.store') !!}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Penerima</label>
                            <input type="text" name="receiver" class="form-control" autocomplete="off" required placeholder="ex: 62857xxxxxx">
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Tipe Pesan</label>
                            <select name="message_type" required class="form-select">
                                <option value="">-- Select One --</option>
                                <option value="text">Pesan Text</option>
                                <option value="media">Pesan Media</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="message-content">

                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>No Kontrak</th>
                        <th>Nomor Handphone</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 1; @endphp
                    @foreach ($mitras as $mitra)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $mitra->name }}</td>
                            <td>{{ $mitra->no_kontrak }}</td>
                            <td>{{ $mitra->nomor_hp }} <a href="#" class="btn btn-sm btn-primary copy-btn" onclick="copyToClipboard(this, '{{ $mitra->nomor_hp }}')"><i class="ti ti-files"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-add" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Add New Responder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="responder-store" action="{{ route('responder.store') }}" method="post" style="display: contents" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <span class="alert-icon text-primary me-2">
                                <i class="ti ti-device-mobile ti-xs"></i>
                            </span>
                            <div class="d-block">
                               Anda Mengirim Pesan Menggunakan Device <span class="fw-bold"> {{ $main_device->session_name }} {!! $main_device->whatsapp_number ? "<small>($main_device->whatsapp_number)</small>" : '' !!} </span> device.
                            </div>
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

    <div class="modal fade" id="modal-files" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-0 py-1">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function copyToClipboard(element, text) {
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            element.classList.add('btn-success'); // Tambahkan kelas CSS btn-success
            element.innerHTML = '<i class="ti ti-check"></i>'; // Ubah ikon menjadi tanda centang
        }
    </script>
    <script>
        var ilsya = new velixs()
        var dbs = ilsya.datatables({
            url: "{{ route('mitra.mitra.ajax') }}",
            header: `Kelola Mitra`,
            columns: [
                { data: 'responsive_id' },
                { data: 'name' },
                { data: 'no_kontrak' },
                { data: 'nomor_hp' }
            ],
            btn: [
                {
                    text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New</span>',
                    className: 'is-button-add btn btn-primary me-2 ',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#modal-add'
                    }
                }
            ]
        });
    </script>

    <script src="{!! asset('assets/libvelixs/ilsya.files.js') !!}"></script>
    <script src="{!! asset('assets/libvelixs/ilsya.message.js?v=35') !!}"></script>
    <script>
        var ilsya = new velixs()
        var files = new FileManager({
            subfolder: "{{ $auth->id }}",
            base_url: "{{ route('ilsya.files.index') }}"
        });

        $("#form-store-single").submit(function(e) {
            e.preventDefault();
            ilsya.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                addons_success: function() {
                    $("#form-store-single")[0].reset();
                    $("#message-content").html("");
                }
            });
        });
    </script>
@endpush