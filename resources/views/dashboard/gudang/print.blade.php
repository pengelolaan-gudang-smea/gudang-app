<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print QR Code</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .print-area {
            page-break-before: always;
            page-break-inside: avoid;
        }

        .print-area img {
            width: 100%;
            height: 100%;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .print-area {
                page-break-before: always;
                page-break-inside: avoid;
            }

            .print-area img {
                width: 100%;
                height: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="print-area">
        <img src="{{ $qrCodeUrl }}" alt="QR Code" class="img-fluid">
    </div>

    <script>
        window.onload = function() {
            window.print();
        };

    </script>
</body>
</html>
