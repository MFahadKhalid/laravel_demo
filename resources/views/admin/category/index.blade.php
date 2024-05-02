@extends('layouts.scaffold')
@push('title')
    {{ $title ?? '' }}
@endpush
@push('styles')
<style>
    .no-drop {
        cursor: no-drop;
    }
</style>
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="card mt-5">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3>{{ $title ?? '' }}</h3>
                </div>
                <div class="col-md-6">
                    <div class="float-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddCategory">Add Category</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content rounded-bottom bg-white ">
                <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1005">
                  <table class="table table-hover table-striped" id="CategoryTable">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
        </div>
    </div>

  @include('pages.category.create')
  @include('pages.category.edit')
@endsection
@section('script')
@include('partial.admin-script')

@endsection
@push('scripts')


  

    <script>
          $(document).ready(function (){
            $('#CategoryTable').DataTable({
                ajax: {
                    url: "{{ route('category.list') }}",
                    dataSrc: 'categories',
                },
                columns: [{
                    data: "name",
                },
                {
                    data: "status",
                    render: function (data, type, row) {
                        return data === 1 ? '<span class="badge bg-success text-light">Active</span>' : '<span class="badge bg-danger text-light">Inactive</span>';
                    }
                },
                {
                    data: "action",
                    searchable: false,
                    orderable: false,
                },
                ],
                deferRender: true,
                processing: true,
                serverSide: true,
                autoWidth: true,
                responsive: true,
                info: true,
                paging: true,
                order:[
                    [0,'asc']
                ],
            });
        });
        $(document).on('submit' , '#createCategory', async function(event) {
            event.preventDefault();
            const createCategory = $(this);
            const formData = new FormData(createCategory[0]);

            createCategory.find('input, select ,button').addClass('no-drop').attr('disabled' , true);
            createCategory.find('.is-invalid').removeClass('is-invalid');
            createCategory.find('.invalid-feedback').remove();
            try{
                const response = await $.ajax({
                    url: "{{ route('category.store') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers:{
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                $('#AddCategory').modal('hide');
                $('div').removeClass('modal-backdrop');
                swal({
                    icon: 'success',
                    title: 'Category created',
                });
                $('#CategoryTable').DataTable().ajax.reload(null,false);
                createCategory.get(0).reset();
            }catch (err) {
                    if (err.status === 422) {
                        const errors = err.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            const err = errors[key];
                            const input = createCategory.find(`[name="${key}"]`);
                            if (input.length > 0) {
                                input.addClass('is-invalid');
                                input.parent().append(
                                    $("<span class='invalid-feedback'>").html(err.join('<br/>'))
                                );
                            } else {
                                console.error(`Input with name ${key} doesn't exist!`);
                            }
                        });
                    }
                }
                createCategory.find('input, select ,button').removeClass('no-drop').removeAttr('disabled');
        });
        $(document).on('click' , '.category-edit' , async function (event) {
            const btn = $(this)[0];
            try{
                const category_id = btn.getAttribute('data-category-id');
                btn.setAttribute('disabled' , true);

                const response = await $.ajax({
                    method: "GET",
                    url: "{{ route('category.show' , '__CATEGORY_ID__')  }}".replace('__CATEGORY_ID__', category_id),
                });

                const categoryDetails = response.category;

                $('#EditCategory [name="name"]').val(categoryDetails.name);
                $('#EditCategory [name="status"]').val(categoryDetails.status).prop('selected', true);
                $('#EditCategory').attr('data-category-id',category_id);
                $('#EditCategory').modal('show');
            } catch (err) {
                console.log(err)
            }
            btn.removeAttribute('disabled');
        });
        $(document).on('submit' , '#updateCategory' , async function(event) {
            event.preventDefault();
            const UpdateCategory = $(this);
            const category_id = $('#EditCategory').attr('data-category-id');
            const formData = new FormData(UpdateCategory.get(0));
            try{
                UpdateCategory.find('input, select ,button').addClass('no-drop').attr('disabled', true);
                UpdateCategory.find('.is-invalid').removeClass('is-invalid');
                UpdateCategory.find('.invalid-feedback').remove();

                const response = await $.ajax({
                    url: "{{ route('category.update','__CATEGORY_ID__') }}".replace('__CATEGORY_ID__',category_id),
                    method: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                });

                $('#EditCategory').modal('hide');
                swal({
                    icon: 'success',
                    title: 'Category updated',
                });
                $("#CategoryTable").DataTable().ajax.reload(null, false);
                UpdateCategory.get(0).reset();
            }   catch (err) {
                    if (err.status === 422) {
                        const errors = err.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            const err = errors[key];
                            const input = UpdateCategory.find(`[name="${key}"]`);
                            if (input.length > 0) {
                                input.addClass('is-invalid');
                                input.parent().append(
                                    $("<span class='invalid-feedback'>").html(err.join('<br/>'))
                                );
                            } else {
                                console.error(`Input with name ${key} doesn't exist!`);
                            }
                        });
                    }
                }
                UpdateCategory.find('input, select ,button').removeClass('no-drop').removeAttr('disabled');
        });
        $(document).on('click' , '.category-delete' , async function(event) {
            const category_id = $(this).attr('data-category-id');
            const result = await swal({
                icon: 'warning',
                title: 'Are you sure you want to delete this data?',
                buttons: {
                    cancel: 'No',
                    confirm: 'Yes'
                },
            });

            const formData = new FormData();
            formData.append('_method', 'DELETE');

            if(result.buttons,confirm){
                try{
                    const resposne = await $.ajax({
                        method: "DELETE",
                        url: "{{ route('category.delete','__CATEGORY_ID__') }}".replace('__CATEGORY_ID__' , category_id),
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                    })
                    swal({
                        icon: 'success',
                        title: "Category deleted",
                    });
                    $("#CategoryTable").DataTable().ajax.reload(null, false);
                } catch (err) {
                        swal({
                            icon: 'error',
                            title: `${err.status} Error occured while deleting record!`,
                            html: err.message
                        });
                }
            }
        })
    </script>
@endpush
