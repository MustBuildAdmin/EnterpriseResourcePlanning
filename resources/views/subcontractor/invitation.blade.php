<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sub Contractor Invitation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            display: grid;
            place-items: center;
            height: 100vh;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .button-container {
            margin-top: 20px;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .expired {
            font-size: 24px;
            color: #dc3545; /* Red color */
        }
        .accepted {
            font-size: 24px;
            color: #4caf50; /* Red color */
        }
        .btn-container {
            display: flex;
            justify-content: center;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .accept {
            background-color: #4caf50;
            color: #fff;
        }
        .decline {
            background-color: #f44336;
            color: #fff;
        }
        .accept a,.decline a{
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        @if($msg=='expired')
            <h1 class="expired">Invitation Expired</h1>
            <p>The invitation you received from {{$companyDetails->company_name}} has expired or is no longer valid.</p>
            <div class="button-container">
                <a class="button" href="/">Go to Home</a>
            </div>
        @elseif($msg=='declined')
            <h1 class="expired">Invitation Declined</h1>
            <p>The invitation you received from {{$companyDetails->company_name}} has declined.</p>
            <div class="button-container">
                <a class="button" href="/">Go to Home</a>
            </div>
        @elseif($msg=='accepted')
            <h1 class="accepted">Invitation Accepted</h1>
            <p>The invitation you received from {{$companyDetails->company_name}} has successfully accepted.</p>
            <div class="button-container">
                <a class="button" href="/">Go to Home</a>
            </div>
        @else
            <h1>Sub Contractor Invitation</h1>
            <p>
                You have received an invitation to collaborate on a subcontractor for this company
                 {{$companyDetails->company_name}}.
            </p>
            <div class="btn-container">
                <button class="btn accept">
                    <a href="/company-invitation-subcontractor/{{$checkConnection->id}}/accepted">Accept</a>
                </button>
                <button class="btn decline">
                    <a href="/company-invitation-subcontractor/{{$checkConnection->id}}/decline">Decline</a>
                </button>
            </div>
        @endif
    </div>
</body>
</html>
