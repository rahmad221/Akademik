@extends('layouts.menu')
@section('title') USERS @endsection
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection
<!-- Main content -->
@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Table Users</h3>
                        <button type="button" class="btn btn-success btn-xs float-right mr-2" data-toggle="modal"
                            data-target="#modal-tambah">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center text-indigo">-</th>
                                    <th class="text-center text-indigo">Nama</th>
                                    <th class="text-center text-indigo">Email</th>
                                    <th class="text-center text-indigo">Role</th>
                                    <th class="text-center text-indigo">#</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($user as $usr)
                                <tr>
                                    <td>{{$usr->id}}</td>
                                    <td>{{$usr->name}}</td>
                                    <td>{{$usr->email}}</td>
                                    <td>{{ $usr->roles->first()->name ?? '-' }}</td>
                                    <td>
    <button type="button" 
            class="btn btn-warning btn-xs btn-edit-user"
            data-id="{{ $usr->id }}"
            data-name="{{ $usr->name }}"
            data-role="{{ $usr->roles->first()->id ?? '' }}"
            data-toggle="modal" 
            data-target="#modal-edit">
        Edit Role
    </button>
</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

<div class="modal fade" id="modal-tambah" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tombol_form_create">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <span>Nama</span>
                        <input type="text" class="form-control form-control-sm" name="name" id="nama" required>
                    </div>

                    <div class="form-group">
                        <span>Email</span>
                        <input type="email" class="form-control form-control-sm" name="email" id="email" required>
                    </div>

                    <div class="form-group">
                        <span>Password</span>
                        <input type="password" class="form-control form-control-sm" name="password" id="password" required>
                    </div>

                    <div class="form-group">
                        <span>Role</span>
                        <select class="form-control form-control-sm" name="role_id" id="role_id" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-info btn-sm">Simpan</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal edit user -->

<div class="modal fade" id="modal-edit" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditUser" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Edit Role - <span id="editUserName"></span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Role</label>
                        <select name="role_id" id="editRoleSelect" class="form-control form-control-sm">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-info btn-sm">Simpan</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- DataTables -->
<script src="{{url('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- page script -->
<script>
$(function() {

    $("#example1").DataTable();
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });
});

$(document).on("click", ".btn-edit-user", function () {
    let userId = $(this).data("id");
    let userName = $(this).data("name");
    let userRole = $(this).data("role");

    // set nama user di modal
    $("#editUserName").text(userName);

    // set role di select
    $("#editRoleSelect").val(userRole);

    // ubah action form sesuai user
    $("#formEditUser").attr("action", "/master/users/" + userId + "/role");
});

$('#tombol_form_create').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('master.users.store') }}",
        type: "POST",
        data: $(this).serialize(),
            success: function (res) {
                if (res.success) {
                    // Tambahkan user baru ke tabel tanpa reload
                    $('#example2 tbody').append(`
                        <tr>
                            <td>${res.data.id}</td>
                            <td>${res.data.name}</td>
                            <td>${res.data.email}</td>
                            <td>${res.data.role}</td>
                            <td><button class="btn btn-warning btn-xs">Edit Role</button></td>
                        </tr>
                    `);

                    $('#modal-tambah').modal('hide');
                    $('#tombol_form_create')[0].reset();
                    toastr.success(res.message);
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                $.each(errors, function (key, value) {
                    errorMessage += value[0] + "<br>";
                });
                toastr.error(errorMessage);
            }
        });
});
</script>
@endsection