@extends('layouts.app')

@include('pengguna.create')
@include('pengguna.edit')


@section('content')
<section class="section">
    <div class="section-header">
      <h1>Pengguna</h1>
      <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_pengguna"><i class="fa fa-plus"></i> Tambah Pengguna</a>
       </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_id" class="hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Cabang</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>

<!-- Datatable Jquery -->
<script>
    $(document).ready(function(){
        $('#table_id').DataTable();
    })
</script>

<!-- Fetch Data -->
<script>
    $.ajax({
        url: "/pengguna/get-data",
        type: "GET",
        dataType: 'JSON'
        })
        .then(function(response) {
        let counter = 1;
        $('#table_id').DataTable().clear();

        const getRoleNamePromise = new Promise(function(resolve, reject) {
            $.getJSON('{{ url('api/role') }}', function(roles) {
            resolve(roles);
            });
        });

        const getCabangNamePromise = new Promise(function(resolve, reject) {
            $.getJSON('{{ url('api/cabang') }}', function(cabangs) {
            resolve(cabangs);
            });
        });

        Promise.all([getRoleNamePromise, getCabangNamePromise])
        .then(function([roles, cabangs]) {
            $.each(response.data, function(key, value) {
            const role = roles.find(function(s) {
                return s.id === value.role_id;
            });

            const cabang = cabangs.find(function(s) {
                return s.id === value.cabang_id;
            });

            let pengguna = `
                <tr class="pengguna-row" id="index_${value.id}">
                <td>${counter++}</td>
                <td>${value.name}</td>
                <td>${value.email}</td>
                <td>${role ? role.role : ''}</td>
                <td>${cabang ? cabang.cabang : ''}</td>
                <td>
                    <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                    <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                </td>
                </tr>
            `;
            $('#table_id').DataTable().row.add($(pengguna)).draw(false);
            });
        })
        .catch(function(error) {
            console.error(error);
        });
        })
        .catch(function(error) {
        console.error(error);
    });

</script>

