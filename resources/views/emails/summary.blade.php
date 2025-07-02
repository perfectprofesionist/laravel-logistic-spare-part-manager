{{-- 
    Email Summary Template (emails/summary.blade.php)
    
    This Blade template generates an HTML email containing a detailed quote summary
    that is sent to administrators when a user submits a form. It displays product
    selections, pricing, fitment times, and additional user information.
    
    Features:
    - Professional HTML email layout with embedded CSS
    - Product summary table with pricing and quantities
    - Automatic calculation of totals and fitment hours
    - Additional user information display
    - Responsive table design for email clients
    - Clean, professional styling with brand colors
    
    Data Structure Expected:
    - $summary: Array of product items with description, price, quantity, total, fitmentTime
    - $additionalData: Array of user-provided additional information
    - $interests: Array of user interests (currently commented out)
    
    Email Components:
    - Quote summary table with product details
    - Total price and fitment hours calculation
    - Additional information section
    - Professional styling for email compatibility
--}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quote Summary</title>
    {{-- Embedded CSS for email compatibility (no external dependencies) --}}
    <style>
        {{-- Base body styling for consistent email appearance --}}
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        {{-- Section headers with background and border styling --}}
        h2 {
            background-color: #f5f5f5;
            padding: 10px;
            border-left: 5px solid #007BFF;
        }
        {{-- Main table styling for product summary --}}
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        {{-- Table cell styling with borders and padding --}}
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        {{-- Table header styling with brand color --}}
        th {
            background-color: #007BFF;
            color: white;
        }
        {{-- Details table styling for additional information --}}
        .details-table {
            width: 100%;
            border: 1px solid #ccc;
        }
        {{-- Details table cell styling --}}
        .details-table td {
            vertical-align: top;
            padding: 10px;
        }
        {{-- Details section title styling --}}
        .details-title {
            font-weight: bold;
            background-color: #f9f9f9;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

{{-- Main quote summary section header --}}
<h2>Quote Summary</h2>
    {{-- Product summary table --}}
    <table>
        {{-- Table header with column titles --}}
        <thead>
            <tr>
                <th>Description</th> {{-- Product description column --}}
                <th>Price</th> {{-- Individual product price column --}}
                <th>Quantity</th> {{-- Product quantity column --}}
                <th>Total</th> {{-- Line item total column --}}
                <th>Fitment Hours</th> {{-- Installation time column --}}
            </tr>
        </thead>
        <tbody>
            {{-- Initialize calculation variables --}}
            @php 
                $fitment_hours = 0; {{-- Total fitment hours accumulator --}}
                $total_price = 0; {{-- Total price accumulator --}}
            @endphp
            
            {{-- Loop through summary items if data exists --}}
            @if(!empty($summary)) 
                @foreach ($summary as $item)
                    {{-- Individual product row --}}
                    <tr>
                        <td>{{ $item['description'] }}</td> {{-- Product description --}}
                        <td>{{ $item['price'] }}</td> {{-- Product price --}}
                        <td>{{ $item['quantity'] }}</td> {{-- Product quantity --}}
                        <td>{{ $item['total'] }}</td> {{-- Line item total --}}
                        <td>{{ $item['fitmentTime'] }}</td> {{-- Fitment time for this item --}}
                    </tr>
                    
                    {{-- Calculate running totals --}}
                    @php 
                        {{-- Add fitment hours if valid numeric value --}}
                        if (isset($item['fitmentTime']) && is_numeric($item['fitmentTime'])) {
                            $fitment_hours += (float) $item['fitmentTime'];
                        }

                        {{-- Add to total price if valid numeric value (remove $ symbol) --}}
                        if (isset($item['total']) && is_numeric(str_replace('$', '', $item['total']))) {
                            $total_price += (float) str_replace('$', '', $item['total']);
                        }
                        
                    @endphp

                @endforeach
            @endif
        </tbody>
        
        {{-- Table footer with calculated totals --}}
        <tfoot>
            <tr>
                <th>
                    Total
                </th>
                <td></td> {{-- Empty cell for price column --}}
                <td></td> {{-- Empty cell for quantity column --}}
                <td>${{ $total_price }}</td> {{-- Calculated total price --}}
                <td>
                    {{ $fitment_hours }} {{-- Calculated total fitment hours --}}
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- Additional information section header --}}
    <h2>Additional Info & Selected Interests</h2>
    {{-- Additional details table --}}
    <table class="details-table">
        <tr>
            <td width="50%">
                {{-- Additional details section title --}}
                <div class="details-title">Additional Details</div>
                <ul>
                    {{-- Loop through additional data if available --}}
                    @if(!empty($additionalData)) 
                        @foreach ($additionalData as $label => $value)
                            <li><strong>{{ $label }}:</strong> 
                                
                                {{-- Handle both array and string values --}}
                                @if(is_array($value))
                                    {{ implode(', ', $value) }} {{-- Join array values with commas --}}
                                @else
                                    {{ $value }} {{-- Display string value directly --}}
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
                {{-- Interests section (currently commented out for future use) --}}
                {{-- <li><strong>Selected Interests:</strong> 
                    {{ is_array($interests) ? implode(', ', $interests) : $interests }}
                </li> --}}
                <ul>
                </ul>
            </td>
        </tr>
    </table>

</body>
</html>
