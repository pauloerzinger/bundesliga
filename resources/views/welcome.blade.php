<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../favicon.ico">

    <title>Bundesliga</title>

    <link href="{{ asset('/css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/principal.css') }}" rel="stylesheet">

    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/js/popper.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/principal.js') }}"></script>

    <script type="text/javascript">
        $(function(){
            $(".teams").on("click",function(e){
                $.ajax( {
                    url: "/teamratio",
                    type: "GET",
                    data: {
                        teamId: $(this).attr('id')
                    },
                    success: function( data ) {
                        $("#team_ratio").html(data);
                    }
                })
            });
        });
    </script>
  </head>

  <body class="bg-light">
    <div class="container" id="main">
        <div class="card bg-white mb-3 cursor-pointer">
            <div class="card-header bg-info text-center text-white font-weight-bold">Bundesliga - Upcoming Matches</div>
            <div class="card-body">
                <table class="w-100" cellpadding="3">
                    <thead>
                        <tr>
                            <th class="text-center">Date/Time</th>
                            <th class="text-center" colspan="5">Teams</th>
                            <th class="text-center">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nextMatches as $match)
                            <tr>
                                <td class="text-center">{{ $match['date'] }}</td>
                                <td class="text-right">{{ $match['team1name'] }}</td>
                                <td class="text-center"><img src="{{ $match['team1icon'] }}"></td>
                                <td class="text-center">X</td>
                                <td class="text-center"><img src="{{ $match['team2icon'] }}"></td>
                                <td class="text-left">{{ $match['team2name'] }} </td>
                                <td class="text-center">{{ $match['location'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card bg-white mb-3 cursor-pointer">
            <div class="card-header bg-success text-center text-white font-weight-bold">Bundesliga - Teams</div>
            <div class="card-body">
                <table align="center">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="text-center">W</th>
                            <th class="text-center">L</th>
                            <th class="text-center">D</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                            <tr id="{{ $team['TeamId'] }}" class="teams">
                                <td><img src="{{ $team['TeamIconUrl'] }}" width="20" height="20"></td>
                                <td style="padding: 0px 25px 0px 5px; border-right: 1px solid black;">{{ $team['TeamName'] }}</td>
                                <td style="padding: 5px 25px; border-right: 1px solid black;">{{ (isset($team['win']) ? $team['win'] : '0') }}</td>
                                <td style="padding: 5px 25px; border-right: 1px solid black;">{{ (isset($team['lose']) ? $team['lose'] : '0') }}</td>
                                <td style="padding: 5px 25px; border-right: 1px solid black;">{{ (isset($team['draw']) ? $team['draw'] : '0') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card bg-white mb-3 cursor-pointer">
            <div class="card-header bg-info text-center text-white font-weight-bold">Bundesliga - Results per Match</div>
            <div class="card-body">
                <table class="w-100" cellpadding="3">
                    <thead>
                        <tr>
                            <th class="text-center">Date/Time</th>
                            <th class="text-center" colspan="7">Match Results</th>
                            <th class="text-center">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matches as $match)
                            <tr>
                                <td class="text-center">{{ $match['date'] }}</td>
                                <td class="text-right">{{ $match['team1name'] }}</td>
                                <td class="text-center"><img src="{{ $match['team1icon'] }}"></td>
                                <td class="text-center"><h2>{{ (isset($match['team1result']) ? $match['team1result'] : '') }}</h2></td>
                                <td class="text-center">X</td>
                                <td class="text-center"><h2>{{ (isset($match['team2result']) ? $match['team2result'] : '') }}</h2></td>
                                <td class="text-center"><img src="{{ $match['team2icon'] }}"></td>
                                <td class="text-left">{{ $match['team2name'] }} </td>
                                <td class="text-center">{{ $match['location'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {{ $matches->links() }}
                </nav>
            </div>
        </div>
    </div>
  </body>
</html>

