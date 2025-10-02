@extends('layouts.menu')
@section('title') Pengaturan Akses @endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                 @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Menu Pengaturan</h3></div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link" id="v-pills-roles-tab" data-toggle="pill" href="#v-pills-roles" role="tab" aria-controls="v-pills-roles" aria-selected="true">Manajemen Role</a>
                            <a class="nav-link active" id="v-pills-permissions-tab" data-toggle="pill" href="#v-pills-permissions" role="tab" aria-controls="v-pills-permissions" aria-selected="false">Manajemen Permission</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade" id="v-pills-roles" role="tabpanel" aria-labelledby="v-pills-roles-tab">
                        <div class="card">
                            <div class="card-header"><h3 class="card-title">Tambah Role Baru</h3></div>
                            <form method="POST" action="#">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="role_name">Nama Role</label>
                                        <input type="text" class="form-control" name="name" id="role_name" placeholder="Contoh: Penulis" required>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Berikan Hak Akses (Permissions)</label>
                                        <div class="row">
                                           @foreach($permissions as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input">
                            <label class="form-check-label">{{ $permission->nama }}</label>
                        </div>
                    @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Role</button>
                                </div>
                            </form>
                        </div>
                        <div class="card mt-4">
                             <div class="card-header"><h3 class="card-title">Daftar Role</h3></div>
                             <div class="card-body">
                             <table class="table table-sm">
                  <thead>
                  <tr>
                        <th>Nama Role</th>
                        <th>Permissions</th>
                        <th>#</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach($role->permissions as $p)
                                    <span class="badge bg-info">{{ $p->nama }}</span>
                                @endforeach
                            </td>
                            <td>
  <!-- Tombol Edit -->
  <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editRole{{ $role->id }}">Edit</button>

  <!-- Modal Edit -->
  <div class="modal fade" id="editRole{{ $role->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form method="POST" action="{{ route('master.roles.update', $role->id) }}">
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Role</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Role</label>
              <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
            </div>
            <div class="form-group">
              <label>Permissions</label>
              <div class="row">
                @foreach($permissions as $permission)
                  <div class="form-check col-6">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                      class="form-check-input" 
                      {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $permission->nama }}</label>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Tombol Delete -->
  <form action="{{ route('master.roles.destroy', $role->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus role ini?')">Delete</button>
  </form>
</td>

                        </tr>
                    @endforeach
                  </tbody>
                </table>
                             </div>
                        </div>
                    </div>

                    <div class="tab-pane fade  show active" id="v-pills-permissions" role="tabpanel" aria-labelledby="v-pills-permissions-tab">
                         <div class="card">
                            <div class="card-header"><h3 class="card-title">Tambah Permission Baru</h3></div>
                            <form method="POST" action="{{route('master.permissions.store')}}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="permission_name">Nama Permission</label>
                                        <input type="text" class="form-control" name="name" id="permission_name" placeholder="Contoh: Mengedit Artikel" required>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Permission</button>
                                </div>
                            </form>
                        </div>
                        <div class="card mt-4">
                            <div class="card-header"><h3 class="card-title">Daftar Permission</h3></div>
                             <div class="card-body">
                             <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Permission Name</th>
                      <th>Permission Slug</th>
                      <th>#</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($permissions as $permission)
                    <tr>
                      <td>{{ $permission->nama }}</td>
                      <td>{{ $permission->slug }}</td>
                      <td>
  <!-- Tombol Edit -->
  <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editPermission{{ $permission->id }}">Edit</button>

  <!-- Modal Edit -->
  <div class="modal fade" id="editPermission{{ $permission->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <form method="POST" action="{{ route('master.permissions.update', $permission->id) }}">
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Permission</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <input type="text" name="name" class="form-control" value="{{ $permission->nama }}" required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Tombol Delete -->
  <form action="{{ route('master.permissions.destroy', $permission->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus permission ini?')">Delete</button>
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
    </div>
</section>
@endsection