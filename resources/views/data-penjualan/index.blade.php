@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Data Penjualan</h1>
    </div>

    <div class="section-body">
        <div class="row"> 
            @if (auth()->user()->role->role === 'administrator' || auth()->user()->role->role === 'kepala restoran' )
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Pilih Cabang</label>
                                    <select class="form-control selectric"  id="select-cabang">
                                        <option value="Semua Cabang">Semua Cabang</option>
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->id }}">{{ $cabang->cabang }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            @endif
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_id" class="hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Item</th>
                                        <th>Tgl. Transaksi</th>
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
        url: "/data-penjualan/get-data",
        type: "GET", dataType: 'JSON',
        success: function(response){
            let counter = 1;
            $('#table_id').DataTable().clear();
            $.each(response.data, function(key, value){
                var badgeClass = value.status === 'paid' ? 'badge-success' : 'badge-warning';
                var badgeText = value.status === 'paid' ? 'Paid' : 'Unpaid';
                var formattedDate = dayjs(value.updated_at).format('DD MMMM YYYY');

                let detailItems = '';
                $.each(value.detail_pembelians, function(index, detailItem) {
                    detailItems += `${detailItem.nama} (${detailItem.quantity}), `;
                });
                detailItems = detailItems.slice(0, -2);
                
                let penjualan = `
                        <tr class="penjualan-row" id="index_${value.id}">
                            <td>${counter++}</td>
                            <td>${value.kode_pembelian}</td>
                            <td>Rp. ${value.total_harga}</td>
                            <td>
                                <span class="badge ${badgeClass}">${badgeText}</span>
                            </td>
                            <td>${detailItems}</td>
                            <td>${formattedDate}</td>
                        </tr>
                    `;
                        
                    $('#table_id').DataTable().row.add($(penjualan)).draw(false);
            });
        }
    });
</script>

<!-- Option Select -->
<script>
    $(document).ready(function(){
        loadData('Semua Cabang');

        $('#select-cabang').on('change', function(){
            var selectedOption = $(this).val();
            loadData(selectedOption);
        });

        function loadData(selectedOption){
            $.ajax({
                url: "/data-penjualan/get-data",
                type: "GET", 
                dataType: 'JSON',
                data: {
                    opsi: selectedOption
                },
                success: function(response){
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value){
                        var badgeClass = value.status === 'paid' ? 'badge-success' : 'badge-warning';
                        var badgeText = value.status === 'paid' ? 'Paid' : 'Unpaid';
                        var formattedDate = dayjs(value.updated_at).format('DD MMMM YYYY');

                        let detailItems = '';
                        $.each(value.detail_pembelians, function(index, detailItem) {
                            detailItems += `${detailItem.nama} (${detailItem.quantity}), `;
                        });
                        detailItems = detailItems.slice(0, -2);
                        
                        let penjualan = `
                                <tr class="penjualan-row" id="index_${value.id}">
                                    <td>${counter++}</td>
                                    <td>${value.kode_pembelian}</td>
                                    <td>Rp. ${value.total_harga}</td>
                                    <td>
                                        <span class="badge ${badgeClass}">${badgeText}</span>
                                    </td>
                                    <td>${formattedDate}</td>
                                    <td>${detailItems}</td>
                                </tr>
                            `;
                                
                            $('#table_id').DataTable().row.add($(penjualan)).draw(false);
                    });
                }
            });
        }
    });
</script>

@endsection

