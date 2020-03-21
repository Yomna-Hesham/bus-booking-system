<table>
    <tr>
        @foreach($data['headers'] as $header)
            <th>{{ $header }}</th>
        @endforeach
    </tr>

    @foreach($data['body'] as $row)
        <tr>
            @foreach($row as $cell)
                <td>{{ $cell }}</td>
            @endforeach
        </tr>
    @endforeach
</table>
