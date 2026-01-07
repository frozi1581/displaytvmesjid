<div class="row my-4">
    <div class="col-md-4">
        <h3>{{ __('Profile Security') }}</h3>
        <p>{{ __("Your account's player token for run player.") }}</p>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-4">
                <div class="mb-3">
                    <div class="row d-flex align-items-end">
                        <div class="col-9">
                            <label class="form-label" for="player_token">{{ __('Player Token') }}</label>
                            <input class="form-control" id="player_token" value="{{ route('player', Auth::user()->mosque->player_token) }}" readonly>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-primary btn-block" onclick="copyPlayerLink()"> <i class="fas fa-copy"></i> {{ __('Salin Link') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
