<!DOCTYPE html>
<html>
<head>
    <title>Feedback Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h3>Feedback Report</h3>
    <table>
        <thead>
            <tr>
                <th>Unique ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Room</th>
                <th>Rating</th>
                <th>Label</th>
                <th>Comments</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($feedbacks as $fb)
            <tr>
                <td>{{ $fb->unique_id }}</td>
                <td>{{ $fb->name }}</td>
                <td>{{ $fb->mobile }}</td>
                <td>{{ $fb->rooms->name ?? '-' }}</td>
                <td>{{ $fb->rating }}%</td>
                <td>{{ $fb->rating_label }}</td>
                <td>{{ $fb->comments }}</td>
                <td>{{ $fb->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
