<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use Illuminate\Pagination\LengthAwarePaginator;

class WelcomeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $date = date('Y'); //Current Year
        $today = date('Ymd'); //Current Day
        $teams = json_decode(file_get_contents("https://www.openligadb.de/api/getavailableteams/bl1/".$date), true);
        $nextMatches = Array();//json_decode(file_get_contents("https://www.openligadb.de/api/getmatchdata/bl1"), true);
        $resultsPerMatch = json_decode(file_get_contents("https://www.openligadb.de/api/getmatchdata/bl1/".$date), true);

        $matches = Array();   

        foreach ($resultsPerMatch as $match) {
            $aux = Array();
            $aux['date'] = date("D - d M Y - H:i", strtotime($match['MatchDateTime']));
            $aux['location'] = $match['Location']['LocationStadium'].', '.$match['Location']['LocationCity'];
            $aux['team1id'] = $match['Team1']['TeamId'];
            $aux['team1name'] = $match['Team1']['TeamName'];
            $aux['team1icon'] = $match['Team1']['TeamIconUrl'];
            $aux['team2id'] = $match['Team2']['TeamId'];
            $aux['team2name'] = $match['Team2']['TeamName'];
            $aux['team2icon'] = $match['Team2']['TeamIconUrl'];

            $date = date("Ymd", strtotime($match['MatchDateTime']));

            if($date >= $today && count($nextMatches) <= 10){
                array_push($nextMatches, $aux);
            }

            foreach ($match['MatchResults'] as $matchResult) {
                $aux['team1result'] = $matchResult['PointsTeam1'];
                $aux['team2result'] = $matchResult['PointsTeam2'];
            }

            if(isset($aux['team1result'])) {
                if($aux['team1result'] > $aux['team2result']){
                    $pos = array_search($aux['team1id'], array_column($teams, 'TeamId'));

                    if(array_key_exists('win', $teams[$pos])){
                        $teams[$pos]['win'] = $teams[$pos]['win'] + 1;
                    } else {
                        $teams[$pos]['win'] = 1;
                    }

                    $pos = array_search($aux['team2id'], array_column($teams, 'TeamId'));

                    if(array_key_exists('lose', $teams[$pos])){
                        $teams[$pos]['lose'] = $teams[$pos]['lose'] + 1;
                    } else {
                        $teams[$pos]['lose'] = 1;
                    }

                } elseif($aux['team1result'] < $aux['team2result']) {
                    
                    $pos = array_search($aux['team2id'], array_column($teams, 'TeamId'));

                    if(array_key_exists('win', $teams[$pos])){
                        $teams[$pos]['win'] = $teams[$pos]['win'] + 1;
                    } else {
                        $teams[$pos]['win'] = 1;
                    }

                    $pos = array_search($aux['team1id'], array_column($teams, 'TeamId'));
                    
                    if(array_key_exists('lose', $teams[$pos])){
                        $teams[$pos]['lose'] = $teams[$pos]['lose'] + 1;
                    } else {
                        $teams[$pos]['lose'] = 1;
                    }

                } else {

                }
            }

            array_push($matches, $aux);
        }
        
        foreach ($teams as $key => $row) {
            $win[$key] = (isset($row['win']) ? $row['win'] : 0);
        }

        // Ordena os dados por volume decrescente, edition crescente.
        // Adiciona $data como último parâmetro, para ordenar por uma chave comum.
        array_multisort($win, SORT_DESC, SORT_NUMERIC, $teams);

        $matches = WelcomeController::paginate($matches, 20);

        return view("welcome", compact('teams','nextMatches','matches'));
    }

    function paginate($items, $perPage)
    {
        if(is_array($items)){
            $items = collect($items);
        }

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items->forPage(\Illuminate\Pagination\Paginator::resolveCurrentPage() , $perPage),
            $items->count(), $perPage,
            \Illuminate\Pagination\Paginator::resolveCurrentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
    }
}
