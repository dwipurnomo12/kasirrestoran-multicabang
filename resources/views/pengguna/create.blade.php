<div class="modal fade" tabindex="-1" role="dialog" id="modal_tambah_pengguna">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pengguna</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">

            <div class="form-group">
                <label>Nama</label>
                <input type="text" class="form-control" name="name" id="name">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name"></div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" id="email">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email"></div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" id="password">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-password"></div>
            </div>
            <div class="form-group">
                <label>Pilih Role</label>
                <select class="form-control" name="role" id="role_id" style="width: 100%">
                <option selected>Pilih Role</option>
                    @foreach ($roles as $role)
                      <option value="{{ $role->id }}">{{ $role->role }}</option>
                    @endforeach
                </select>
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-role_id"></div>
            </div>
            <div class="form-group">
                <label>Pilih Cabang</label>
                <select class="form-control" name="cabang" id="cabang_id" style="width: 100%">
                <option selected>Pilih cabang</option>
                    @foreach ($cabangs as $cabang)
                      <option value="{{ $cabang->id }}">{{ $cabang->cabang }}</option>
                    @endforeach
                </select>
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-cabang_id"></div>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button type="button" class="btn btn-primary" id="store">Tambah</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>


