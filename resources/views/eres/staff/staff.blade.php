@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Notifikasi Sukses dipindah ke dalam Content -->
    @if(session('success'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    <div class="form-head d-flex mb-3 mb-md-4 align-items-start">
        <div class="me-auto d-none d-lg-block">
            <a href="javascript:void(0);" class="btn btn-primary btn-rounded add-staff" data-bs-toggle="modal" data-bs-target="#addStaffModal" >+ Add Staff</a>
        </div>
        <div class="input-group search-area ms-auto d-inline-flex me-3">
            <input type="text" class="form-control" placeholder="Search here">
            <div class="input-group-append">
                <button type="button" class="input-group-text"><i class="flaticon-381-search-2"></i></button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="example5" class="table table-striped patient-list mb-4 dataTablesCard fs-14">
                            <thead>
                                <!-- THEAD (7 Kolom) -->
                                <tr>
                                    <th>Cek</th>
                                    <th>Name</th>
                                    <th>Roles</th>
                                    <th>Email</th>
                                    <th>Joining Date</th>
                                    <th>Address</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- TBODY (7 Kolom harus sama persis jumlahnya) -->
                                @foreach($users as $key => $user)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox ml-2">
                                            <input type="checkbox" class="custom-control-input" id="customCheckBox{{$user->id}}">
                                            <label class="custom-control-label" for="customCheckBox{{$user->id}}"></label>
                                        </div>
                                    </td>
                                    <td class="patient-info ps-0">
                                        <span>
                                            <div class="media-object bg-primary text-white mr-3">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                            <span class="fs-16 font-w500">{{ $user->name }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge light badge-success">{{ $user->getRoleNames()->first() ?? 'Tidak Ada' }}</span>
                                    </td>
                                    <td class="text-primary">{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $user->address }}">
                                        {{ $user->address ?? '-' }}
                                    </td>
                                    <td class="text-end">
                                        <a href="javascript:void(0);" class="btn btn-primary shadow btn-xs sharp me-1"
                                           data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">
                                           <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form"
                                              data-confirm-message="Yakin ingin menghapus pegawai / staf ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function($) {
        var table = $('#example5').DataTable({
            searching: false,
            paging: true,
            select: false,
            lengthChange: false
        });
    })(jQuery);
</script>
@endpush

@push('modals')
<!-- Modal Tambah Staff -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Staff</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="row">
              <div class="col-xl-6">
                  <div class="form-group">
                      <label class="col-form-label">Nama Pegawai:</label>
                       <input type="text" name="name" class="form-control" required placeholder="Contoh: Budi">
                  </div>
              </div>
              <div class="col-xl-6">
                  <div class="form-group">
                      <label class="col-form-label">Email / ID:</label>
                       <input type="email" name="email" class="form-control" required placeholder="budi@ulaqua.local">
                  </div>
              </div>
              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label class="col-form-label">Password Sementara:</label>
                      <input type="password" name="password" class="form-control" required>
                  </div>
              </div>
              <div class="col-xl-6 mt-3">
                  <div class="form-group">
                      <label class="col-form-label">Peran (Role):</label>
                      <select name="role" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-xl-12 mt-3">
                  <div class="form-group">
                      <label class="col-form-label">Alamat / Address:</label>
                      <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                  </div>
              </div>
            </div>
            <div class="modal-footer mt-4">
              <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Simpan Akun</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>

<!-- Modal Edit per User -->
@foreach($users as $user)
<div class="modal fade text-start" id="editModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pegawai: {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Nama Pegawai:</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Email / ID:</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                        </div>
                        <div class="col-xl-6 mt-3">
                            <div class="form-group">
                                <label>Password Baru <small>(kosongkan jika tetap)</small>:</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-xl-6 mt-3">
                            <div class="form-group">
                                <label>Peran (Role):</label>
                                <select name="role" class="form-control" required>
                                  @foreach($roles as $role)
                                      <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                          {{ $role->name }}
                                      </option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 mt-3">
                            <div class="form-group">
                                <label>Alamat / Address:</label>
                                <textarea name="address" class="form-control" rows="3">{{ $user->address }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endpush