<!-- Show Modal Create -->
<script>
    $('body').on('click', '#button_tambah_pengguna', function(){
        $('#modal_tambah_pengguna').modal('show');
        resetAlerts();
    });

    function resetAlerts() {
        $('#alert-name').removeClass('d-block').addClass('d-none');
        $('#alert-email').removeClass('d-block').addClass('d-none');
        $('#alert-password').removeClass('d-block').addClass('d-none');
        $('#alert-role').removeClass('d-block').addClass('d-none');
        $('#alert-cabang').removeClass('d-block').addClass('d-none');
    }

    $('#store').click(function(e){
        e.preventDefault();

        let name            = $('#name').val();
        let email           = $('#email').val();
        let password        = $('#password').val();
        let role_id         = $('#role_id').val();
        let cabang_id       = $('#cabang_id').val();
        let token           = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('role_id', role_id);
        formData.append('cabang_id', cabang_id);
        formData.append('_token', token);

        $.ajax({
            url: '/pengguna',
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            success:function(response){
                swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: true,
                    timer: 3000
                });

                $.ajax({
                    url: "/pengguna/get-data",
                    type: "GET",
                    dataType: 'JSON',
                    success: function(response){
                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response.data, function(key, value){
                            getRoleName(value.role_id, function(role){
                                getCabangName(value.cabang_id, function(cabang){
                                    let pengguna = `
                                        <tr class="pengguna-row" id="index_${value.id}">
                                            <td>${counter++}</td>
                                            <td>${value.name}</td>
                                            <td>${value.email}</td>
                                            <td>${role}</td>
                                            <td>${cabang}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                    $('#table_id').DataTable().row.add($(pengguna)).draw(false);
                                })
                            });
                        });

                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');
                        $('#role_id').val('');
                        $('#cabang_id').val('');
                        
                        $('#modal_tambah_pengguna').modal('hide');

                        let table = $('#table_id').DataTable();
                        table.draw();

                        function getRoleName(roleId, callback){
                            $.getJSON('{{ url('api/role') }}', function(roles){
                                var role = roles.find(function(s){
                                    return s.id === roleId;
                                });
                                callback(role ? role.role : '');
                            });
                        }
                        function getCabangName(cabangId, callback){
                            $.getJSON('{{ url('api/cabang') }}', function(cabangs){
                                var cabang = cabangs.find(function(s){
                                    return s.id === cabangId
                                });
                                callback(cabang ? cabang.cabang: '');
                            });
                        }
                    }
                });
            },

            error:function(error){
                if(error.responseJSON && error.responseJSON.name && error.responseJSON.name[0]){
                    $('#alert-name').removeClass('d-none');
                    $('#alert-name').addClass('d-block');

                    $('#alert-name').html(error.responseJSON.name[0]);
                }

                if(error.responseJSON && error.responseJSON.email && error.responseJSON.email[0]){
                    $('#alert-email').removeClass('d-none');
                    $('#alert-email').addClass('d-block');

                    $('#alert-email').html(error.responseJSON.email[0]);
                }

                if(error.responseJSON && error.responseJSON.password && error.responseJSON.password[0]){
                    $('#alert-password').removeClass('d-none');
                    $('#alert-password').addClass('d-block');

                    $('#alert-password').html(error.responseJSON.password[0]);
                }

                if(error.responseJSON && error.responseJSON.role_id && error.responseJSON.role_id[0]){
                    $('#alert-role_id').removeClass('d-none');
                    $('#alert-role_id').addClass('d-block');

                    $('#alert-role_id').html(error.responseJSON.role_id[0]);
                }

                if(error.responseJSON && error.responseJSON.cabang_id && error.responseJSON.cabang_id[0]){
                    $('#alert-cabang_id').removeClass('d-none');
                    $('#alert-cabang_id').addClass('d-block');

                    $('#alert-cabang_id').html(error.responseJSON.cabang_id[0]);
                }
            }
        })
    });
</script>


<!-- Edit/Update Data -->
<script>
    $('body').on('click', '#button_edit_pengguna', function(){
        let pengguna_id = $(this).data('id');

        $.ajax({
            url: `/pengguna/${pengguna_id}/edit`,
            type: "GET",
            cache: false,
            success: function(response){
                $('#pengguna_id').val(response.data.id);
                $('#edit_name').val(response.data.name);
                $('#edit_email').val(response.data.email);
                $('#edit_password').val(response.data.password);
                $('#edit_role_id').val(response.data.role_id);
                $('#edit_cabang_id').val(response.data.cabang_id);

                $('#modal_edit_pengguna').modal('show');
            }
        });
    });

    $('#update').click(function(e){
        e.preventDefault();

        let pengguna_id     = $('#pengguna_id').val();
        let name            = $('#edit_name').val();
        let email           = $('#edit_email').val();
        let password        = $('#edit_password').val();
        let role_id         = $('#edit_role_id').val();
        let cabang_id       = $('#edit_cabang_id').val();
        let token           = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('role_id', role_id);
        formData.append('cabang_id', cabang_id);
        formData.append('_token', token);
        formData.append('_method', 'PUT');

        if(password !== ''){
            formData.append('password', password);
        }

        $.ajax({
            url: `/pengguna/${pengguna_id}`,
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            success:function(response){
                swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: true,
                    timer:3000
                });

                $.ajax({
                    url: "/pengguna/get-data",
                    type: "GET",
                    dataType: 'JSON',
                    success: function(response){
                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response.data, function(key, value){
                            getRoleName(value.role_id, function(role){
                                getCabangName(value.cabang_id, function(cabang){
                                    let pengguna = `
                                        <tr class="pengguna-row" id="index_${value.id}">
                                            <td>${counter++}</td>
                                            <td>${value.name}</td>
                                            <td>${value.email}</td>
                                            <td>${role}</td>
                                            <td>${cabang}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                    $('#table_id').DataTable().row.add($(pengguna)).draw(false);
                                });
                            });
                        });
                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');
                        $('#role_id').val('');
                        $('#cabang_id').val('');
                            
                        $('#modal_edit_pengguna').modal('hide');

                        function getRoleName(roleId, callback){
                            $.getJSON('{{ url('api/role') }}', function(roles){
                                var role = roles.find(function(s){
                                    return s.id === roleId;
                                });
                                callback(role ? role.role : '');
                            });
                        }
                        function getCabangName(cabangId, callback){
                            $.getJSON('{{ url('api/cabang') }}', function(cabangs){
                                var cabang = cabangs.find(function(s){
                                    return s.id === cabangId
                                });
                                callback(cabang ? cabang.cabang: '');
                            });
                        }
                    }
                });
            },

            error:function(error){
                if(error.responseJSON && error.responseJSON.name && error.responseJSON.name[0]){
                    $('#alert-name').removeClass('d-none');
                    $('#alert-name').addClass('d-block');

                    $('#alert-name').html(error.responseJSON.name[0]);
                }

                if(error.responseJSON && error.responseJSON.email && error.responseJSON.email[0]){
                    $('#alert-email').removeClass('d-none');
                    $('#alert-email').addClass('d-block');

                    $('#alert-email').html(error.responseJSON.email[0]);
                }

                if(error.responseJSON && error.responseJSON.role_id && error.responseJSON.role_id[0]){
                    $('#alert-role_id').removeClass('d-none');
                    $('#alert-role_id').addClass('d-block');

                    $('#alert-role_id').html(error.responseJSON.role_id[0]);
                }

                if(error.responseJSON && error.responseJSON.cabang_id && error.responseJSON.cabang_id[0]){
                    $('#alert-cabang_id').removeClass('d-none');
                    $('#alert-cabang_id').addClass('d-block');

                    $('#alert-cabang_id').html(error.responseJSON.cabang_id[0]);
                }
            }
        });
    });
</script>

<!-- Delete Data -->
<script>
    $('body').on('click', '#button_hapus_pengguna', function(){
        let pengguna_id  = $(this).data('id');
        let token       = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: "ingin menghapus data ini !",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: `/pengguna/${pengguna_id}`,
                    type: "DELETE",
                    cache: false,
                    data: {
                        "_token": token
                    },
                    success:function(response){
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: true,
                            timer: 3000
                        });
                        $(`#index_${pengguna_id}`).remove();
                    }
                })
            }
        })
    })
</script>


@endsection

