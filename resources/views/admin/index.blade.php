@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Property list</h2>
    <a href="{{route('admin.create')}}" class="edit btn btn-primary btn-sm mb-4">Add New</a>
    <table class="table table-bordered yajra-datatable">
        <thead>
        <tr>
            <th>Address</th>
            <th>Town</th>
            <th>County</th>
            <th>Country</th>
            <th>Description</th>
            <th>Bedrooms</th>
            <th>Bathrooms</th>
            <th>Property Type</th>
            <th>Price</th>
            <th>Sale/Rent</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop


@section('footer')

    <script type="text/javascript">

        $(function () {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('property.list') }}",
                columns: [
                    {data: 'address', name: 'address'},
                    {data: 'town', name: 'town'},
                    {data: 'county', name: 'county'},
                    {data: 'country', name: 'country'},
                    {data: 'description', name: 'description'},
                    {data: 'num_bedrooms', name: 'num_bedrooms'},
                    {data: 'num_bathrooms', name: 'num_bathrooms'},
                    {data: 'title', name: 'property_types.title'},
                    {data: 'price', name: 'price'},
                    {data: 'type', name: 'type'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', 'a.delete', function(e) {
            e.preventDefault();

            var $this = $(this);

            $.ajax({
                url: $this.attr('href'),
                type: 'delete',
                data: {},success: function(data){
                    location.reload();
                }
            });
        });
    </script>
@stop
