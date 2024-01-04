<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://demomustbuildapp.s3.ap-southeast-1.amazonaws.com/uploads/logo/favicon.png" type="image/x-icon"/>
    <title>{{ __('Project Invitation') }}</title>
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
            color: #dc3545;
            /* Red color */
        }

        .accepted {
            font-size: 24px;
            color: #4caf50;
            /* Red color */
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

        .accept a,
        .decline a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        @if ($msg == 'expired')
            <h1 class="expired">{{ __('Invitation Expired') }}</h1>
            <p>{{ __('The invitation you received from') }} {{ $project->project_name }} {{ __('has expired or is no longer valid.') }}</p>
            <div class="button-container">
                <a class="button" href="{{ env('APP_URL') }}">
                    {{ __('Go to Home') }}
                </a>
            </div>
        @elseif($msg == 'declined')
            <h1 class="expired">{{ __('Invitation Declined') }}</h1>
            <p>{{ __('The invitation you received from') }} {{ $project->project_name }} {{ __('has declined.') }}</p>
            <div class="button-container">
                <a class="button" href="{{ env('APP_URL') }}">
                    {{ __('Go to Home') }}
                </a>
            </div>
        @elseif($msg == 'accepted')
            <h1 class="accepted">{{ __('Invitation Accepted') }}</h1>
            <p>{{ __('The invitation you received from') }} {{ $project->project_name }} {{ __('has successfully accepted.') }}</p>
            <div class="button-container">
                <a class="button" href="{{ env('APP_URL') }}">
                    {{ __('Go to Home') }}
                </a>
            </div>
        @elseif($type == 'sub contractor')
            <h1>{{ __('Project Sub Contractor Invitation') }}</h1>
            <p>
                {{ __('You have received an invitation to collaborate on a') }} {{ $type }} {{ __('for this project') }}
                {{ $project->project_name }}.
            </p>
            <div class="btn-container">
                <button class="btn accept">
                    <a
                        href="{{ env('APP_URL') }}/company-invitation-subcontractor-project/{{ $checkConnection->id }}/accepted">
                        {{ __('Accept') }}
                    </a>
                </button>
                <button class="btn decline">
                    <a
                        href="{{ env('APP_URL') }}/company-invitation-subcontractor-project/{{ $checkConnection->id }}/declined">
                        {{ __('Decline') }}
                    </a>
                </button>
            </div>
        @elseif($type == 'consultant')
            <h1>{{ __('Project Consultant Invitation') }}</h1>
            <p>
                {{ __('You have received an invitation to collaborate on a') }} {{ $type }} {{ __('for this project') }}
                {{ $project->project_name }}.
            </p>
            <div class="btn-container">
                <button class="btn accept">
                    <a
                        href="{{ env('APP_URL') }}/company-invitation-consultant-project/{{ $checkConnection->id }}/accepted">
                        {{ __('Accept') }}
                    </a>
                </button>
                <button class="btn decline">
                    <a
                        href="{{ env('APP_URL') }}/company-invitation-consultant-project/{{ $checkConnection->id }}/declined">
                        {{ __('Decline') }}
                    </a>
                </button>
            </div>
        @elseif($type == 'team member')
            <h1>{{ __('Project Team Member Invitation') }}</h1>
            <p>
                {{ __('You have received an invitation to collaborate on a') }} {{ $type }} {{ __('for this project') }}
                {{ $project->project_name }}.
            </p>
            <div class="btn-container">
                <button class="btn accept">
                    <a href="{{ env('APP_URL') }}/company-invitation-teammember/{{ $checkConnection->id }}/accepted">
                        {{ __('Accept') }}
                    </a>
                </button>
                <button class="btn decline">
                    <a href="{{ env('APP_URL') }}/company-invitation-teammember/{{ $checkConnection->id }}/declined">
                        {{ __('Decline') }}
                    </a>
                </button>
            </div>
        @else
            <h1>{{ __('Project Invitation') }}</h1>
            <p>
                {{ __('You have received an invitation to collaborate on a') }} {{ $type }} {{ __('for this project') }}
                {{ $project->project_name }}.
            </p>
            <div class="btn-container">
                <button class="btn accept">
                    <a href="{{ env('APP_URL') }}/company-invitation-teammember/{{ $checkConnection->id }}/accepted">
                        {{ __('Accept') }}
                    </a>
                </button>
                <button class="btn decline">
                    <a href="{{ env('APP_URL') }}/company-invitation-teammember/{{ $checkConnection->id }}/declined">
                        {{ __('Decline') }}
                    </a>
                </button>
            </div>
        @endif
    </div>
</body>

</html>
