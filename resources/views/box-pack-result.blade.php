<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Packing Result</title>
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            /* Same with the form view, I use css instead of tailwind type class  */
            body {
                font-family: 'Figtree', sans-serif;
                background-color: #f3f4f6;
                color: #1f2937;
                line-height: 1.5;
                padding: 2rem;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
            }
            h1 {
                font-size: 2.5rem;
                font-weight: 600;
                color: #111827;
                margin-bottom: 2rem;
                text-align: center;
            }
            .box {
                background-color: #ffffff;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                padding: 1.5rem;
                margin-bottom: 2rem;
            }
            .box h2 {
                font-size: 1.5rem;
                font-weight: 600;
                color: #2563eb;
                margin-bottom: 1rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .box h2 span {
                font-size: 1rem;
                color: #6b7280;
                font-weight: 400;
            }
            ul {
                list-style-type: none;
                padding: 0;
            }
            li {
                background-color: #f9fafb;
                border: 1px solid #e5e7eb;
                border-radius: 0.25rem;
                padding: 0.75rem 1rem;
                margin-bottom: 0.5rem;
                font-size: 0.95rem;
            }
            li:last-child {
                margin-bottom: 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Packing Result</h1>

            @foreach($packedBoxes as $index => $packedBox)
                <div class="box">
                    <h2>
                        {{ $packedBox['box']->name }}
                        <span>{{ number_format($packedBox['totalWeight'], 2) }} Kg</span>
                    </h2>
                    <ul>
                        @foreach($packedBox['items'] as $item)
                            <li>
                                {{ $item->name }} 
                                (L{{ $item->length }} x W{{ $item->width }} x H{{ $item->height }}, 
                                {{ number_format($item->weight * $item->quantity, 2) }} kg)
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </body>
</html>