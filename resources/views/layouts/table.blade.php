@section('modal-title', "Confirm Deletion")
@section('modal-body', "Are you sure you want to delete ?")
@section('modal-action-confirm', "confirmDelete()")
@section('modal-action-cancel', "cancelDelete()")

<table class="table">
    <tr>
        @foreach($data['headers'] as $header)
            <th>{{ $header }}</th>
        @endforeach
    </tr>

    @foreach($data['body'] as $row)
        <tr>
            @foreach($data['headers'] as $key => $value)
                <td>{{ $row[$key] }}</td>
            @endforeach

            @if(!(isset($enableEdit) && $enableEdit == false))
            <td>
                <a href="{{ route(strtolower($name).".edit", $row['id']) }}">
                    <button type="button" class="btn btn-info btn-sm">EDIT</button>
                </a>

                <button type="button" class="btn btn-danger btn-sm"
                        data-toggle="modal"
                        data-target="#confirm-action"
                        onclick="initiateDelete('{{ route(strtolower($name).'.destroy', $row['id']) }}')"
                >DELETE</button>
            </td>
            @endif
        </tr>
    @endforeach
</table>

@section('local-scripts')
    <script>
        var deleteUrl;

        function initiateDelete(url) {
            deleteUrl = url
        }

        function confirmDelete() {

            $.ajax({
                type: "DELETE",
                url: deleteUrl,
                success: function(msg){
                    console.log(msg);
                    location.href = "{{ route(strtolower($name).".index") }}"
                },
                error: function (res) {
                    console.log(res);
                    alert(res.responseText);
                }
            });
        }

        function cancelDelete() {
            deleteId = null;
        }
    </script>
@endsection
