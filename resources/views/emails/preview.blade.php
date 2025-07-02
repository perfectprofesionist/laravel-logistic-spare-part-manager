{{-- 
    Email Quote Summary Preview Template (emails/preview.blade.php)
    
    This Blade template provides a preview of the quote summary email before it is sent.
    It displays a summary table of selected products, additional user data, and selected interests.
    It also includes a form to confirm and send the email with all relevant data as hidden fields.
    
    Features:
    - HTML table summary of products/services
    - Display of additional user-provided data
    - Display of selected interests
    - Confirmation form to send the email
    - Simple, clean styling for preview clarity
    
    Data Structure Expected:
    - $summary: Array of items with description, price, quantity, total
    - $additionalData: Array of additional user data
    - $interests: Array or JSON string of selected interests
    
    Usage:
    - Used as a preview step before sending the final quote summary email
    - Allows user/admin to review all details before confirmation
    - Ensures data accuracy and transparency
--}}

<!DOCTYPE html>
<html>
<head>
    <title>Preview Quote Summary</title>
    {{-- Embedded CSS for table styling and clarity --}}
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>

    {{-- Quote summary section header --}}
    <h2>Summary</h2>
    {{-- Product/service summary table --}}
    <table>
        <thead>
            <tr>
                <th>Description</th> {{-- Product/service description --}}
                <th>Price</th> {{-- Price per item --}}
                <th>Quantity</th> {{-- Quantity selected --}}
                <th>Total</th> {{-- Line item total --}}
            </tr>
        </thead>
        <tbody>
            {{-- Loop through summary items --}}
            @foreach ($summary as $item)
                <tr>
                    <td>{{ $item['description'] }}</td>
                    <td>{{ $item['price'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Additional user data section --}}
    <h2>Additional Data</h2>
    <ul>
        {{-- Loop through additional data and display each key/value --}}
        @foreach ($additionalData as $key => $value)
            <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>

    {{-- Selected interests section --}}
    @php
    $interestsArray = is_string($interests) ? json_decode($interests, true) : $interests;
@endphp

<h2>Selected Interests</h2>
@if (!empty($interestsArray))
    <p>{{ implode(', ', $interestsArray) }}</p>
@else
    <p>No interests selected.</p>
@endif

    {{-- Confirmation form to send the email --}}
    <form method="POST" action=">
        @csrf
        {{-- Hidden fields to pass all summary data to the backend --}}
        <input type="hidden" name="summary" value="{{ json_encode($summary) }}">
        <input type="hidden" name="interests" value="{{ json_encode($interests) }}">
        <input type="hidden" name="additional_data" value="{{ json_encode($additionalData) }}">
        <button type="submit">Confirm and Send Email</button>
    </form>

</body>
</html>
