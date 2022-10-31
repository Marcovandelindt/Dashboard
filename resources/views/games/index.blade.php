@extends('app.layout')

@section('content')
<div class="row">
    <div class="col-xl-4 col-lg-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Games Played</h5>
              <span class="h6 font-weight-bold mb-0">{{ count($games) }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                <i class="fas fa-chart-bar"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Hours clocked</h5>
              <span class="h6 font-weight-bold mb-0">{{ $totalPlayTime }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                <i class="fas fa-chart-pie"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="card card-stats mb-4 mb-xl-0">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Most played this week</h5>
                <span class="h6 font-weight-bold mb-0">{{ $mostPlayedGame }}</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                  <i class="fas fa-chart-pie"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

<div class="row mt-5">
    <div class="col-lg-12">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th scope="col">Game</th>
                    <th scope="col">Platform</th>
                    <th scope="col">Session time</th>
                    <th scope="col">Date</th>
                    <th scope="col">Start time</th>
                    <th scope="col">End time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gameSessions as $gameSession)
                <tr>
                    <td>{{ $gameSession->game->name }}</td>
                    <td>{{ $gameSession->platform }}</td>
                    <td>{{ \App\Helpers\GameSessionHelper::convertToHours($gameSession->minutes_played, '%2d hours %02d minutes') }}</td>
                    <td>{{ $gameSession->date }}</td>
                    <td>{{ date('H:i', strtotime($gameSession->start_time)) }}</td>
                    <td>{{ date('H:i', strtotime($gameSession->end_time)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $gameSessions->links() }}
        </div>
    </div>
</div>
@endsection