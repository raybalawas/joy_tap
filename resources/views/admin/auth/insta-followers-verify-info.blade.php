<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['heading'] }}</title>
</head>
<body>
    <h1>{{ $data['heading'] }}</h1>
    <p>{{ $data['message'] }}</p>

    <h2>Followers & Groups Table:</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Followers</th>
                <th>Can Join Group</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>0 to 1000</td>
                <td>Tier One</td>
            </tr>
            <tr>
                <td>1000 to 10000</td>
                <td>Tier Two</td>
            </tr>
            <tr>
                <td>10000+</td>
                <td>Tier Three</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
