<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../favicon.ico">

    <title>Bundesliga</title>

    <link href="<?php echo e(asset('/css/jquery-ui.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/principal.css')); ?>" rel="stylesheet">

    <script src="<?php echo e(asset('/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/principal.js')); ?>"></script>

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
                        <?php $__currentLoopData = $nextMatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($match['date']); ?></td>
                                <td class="text-right"><?php echo e($match['team1name']); ?></td>
                                <td class="text-center"><img src="<?php echo e($match['team1icon']); ?>"></td>
                                <td class="text-center">X</td>
                                <td class="text-center"><img src="<?php echo e($match['team2icon']); ?>"></td>
                                <td class="text-left"><?php echo e($match['team2name']); ?> </td>
                                <td class="text-center"><?php echo e($match['location']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr id="<?php echo e($team['TeamId']); ?>" class="teams">
                                <td><img src="<?php echo e($team['TeamIconUrl']); ?>" width="20" height="20"></td>
                                <td style="padding: 0px 25px 0px 5px; border-right: 1px solid black;"><?php echo e($team['TeamName']); ?></td>
                                <td style="padding: 5px 25px; border-right: 1px solid black;"><?php echo e((isset($team['win']) ? $team['win'] : '0')); ?></td>
                                <td style="padding: 5px 25px; border-right: 1px solid black;"><?php echo e((isset($team['lose']) ? $team['lose'] : '0')); ?></td>
                                <td style="padding: 5px 25px; border-right: 1px solid black;"><?php echo e((isset($team['draw']) ? $team['draw'] : '0')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <?php $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($match['date']); ?></td>
                                <td class="text-right"><?php echo e($match['team1name']); ?></td>
                                <td class="text-center"><img src="<?php echo e($match['team1icon']); ?>"></td>
                                <td class="text-center"><h2><?php echo e((isset($match['team1result']) ? $match['team1result'] : '')); ?></h2></td>
                                <td class="text-center">X</td>
                                <td class="text-center"><h2><?php echo e((isset($match['team2result']) ? $match['team2result'] : '')); ?></h2></td>
                                <td class="text-center"><img src="<?php echo e($match['team2icon']); ?>"></td>
                                <td class="text-left"><?php echo e($match['team2name']); ?> </td>
                                <td class="text-center"><?php echo e($match['location']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <nav>
                    <?php echo e($matches->links()); ?>

                </nav>
            </div>
        </div>
    </div>
  </body>
</html>

