@extends('admin.layout')
@section('judul', 'Data Kelas')
@section('content')
@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<style>
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:before {
      right: 1em;
      content: "\2191" !important;
      font-size: 18px !important;
      margin-bottom: .3rem !important;
    }
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
      right: 0.5em;
      content: "\2193" !important;
      font-size: 18px !important;
      margin-bottom: .3rem !important;
    }
</style>
@endpush

<div class="col-lg-12 grid-margin stretch-card mt-5">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h2>Tabel Data Kelas</h2>
          <a href="{{ url('data-kelas/create') }}" style="text-decoration: none" class="tbl-btn button btn-primary p-2 rounded-2">Add New Kelas</a>
        </div>
        <hr class="border-dark my-4">
        <div class="table-responsive">
          <table class="table table-hover dataTable  table-striped border rounded-1" id="kelas">
            <thead>
              <tr>
                <th class="fw-bold text-center">No</th>
                <th class="fw-bold text-center">Nama Kelas</th>
                <th class="fw-bold text-center">Kompetensi Keahlian</th>
                <th class="fw-bold text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @php
              $no = 1;
            @endphp
            @foreach ($kelas as $idx)
              <tr>
                <td class="fw-semibold text-center fs-6">{{$no++}}</td>
                <td class="text-center fs-6">{{$idx->nama_kelas}}</td>
                <td class="text-center fs-6">{{$idx->kompetensi_keahlian}}</td>
                {{-- <td class="text-danger">{{$idx ->}}<i class="mdi mdi-arrow-down"></i></td> --}}
                <td class=" d-flex gap-2 justify-content-center text-center">
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editKelasModal"><i class="fa-solid fa-pen pr-1"></i>
                    Edit
                  </button>
                  <!-- Modal -->
                    <div class="modal fade" id="editKelasModal" tabindex="-1" aria-labelledby="editKelasModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editKelasModalLabel">Edit Kelas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form method="POST" action="{{ url('data-kelas/'.$idx->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="{{ $idx->nama_kelas }}">
                              </div>
                              <div class="mb-3">
                                <label for="Kompetensi Keahlian" class="form-label">Kompetensi Keahlian</label>
                                <input type="text" class="form-control" id="kompetensi_keahlian" name="kompetensi_keahlian" value="{{ $idx->kompetensi_keahlian }}">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  <form action="{{ url('data-kelas',$idx->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm fw-semibold text-white rounded-2 bg-danger delete ml-2" data-name="{{ $idx->nama_kelas }}"><i class="fa-solid fa-trash mr-1" style="font-size: 13px"></i>Delete</button>
                      </form>
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
  @endsection

  @push('scripts')
  <!-- jQuery -->
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xU+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  </script>

<script>
  $(function () {
      $('#kelas').DataTable().fnDestroy({
          columnDefs: [{
              paging: true,
              scrollX: true,
              processing: true,
              serverSide: true,
              lengthChange: true,
              searching: true,
              ordering: true,
              targets: [1, 2, 3, 4],
          }, ],
      });
      $('button').click(function () {
          var data = table.$('input, select', 'button', 'form').serialize();
          return false;
      });
      table.columns().iterator('column', function (ctx, idx) {
          $(table.column(idx).header()).prepend('<span class="sort-icon"/>');
      });
  });
</script>

  <script>        
    $('.delete').click(function(event) {
    var form =  $(this).closest("form");
    var name = $(this).data("name");
    event.preventDefault();
    swal({
        title: `Are you sure you want to delete ${name}?`,
        text: "If you delete this, it will be gone forever.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        form.submit();
        swal("Data berhasil di hapus", {
              icon: "success",
              });
      }else 
      {
        swal("Data tidak jadi dihapus");
      }
    });
  });
  </script>

  <script>
    @if (Session::has('success'))
    toastr.options =
    {
      "closeButton" : true,
      "progressBar" : true
    }
    toastr.success("{{ Session::get('success') }}")
    @endif
  </script>

  <script>
    @if (Session::has('destroy'))
    toastr.options =
    {
      "closeButton" : true,
      "progressBar" : true
    }
    toastr.success("{{ Session::get('destroy') }}")
    @endif
  </script>

@endpush