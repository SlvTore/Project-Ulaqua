@extends('layouts.default')

@section('content')
<!-- Tambahkan resource FullCalendar secara manual -->
<link href="{{ asset('vendor/fullcalendar/css/main.min.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/fullcalendar/js/main.min.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Tambahkan sedikit style custom untuk menyamakan popover -->
<style>
    .popover-kustom {
        border: 1px solid #ced4da;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .popover-kustom .popover-header {
        background-color: #f8f9fa !important;
        color: #212529 !important;
        font-weight: 600;
        border-bottom: 1px solid #ced4da;
    }
</style>

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Klien CRM</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Jadwal & Kalender</a></li>
        </ol>
    </div>

    <!-- Row Template Kalender Eres -->
    <div class="row">
        <!-- Kolom 1 (KIRI): Sidebar Drag & Drop (Ubah ukurannya menjadi col-xl-3 / cols-xxl-4) -->
        <div class="col-xl-3 col-xxl-4">
            <div class="card">
                <div class="card-body" id="external-events">
                    <h4 class="card-intro-title">Tambahkan Cepat</h4>
                    <div class="my-3">
                        <p>Tarik & lepaskan (drag) aktivitas ke kalender.</p>
                        <div class="external-event btn-danger light mb-2" data-class="bg-danger">
                        Libur (Hari Besar)
                        </div>
                        <div class="external-event btn-warning light mb-2" data-class="bg-warning">
                        Stock Opname
                        </div>
                        <div class="external-event btn-info light mb-2" data-class="bg-info">
                        Produksi
                        </div>
                        <div class="external-event btn-success light mb-2" data-class="bg-success">
                        Aktivitas Lainnya
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom 2 (KANAN): Tempat Kalender Muncul (Kembalikan div id="client-calendar") -->
        <div class="col-xl-9 col-xxl-8">
            <div class="card">
                <div class="card-body">
                    <!-- INI WAJIB ADA AGAR JS FULLCALENDAR BISA MENGGAMBAR KALENDER -->
                    <div id="client-calendar" class="app-fullcalendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Script Init Fullcalendar Khusus -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // 1. INISIALISASI EXTERNAL DRAG & DROP
        var containerEl = document.getElementById('external-events');
        new FullCalendar.Draggable(containerEl, {
            itemSelector: '.external-event',
            eventData: function(eventEl) {
                return {
                    title: eventEl.innerText.trim(),
                    className: eventEl.getAttribute('data-class')
                };
            }
        });

        // 2. INISIALISASI KALENDER & POPOVER
        var calendarEl = document.getElementById('client-calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            selectable: true,
            editable: true,     // Bolehkan Geser Event Internal
            droppable: true,    // Bolehkan Menerima Event External (Drag & Drop)
            events: "{{ route('clients.calendar.events') }}",

            // 3. EVENT KETIKA BERHASIL DI DROP (Dari Sidebar ke Kalender)
            eventReceive: function(info) {
                // Di-trigger saat item ditarik dari sidebar lalu dijatuhkan.
                let title = info.event.title;
                let start = info.event.startStr;
                let end = info.event.endStr || start;

                fetch("{{ route('clients.calendar.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ title: title, start: start, end: end })
                })
                .then(r => r.json())
                .then(data => {
                    // Update tampilan dengan ID Asli dari database agar popover dan fungsi lain bekerja
                    info.event.setProp('id', data.event.id);
                    info.event.setProp('classNames', [data.event.className]);
                    info.event.setExtendedProp('type', data.event.extendedProps.type);
                    info.event.setExtendedProp('description', data.event.extendedProps.description);
                });
            },

            // 4. EVENT KETIKA EVENT DIGESER (Pindah Tanggal)
            eventDrop: function(info) {
                fetch("{{ url('clients/calendar/update') }}/" + info.event.id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        start: info.event.startStr,
                        end: info.event.endStr || info.event.startStr
                    })
                }).catch(e => info.revert());
            },

            // 5. INISIALISASI BOOTSTRAP POPOVER
            eventDidMount: function(info) {
                let desc = info.event.extendedProps.description || 'Baru Saja Ditambahkan';
                let type = info.event.extendedProps.type || info.event.title;

                // Pasang Popover bootstrap 5 khusus untuk informasi (muncul di hover)
                new bootstrap.Popover(info.el, {
                    title: type,
                    content: `<div class="p-1"><small class="text-muted">${desc}</small><br><strong>Klik untuk hapus</strong></div>`,
                    html: true,
                    trigger: 'hover',     // Muncul sempurna saat cursor di atas event
                    placement: 'top',
                    container: 'body',
                    customClass: 'popover-kustom'
                });
            },

            // 6. FUNGSI KLIK EVENT UNTUK MENGHAPUS (Muncul confirm X)
            eventClick: function(info) {
                // Tambahkan validasi jika Event tidak punya ID
                if (!info.event.id) {
                    alert("Aktivitas ini sedang disinkronisasikan. Silakan muat ulang (Reload) halaman terlebih dahulu.");
                    return;
                }

                if(confirm('Yakin ingin menghapus agenda "' + info.event.title + '" ini?')) {
                    fetch("{{ url('clients/calendar/delete') }}/" + info.event.id, {
                        method: 'DELETE',
                        headers: {
                            // WAJIB: Atur Header yang tepat agar Laravel tidak 404
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(r => r.json())
                    .then(res => {
                        if(res.message) {
                            // Hapus secara visual (langsung dari memori kalender)
                            info.event.remove();
                            // Hapus juga sisa popover yang menyangkut
                            document.querySelectorAll('.popover').forEach(p => p.remove());
                        }
                    })
                    .catch(e => {
                        alert("Aktivitas tersistem (seperti Penjualan dll) tidak bisa dihapus manual. Anda harus menghapusnya dari modul bersangkutan.");
                    });
                }
            }
        });

        calendar.render();
    });
</script>
@endpush

