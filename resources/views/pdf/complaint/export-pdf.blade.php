<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Complaints Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .meta {
            text-align: center;
            font-size: 10px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }

        .status-pending {
            color: #b30000;
            font-weight: bold;
        }

        .status-complete {
            color: #006400;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .small {
            font-size: 10px;
        }
    </style>
</head>

<body>

    <h2>Complaints Report</h2>

    <div class="meta">
        Generated on: {{ now()->format('d M Y, h:i A') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Unique ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Room</th>
                <th>Department</th>
                <th>Remark</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($complaints as $index => $complaint)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>

                    <td>{{ $complaint->unique_id }}</td>

                    <td>{{ $complaint->name }}</td>

                    <td>{{ $complaint->mobile }}</td>

                    <td class="small">
                        Room: {{ $complaint->rooms->name ?? '-' }}<br>
                        Floor: {{ $complaint->rooms->floors->name ?? '-' }}<br>
                        Building: {{ $complaint->rooms->buildings->name ?? '-' }}
                    </td>

                    <td>
                        {{ $complaint->user->departments->name ?? '-' }}
                    </td>

                    <td>
                        {{ $complaint->complaint_details }}
                    </td>

                    <td
                        class="
                        {{ $complaint->status == 'pending' ? 'status-pending' : 'status-complete' }}
                    ">
                        {{ ucfirst($complaint->status) }}
                    </td>

                    <td>
                        {{ $complaint->created_at->format('d M Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">
                        No complaints found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
